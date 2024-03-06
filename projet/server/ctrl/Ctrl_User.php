<?php

/*
  But     : Ctrl pour les users
  Auteur  : Romain Benedetti
  Date    : 01.03.2024 / v1.0
*/

require_once('SessionManager.php');
require_once('./beans/User.php');

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
            $user->setusername($username);
            $user->setemail($email);
            $user->setpassword($hashPassword);
            $wrk = new WrkLogin();
            $wrk->createProfile($user);
        } else {
            //La requete est incomplète ou mal formulée
            echo 400;
        }
    }

    public function signIn($username, $password)
    {
        if (!empty($username) && !empty($password)) {
            $_SESSION['username'] = htmlspecialchars($username);
            $_SESSION['password'] = $password;
            $_SESSION['isConnected'] = false;

            $this->SessionManager->set('username', $username);
        } else {
            //La requete est incomplète ou mal formulée
            echo 400;
        }
    }
}
