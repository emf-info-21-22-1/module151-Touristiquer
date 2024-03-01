<?php

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
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($_GET['action'] == 'checkIfConnected') {
                
            } else if ($_GET['action'] == 'xxxxxx') {
                
            } else if ($_GET['action'] == 'xxxxxx') {
                
            } else if ($_GET['action'] == 'xxxxxx') {
                
            } else if ($_GET['action'] == 'xxxxxx') {
                
            }
            break;
        case 'POST':
            parse_str(file_get_contents('php://input'), $vars);

            break;
        case 'PUT':
            parse_str(file_get_contents('php://input'), $vars);
            
            break;
        case 'DELETE':
            parse_str(file_get_contents('php://input'), $vars);

            break;
    }
} else {
    http_response_code(500);
}
