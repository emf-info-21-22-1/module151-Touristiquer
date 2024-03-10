<?php

class Titre implements JsonSerializable
{
    private $PK_Titre;
    private $Id_Titre;
    private $Duree;
    private $File;
    private $Image;
    private $Date_Publication;


    public function __construct()
    {
    }

    public function initFromDb($data)
    {
        $this->PK_Titre = $data["PK_Titre"];
        $this->Id_Titre = $data["Id_Titre"];
        $this->Duree = $data["Durée"];
        $this->File = $data["File"];
        $this->Image = $data["Image"];
        $this->Date_Publication = $data["Date_Publication"];
    }

    // Getters
    public function getPK_Titre()
    {
        return $this->PK_Titre;
    }

    public function getId_Titre()
    {
        return $this->Id_Titre;
    }

    public function getDuree()
    {
        return $this->Duree;
    }

    public function getFile()
    {
        return $this->File;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function getDate_Publication()
    {
        return $this->Date_Publication;
    }

    // Setters
    public function setPK_Titre($PK_Titre)
    {
        $this->PK_Titre = $PK_Titre;
    }

    public function setId_Titre($Id_Titre)
    {
        $this->Id_Titre = $Id_Titre;
    }

    public function setDuree($Duree)
    {
        $this->Duree = $Duree;
    }

    public function setFile($File)
    {
        $this->File = $File;
    }

    public function setImage($Image)
    {
        $this->Image = $Image;
    }

    public function setDate_Publication($Date_Publication)
    {
        $this->Date_Publication = $Date_Publication;
    }

    /**
     * Permet de retourner une carte en format Json.
     *
     * @return Json
     * 
     */
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
