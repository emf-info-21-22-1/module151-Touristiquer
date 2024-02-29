<?php
include_once('dbConnection/Connexion.php');
include_once('beans/Title.php');
include_once('WrkLogin.php');


class WrkTitre{
    private $connexion;
    private $wrkLogin;

    /**
     * Constructeur de la classe WrkTitre.
     * permet d'instancier la connexion avec la DB et créer le WrkLogin.
     * 
     */
    function __construct(){
        $this->connexion=Connexion::getInstance();
        $this->wrkLogin = new WrkLogin();
    }

    /**
     * Fonction qui permet de retourner la liste de toute les cartes en format Json.
     *
     * @return Json
     * 
     */
    public function afficheAllTitlesToJson(){
        $list=$this->afficheAllTitles();
        return '{"allTitles":'.json_encode($list)."}";
    }

    /**
     * Fonction qui va chercher la liste de toutes les cartes dans la DB.
     *
     * @return liste de cartes
     * 
     */
    private function afficheAllTitles(){
        $list = array();
        $count = 0;
        $query= $this->connexion->selectQuery("SELECT t_Title.Name, t_Title.Desc, t_Title.Image FROM t_Title;",null);
       foreach($query as $data){
           $allTitle = new Title($data["Name"], $data["Desc"], $data["Image"]);
           $list[$count++] = $allTitle;
        }
        return $list;
    }


    /**
     * Fonction qui retourne 0, 1 ou plusieurs cartes en fonction du string rechercher.
     *
     * @param mixed $searchedString
     * 
     * @return Json
     * 
     */
    public function afficheSearchTitleToJson($searchedString){
        $list=$this->afficheSearchTitle($searchedString);
        return '{"searchTitles":'.json_encode($list)."}";
    }

    /**
     * Fonction qui va chercher la liste des cartes rechercher dans la DB.
     *
     * @param mixed $searchedString
     * 
     * @return liste de cartes
     * 
     */
    private function afficheSearchTitle($searchedString){
        $list = array();
        $count = 0;
        $query="SELECT t_Title.Name, t_Title.Desc, t_Title.Image FROM t_Title WHERE t_Title.Name LIKE :nameTitle or t_Title.Desc LIKE :descTitle";
        $params=array('nameTitle'=> '%'.$searchedString.'%', 'descTitle'=> '%'.$searchedString.'%');
        $res= $this->connexion->selectQuery($query,$params);
        foreach($res as $data){
            $searchTitle = new Title($data["Name"], $data["Desc"], $data["Image"]);
            $list[$count++] = $searchTitle;
         }
         return $list;
    }

    /**
     * Permet de retourner les cartes d'un utilisateur.
     *
     * @return Json
     * 
     */
    public function afficheUserTitleToJson(){
        if($this->wrkLogin->isConnected()){
        $list=$this->afficheUserTitle();
        return '{"allUserTitles":'.json_encode($list)."}";
        }else{
            return 'NOK';
        }
        
    }

    /**
     * Fonction qui va rechercher la liste des cartes de l'utilisateur stocké dans la session.
     *
     * @return liste de cartes
     * 
     */
    public function afficheUserTitle(){
        $list = array();
        $count = 0;
        $query="SELECT t_Title.Name, t_Title.Desc, t_Title.Image FROM t_Title INNER JOIN tr_user_Title ON t_Title.PK_Title = tr_user_Title.FK_Title INNER JOIN t_user ON t_user.PK_User = tr_user_Title.FK_User WHERE t_user.Username= :username";
        $params=array('username'=> $_SESSION['user']);
        $res= $this->connexion->selectQuery($query,$params);
        foreach($res as $data){
            $userTitle = new Title($data["Name"], $data["Desc"], $data["Image"]);
            $list[$count++] = $userTitle;
         }
         return $list;
    }

    /**
     * Permet de retourner le resultat de la suppression d'une cartes.
     *
     * @param mixed $titleName carte à supprimer
     * 
     * @return boolean
     * 
     */
    public function delTitleToJson($titleName){
        if($this->wrkLogin->isConnected()){
            $res=$this->delTitle($titleName);
                return $res; 
        }else{
            return 'NOK';
        }
    }

