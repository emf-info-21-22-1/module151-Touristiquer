<?php

class User implements JsonSerializable
{

    private $PK_User;
    private $Username;
    private $Email;
    private $Password;


    /**
     * Constructeur de la classe User qui permet de gérer un user
     *
     * @param mixed $PK_User PK de l'utilisateur
     * @param mixed $Username Nom de l'utilisateur
     * @param mixed $Email Email de l'utilisateur
     * @param mixed $Password Password de l'utilisateur
     * 
     */
    public function __construct($PK_User, $Username, $Email, $Password)
    {
        $this->PK_User = $PK_User;
        $this->Username = $Username;
        $this->Email = $Email;
        $this->Password = $Password;
    }

    //Getters
    public function getPk()
    {
        return $this->PK_User;
    }
    public function getUsername()
    {
        return $this->Username;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getPassword()
    {
        return $this->Password;
    }

    //setters
    public function setPk($pk)
    {
        $this->PK_User = $pk;
    }

    public function setUsername($username)
    {
        $this->Username = $username;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function setPassword($Password){
        $this->Password = $Password;
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
