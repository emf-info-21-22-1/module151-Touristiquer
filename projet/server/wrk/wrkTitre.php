<?php

require_once('dbConnection/Connexion.php');
require_once('./ctrl/Ctrl_Title.php');
require_once('./beans/Titre.php');

class wrkTitre
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connexion::getInstance();
    }

}
