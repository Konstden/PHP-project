<?php 
namespace Ijdb\Controllers;
use Ninja\DatabaseTable;

class Register 
{
    private $authorsTable;

    public function __construct(DatabaseTable $authorsTable) {
        $this->authorsTable = $authorsTable;
    }

    public function registrationForm() {
        return [
            'template' => 'register.php',
            'title' => 'Register an account'
        ];
    }
        public function success() {
            return [
                'template' => 'registersuccess.php',
                'title' => 'Register Successful'
            ];
    }
    public function registerUser() {        
        $author = $_POST['author'];

        $valid = true;
        $errors = [];
        if (empty($author['name'])) {
            $errors[] = 'Name cannot be blank';
        }

        if (empty($author['email'])) {
            $valid = false; 
            $errors[] = 'Email cannot be blank';
        } else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
            $valid = false;
            $errors[] = 'Invalid email address';
        } else {
            $author['email'] = strtolower($author['email']);

            if (count($this->authorsTable->find('email', $author['email'])) > 0) {
                $valid = false;
                $errors[] = 'That email address is already registered';
            }
        }
        if (empty($author['password'])) {
            $valid = false;
            $errors[] = "Password cannot be blank";
        }
        
        if ($valid == true) {
            $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);

            $this->authorsTable->save($author);
            header('location: index.php?author/success');
        } else {
                return [
                    'template' => 'register.php',
                    'title' => 'Register an account',
                    'variables' => [
                        'errors' => $errors,
                        'author' => $author
                    ]
                ];
            }

    }
}
