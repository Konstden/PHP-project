<?php
class JokeController {
        private $authorsTable;
        private $jokesTable;

        public function __construct(DatabaseTable $jokesTable, 
        DatabaseTable $authorsTable)
        {
            $this->jokesTable = $jokesTable;
            $this->authorsTable = $authorsTable;
        }

        public function list() {
            $result = $this->jokesTable->findAll();
            $jokes = [];
            foreach($result as $joke) {
                $author = $this->authorsTable->findById($joke['authorid']);
                $jokes[] = [
                    'id' => $joke['id'],
                    'joketext' => $joke['joketext'],
                    'jokedate' => $joke['jokedate'],
                    'name' => $author['name'],
                    'email' => $author['email']
                ];
            }

            $title = 'Joke List';
            $totaljokes = $this->jokesTable->total();

            ob_start();
            include __DIR__ . '/../templates/joke.php';
            $output = ob_get_clean();

            return ['output' => $output, 'title' => $title];
        }

        public function delete() {
            $result = $this->jokesTable->delete($_POST['id']);        
            header('location: joke.php');
        }

        public function edit() {
            if (isset($_POST['joke'])) {
                $joke = $_POST['joke'];
                $joke['jokedate'] = new DateTime();
                $joke['authorid'] = 1;
                $this->jokesTable->save($joke);

                header('location: joke.php');
            } else {
                if (isset($_GET['id'])) {
                    $joke = $this->jokesTable->findById($_GET['id']);
                }
                    
                $title = "Edit joke";

                ob_start();
                include __DIR__ . '/../templates/editjoke.php';
                $output = ob_get_clean();
            }

            return ['output' => $output, 'title' => $title];
            
        }


        public function home() {
            $title = 'Internet Joke Database';

            ob_start();
            include __DIR__ . '/../templates/home.php';
            $output = ob_get_clean();

            return ['output' => $output, 'title' => $title];
        }
    }