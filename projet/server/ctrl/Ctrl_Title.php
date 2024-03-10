<?php

/*
  But     : Ctrl pour les titres
  Auteur  : Romain Benedetti
  Date    : 01.03.2024 / v1.0
*/

require_once('SessionManager.php');
require_once('./beans/Titre.php');
require_once('./wrk/wrkTitre.php');

class Ctrl_Title
{
  private $SessionManager;

  public function __construct()
  {
    $this->SessionManager = SessionManager::getInstance();
  }

  //Chercher et affiche tous les titres publié
  public function listAllTitles()
  {
    $wrk = new wrkTitre();

    // Appeler la méthode de récupération des titres depuis la base de données
    $titles = $wrk->getAllTitlesFromDB();

    // Retourner les titres au format JSON ou sous une autre forme selon votre besoin
    return json_encode($titles);
  }

  //Ajoute un titre pour le publié
  public function addTitle(): void
  {
  }
}
