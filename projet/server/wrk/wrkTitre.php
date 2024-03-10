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

    public function getAllTitlesFromDB()
    {
        $res = [];
        $i = 0;
        $params = array();
        $rows = Connexion::getInstance()->SelectQuery("SELECT * FROM t_title INNER JOIN tr_user_titre ON PK_Titre = FK_Titre INNER JOIN t_user ON PK_User = FK_User ORDER BY t_title.PK_Titre DESC LIMIT 10
        ", $params);

        foreach ($rows as $row) {
            $music = new Titre();
            $music->initFromDb($row);

            $res[$i] = [
                "name" => $music->getId_Titre(),
                "Durée" => $music->getDuree(),
                "File" => $music->getFile(),
                "Image" => $music->getImage(),
                "Date_Publication" => $music->getDate_Publication(),
                "username" => $row["Username"]
            ];
            $i++;
        }
        return $res;
    }
}
