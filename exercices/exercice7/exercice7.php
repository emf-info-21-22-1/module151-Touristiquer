<?php
$bdd = new PDO('mysql:host=localhost;dbname=nomDB', 'root', 'pwd');
$reponse = $bdd->query('SELECT titre FROM jeux_video');


while ($donnees = $reponse->fetch()) {
	echo $donnees['titre'] . '<br>';
}

$reponse->closeCursor();
?>