    /**
     * Fonction qui permet de supprimer une carte de la liste de l'utilisateur de la session.
     *
     * @param mixed $titleName carte à supprimer
     * 
     * @return boolean si tout s'est bien passé
     * 
     */
    private function delTitle($titleName){
        $query="SELECT PK_User FROM t_user where Username=:username";
        $params=array('username'=> $_SESSION['user']);
        $res = $this->connexion->selectQuery($query,$params);
        $pkUser=null;
        if(isset($res[0])){
            $pkUser=$res[0]["PK_User"];
        }

        $query="SELECT PK_Title FROM t_Title where Name=:TitleName";
        $params=array('TitleName'=> $titleName);
        $res = $this->connexion->selectQuery($query,$params);
        $pkTitle=null;
        if(isset($res[0])){
            $pkTitle=$res[0]["PK_Title"];
        }

        $query="DELETE FROM tr_user_Title WHERE tr_user_Title.FK_User= :pkUser and tr_user_Title.FK_Title= :pkTitle";
        $params=array('pkUser'=> $pkUser, 'pkTitle'=> $pkTitle);
        $res=$this->connexion->executeQuery($query, $params);
        return $res;
    }
	
	/**
	 * Permet de retourner les cartes que l'utilisateur ne possède pas encore dans sa liste.
	 *
	 * @return Json 
	 * 
	 */
	public function titlesUserNotHaveToJson(){
        if($this->wrkLogin->isConnected()){
            $list=$this->titlesUserNotHave();
            return '{"TitlesUserNotHave":'.json_encode($list)."}";
        }else{
             return 'NOK';
        }
    }

    /**
     * Fonction qui va chercher les cartes que l'utilisateur de la session de possède pas.
     *
     * @return liste de cartes.
     * 
     */
    private function titlesUserNotHave(){
        $list = array();
        $count = 0;
        $query="SELECT t_Title.Name, t_Title.Desc, t_Title.Image FROM t_Title WHERE t_Title.PK_Title NOT IN ( SELECT t_Title.PK_Title FROM t_user INNER JOIN tr_user_Title ON t_user.PK_User=tr_user_Title.FK_User INNER JOIN t_Title ON t_Title.PK_Title = tr_user_Title.FK_Title WHERE t_user.Username = :username )";
        $params=array('username'=> $_SESSION['user']);
        $res= $this->connexion->selectQuery($query,$params);
        foreach($res as $data){
            $userTitleNotHave = new Title($data["Name"], $data["Desc"], $data["Image"]);
            $list[$count++] = $userTitleNotHave;
         }
         return $list;
    }

    /**
     * Permet de tester si l'ajout d'une carte dans la DB s'est bien passé.
     *
     * @param mixed $titlesName liste de cartes
     * 
     * @return boolean
     * 
     */
    public function addTitleUserListToJson($titlesName){
        if($this->wrkLogin->isConnected()){
            $result=$this->addTitleUserList($titlesName);
            if($result){
                return $result;
            }else{
                
            }
        }else{
            
        }
    }

    /**
     * Permet d'ajouter une carte dans la liste de l'utilisateur de la session.
     *
     * @param mixed $titlesName
     * 
     * @return boolean si tous s'est bien passé
     * 
     */
    private function addTitleUserList($titlesName){
        $tab=explode(";",$titlesName,-1);
        $query="SELECT PK_User FROM t_user where Username=:username";
        $params=array('username'=> $_SESSION['user']);
        $res = $this->connexion->selectQuery($query,$params);
        $pkUser=null;
        if(isset($res[0])){
            $pkUser=$res[0]["PK_User"];
        }

        foreach($tab as $titleName){
            $query="SELECT PK_Title FROM t_Title where Name=:TitleName";
            $params=array('titleName'=> $titleName);
            $res = $this->connexion->selectQuery($query,$params);
            $pkTitle=null;
            if(isset($res[0])){
                $pkTitle=$res[0]["PK_Title"];
            }
            $query="INSERT INTO tr_user_Title (FK_User,FK_Title) VALUES (:pkUser,:pkTitle)";
            $params=array('pkUser'=> $pkUser, 'pkTitle'=> $pkTitle);
            $res=$this->connexion->executeQuery($query, $params);
            
        }
        return $res;
    }
}
?>