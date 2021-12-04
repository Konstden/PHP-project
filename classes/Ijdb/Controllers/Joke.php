<?php
namespace Ijdb\Controllers; 
use \Ninja\DatabaseTable;

class Joke {
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

            return [
                'template' => 'joke.php',
                'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null,
                    'jokes' => $jokes ?? null,
                    'totalJokes' => $totaljokes
                ]
            ];
        }

        public function delete() {
            $result = $this->jokesTable->delete($_POST['id']);        
            header('location: /joke/list');
        }

        public function edit() {
            if (isset($_POST['joke'])) {
                $joke = $_POST['joke'];
                $joke['jokedate'] = new \DateTime();
                $joke['authorid'] = 1;
                $this->jokesTable->save($joke);

                header('location: /');
            } else {
                if (isset($_GET['id'])) {
                    $joke = $this->jokesTable->findById($_GET['id']);
                }
                    
                $title = "Edit joke";

            }

            return [
                'template' => 'editjoke.php',
                'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null,
                ]
            ];
            
        }


        public function home() {
            $title = 'Internet Joke Database';

            return [
                'template' => 'home.php',
                'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null
                ]
            ];
        }
    }