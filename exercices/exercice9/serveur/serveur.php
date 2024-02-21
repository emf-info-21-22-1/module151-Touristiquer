<?php
session_start(); // Démarrer la session PHP

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == "connect") {
        // Vérifier si le mot de passe est correct
        if ($_POST['password'] == "emf") {
            // Enregistrer l'utilisateur comme connecté dans la session
            $_SESSION['logged'] = true;
            echo '<result>true</result>';
        } else {
            // Mot de passe incorrect, effacer la variable de session
            unset($_SESSION['logged']);
            echo '<result>false</result>';
        }
    }

    if ($_POST['action'] == "disconnect") {
        // Déconnecter l'utilisateur en effaçant la variable de session
        unset($_SESSION['logged']);
        echo '<result>true</result>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['action'] == "getInfos") {
        // Vérifier si l'utilisateur est connecté en vérifiant la variable de session
        if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
            // L'utilisateur est connecté, retourner les informations
            echo '<users><user><name>Victor Legros</name><salaire>9876</salaire></user><user><name>Marinette Lachance</name><salaire>7540</salaire></user><user><name>Gustave Latuile</name><salaire>4369</salaire></user><user><name>Basile Ledisciple</name><salaire>2384</salaire></user></users>';
        } else {
            // L'utilisateur n'est pas connecté, retourner un message d'erreur
            echo '<message>DROITS INSUFFISANTS</message>';
        }
    }
}
?>
