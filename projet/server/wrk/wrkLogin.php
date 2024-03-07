<?php
require_once('Connexion.php');
require_once('./ctrl/Ctrl_User.php');


class wrkLogin
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connexion::getInstance();
    }


    // Vérifie le login et retourne vrai si c'est correct
    public function TestLogin($user)
    {
        $return = false;

        $params = array("username" => $user->getUsername(), "email" => $user->getMail());

        // Vérifier si l'utilisateur existe avec le nom d'utilisateur ou l'adresse e-mail
        $userData = $this->connection->selectSingleQuery('SELECT * FROM t_user WHERE username=:username OR email=:email', $params);

        if ($userData) {
            // L'utilisateur existe
            $password = $userData['password'];
            if (password_verify($user->getPassword(), $password)) {
                // Le mot de passe correspond
                $return = true;
            } else {
                // Le mot de passe est incorrect
                $return = false;
            }
        } else {
            // L'utilisateur n'existe pas
            $return = false;
        }

        return $return;
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM t_user WHERE username = :username";

        // Préparation de la déclaration
        $statement = $this->connection->selectSingleQuery($query);

        // Liaison des paramètres
        $statement->bindParam(':username', $username);
        $statement->execute();

        // Récupération du résultat
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le select a trouvé l'user
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }


    public function createProfile($user)
    {
        $return = false;

        $params = array("username" => $user->getUsername());

        // Vérifier si le nom d'utilisateur existe déjà
        $existingUsername = $this->connection->selectSingleQuery('SELECT * FROM t_user WHERE username=:username', $params);

        $params = array("email"  => $user->getMail());

        // Vérifier si l'adresse e-mail existe déjà
        $existingEmail = $this->connection->selectSingleQuery('SELECT * FROM t_user WHERE email=:email', $params);

        if (!$existingUsername && !$existingEmail) {
            // Ni le nom d'utilisateur ni l'adresse e-mail existent encore
            $query = 'INSERT INTO t_user (username, email, password) VALUES (:username, :email, :password)';
            $params = array("username" => $user->getUsername(), "email" => $user->getEmail(), "password" => $user->getPassword());

            if ($this->connection->executeQuery($query, $params)) {
                $return = true;
            } else {
                $return = false;
            }
        } elseif ($existingUsername) {
            // Le nom d'utilisateur existe déjà
            $return = 'usernameExists';
        } elseif ($existingEmail) {
            // L'adresse e-mail existe déjà
            $return = 'emailExists';
        }

        return $return;
    }


    public function disconnect()
    {
        // Simplement détruire la session actuelle pour déconnecter l'utilisateur
        session_destroy();
    }
}
