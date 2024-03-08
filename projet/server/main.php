<?php

header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

/*
  But     : Script principal
  Auteur  : Romain Benedetti
  Date    : 09.02.2024 / V1.0 
*/

// Variable racine de mon projet serveur. A permis de régler des problèmes d'hébergement.
const PATH = __DIR__;

include_once('ctrl/Ctrl_Title.php');
include_once('ctrl/Ctrl_User.php');

session_start();

// Switch case sur les méthodes HTTP autorisées
if (isset($_SERVER['REQUEST_METHOD'])) {
    // Récupérer le contenu de la requête POST
    $json_data = file_get_contents('php://input');
    // Décoder les données JSON
    $data = json_decode($json_data, true);
    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            if ($data != null) {
                switch ($data['action']) {

                    case 'listAllTitles':
                        if (isset($data['pk'])) {
                            $pk = $data['pk'];
                            $TitleCtrl = new Ctrl_Title();
                            $result = $TitleCtrl->listAllTitles($pk);
                            echo $result;
                        } else {
                            echo 'Certains champs sont manquants dans les données JSON !';
                        }
                        break;
                    case 'listAllUsers':
                        if (isset($data['pk'])) {
                            $pk = $data['pk'];
                            $userCtrl = new Ctrl_User();
                            $result = $userCtrl->listAllUsers($pk);
                            echo $result;
                        } else {
                            echo 'Certains champs sont manquants dans les données JSON !';
                        }
                        break;
                }
            } else {
                echo 'Erreur lors de la lecture des données JSON !';
            }
            break;

        case 'POST':
            if ($data !== null) {
                switch ($data['action']) {
                    case 'signUp':
                        // Vérifier que les champs nécessaires sont présents dans les données JSON
                        if (isset($data['username'], $data['email'], $data['password'])) {
                            $username = $data["username"];
                            $email = $data["email"];
                            $password = $data["password"];
                            $userCtrl = new Ctrl_User();
                            $result = $userCtrl->signUp($username, $email, $password);
                            echo $result;
                        } else {
                            echo 'Certains champs sont manquants dans les données JSON !';
                        }
                        break;
                    case 'signIn':
                        // Vérifier que les champs nécessaires sont présents dans les données JSON
                        if (isset($data['username'], $data['password'])) {
                            $username = $data['username'];
                            $password = $data['password'];
                            $userCtrl = new Ctrl_User();
                            $result = $userCtrl->signIn($username, $password);
                            echo $result;
                        } else {
                            echo 'Certains champs sont manquants dans les données JSON !';
                        }
                        break;
                    case 'addTitle':
                        if (isset($data['state'], $data['title'])) {
                            $state = $data['state'];
                            $title = $data['title'];
                            $titleCtrl = new Ctrl_Title();
                            $result = $titleCtrl->addTitle($state, $title);
                            echo $result;
                        } else {
                            echo 'Certains champs sont manquants dans les données JSON !';
                        }
                        break;
                    case 'disconnect':
                        $userCtrl = new Ctrl_User();
                        $result = $userCtrl->disconnect();
                        echo $result;
                        break;
                }
            } else {
                echo 'Erreur lors de la lecture des données JSON !';
            }
            break;
        case 'PUT':
            echo "<h1>Ceci est un PUT</h1>";
            break;
        case 'DELETE':
            echo "<h1>Ceci est un DELETE</h1>";
            break;
    }
}
