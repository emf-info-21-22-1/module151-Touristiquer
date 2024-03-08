<?php

/*
  But     : Ctrl pour les users
  Auteur  : Romain Benedetti
  Date    : 01.03.2024 / v1.0
*/

require_once('SessionManager.php');
require_once('./beans/User.php');
require_once('./wrk/wrkLogin.php');

class Ctrl_User
{
    private $SessionManager;

    public function __construct()
    {
        $this->SessionManager = SessionManager::getInstance();
    }

    //check si le login est ok echo 200 si oui et 401 si nonb
    public function TestLogin($username, $password)
    {
        if (!empty($username) && !empty($mail) && !empty($password)) {
            $user = new User(null, $username, null, $password);

            $wrk = new wrkLogin();

            $wrk->TestLogin($user);

            //Logique de la session en settant les variables de session et écriture de la réponse en JSON

        } else {
            echo 400;
        }
    }

    public function CheckIfConnected(): void
    {
        if (isset($_SESSION['isConnected']) && $_SESSION['isConnected']) {
            echo json_encode(array('isConnected' => true));
        } else {
            echo json_encode(array('isConnected' => false));
        }
    }

    public function listAllUsers(): void
    {
    }

    public function signUp($username, $email, $password): void
    {
        if (!empty($username) && !empty($email) && !empty($password)) {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = new User(null, $username, $email, $hashPassword);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($hashPassword);
            $wrk = new WrkLogin();
            var_dump($user);
            $wrk->createProfile($user);
        } else {
            //La requete est incomplète ou mal formulée
            http_response_code(400);
        }
    }

    public function signIn($username, $password)
    {
        $wrk = new wrkLogin();
        $user = $wrk->getUserByUsername($username);

        if ($user) {
            // Vérifier le mot de passe entré par l'utilisateur avec password_verify
            if (password_verify($password, $user->getPassword())) {
                // Mettre la pk du user dans $_SESSION à l'aide du session manager
                $_SESSION['pk_user'] = $user->getPk();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                // Renvoye les variables 
                echo json_encode(array('success' => true, 'message' => 'Login successful', 'pk_user' => $_SESSION['pk_user'], 'username' => $_SESSION['username'], 'email' => $_SESSION['email']));
            } else {
                // Renvoye que le password n'est pas bon
                http_response_code(401); //informations d'identification incorrectes.
                echo json_encode(array('success' => false, 'message' => 'Incorrect password'));
            }
        } else {
            // Renvoye un message si l'user n'existe pas
            http_response_code(401); //informations d'identification incorrectes.
            echo json_encode(array('success' => false, 'message' => 'User not found'));
        }
    }

    public function disconnect()
    {
        $wrk = new wrkLogin();
        return $wrk->disconnect();
    }
}
