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
        $this->SessionManager = new SessionManager();
    }

    //check si le login est ok echo 200 si oui et 401 si non
    public function TestLogin($Username, $Email, $Password)
    {
        if (!empty($username) && !empty($mail) && !empty($password)) {
            $user = new User(null, $Username, $Email, $Password);

            if ($this->SessionManager->TestLogin($user)) {
                echo 200;
            } else {
                echo 401;
            }
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

    public function signUp($Username, $Email, $Password): void
    {
        if (!empty($Username) && !empty($Email) && !empty($Password)) {
            $hashPassword = password_hash($Password, PASSWORD_DEFAULT);
            $user = new User(null, $Username, $Email, $hashPassword);
            $user->setUsername($Username);

            if ($this->SessionManager->signUp($Username, $Email, $Password)) {
                echo 200;
            } else {
                //Une erreur est survenue et le profil n'a pas été créé
                echo 500;
            }
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

            if ($this->SessionManager->signIn($username, $password)) {
                echo 200;
            } else {
                //Une erreur est survenue et le profil n'a pas été créé
                echo 500;
            }
        } else {
            //La requete est incomplète ou mal formulée
            echo 400;
        }
    }
}
