<?php

class Utilisateur{
    
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $selectByEmail;
    private $update;
    private $updateMdp;
    private $delete;
    
    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("INSERT INTO Utilisateur(email, mdp, nom, prenom, idRole) VALUES (:email, :mdp, :nom, :prenom, :role)");    
        $this->connect = $db->prepare("SELECT email, idRole, mdp FROM Utilisateur WHERE email=:email");
        $this->select = $db->prepare(   "SELECT email, idRole, nom, prenom, Role.libelle as libelleRole, Developpeur.id as idDev ".
                                        "FROM Utilisateur ".
                                        "INNER JOIN Role on Role.id = Utilisateur.idRole ".
                                        "LEFT JOIN Developpeur on Developpeur.idUtilisateur = Utilisateur.email ".
                                        "ORDER BY nom ");
        $this->selectWIdDev = $db->prepare(   "SELECT email, idRole, nom, prenom, Role.libelle as libelleRole, Developpeur.id as idDev ".
                                        "FROM Utilisateur ".
                                        "INNER JOIN Role on Role.id = Utilisateur.idRole ".
                                        "LEFT JOIN Developpeur on Developpeur.idUtilisateur = Utilisateur.email ".
                                        "WHERE Developpeur.id IS NULL ".
                                        "ORDER BY nom ");
        $this->selectDevelopperId = $db->prepare("SELECT Developpeur.id FROM Utilisateur LEFT JOIN Developpeur ON Developpeur.idUtilisateur = Utilisateur.email WHERE Utilisateur.email = :email AND Developpeur.id IS NOT NULL");
        $this->selectByEmail = $db->prepare("select email, nom, prenom, idRole, Role.libelle as libelleRole from Utilisateur inner join Role on Utilisateur.idRole = Role.id where email=:email");
        $this->update = $db->prepare("update Utilisateur set nom=:nom, prenom=:prenom, idRole=:role where email=:email");
        $this->updateMdp = $db->prepare("update Utilisateur set mdp=:mdp where email=:email");
        $this->delete = $db->prepare("delete from Utilisateur where email=:id");
        }
    public function insert($email, $mdp, $role, $nom, $prenom){
        $r = true;
        $this->insert->execute(array(':email'=>$email, ':mdp'=>$mdp, ':role'=>$role, ':nom'=>$nom, ':prenom'=>$prenom));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }

    public function selectDevelopperId($email){
        $this->selectDevelopperId->execute(array(':email'=>$email));
        if ($this->selectDevelopperId->errorCode()!=0){
             print_r($this->selectDevelopperId->errorInfo());  
        }
        return $this->selectDevelopperId->fetch();
    }
    
    public function connect($email){  
        $unUtilisateur = $this->connect->execute(array(':email'=>$email));
        if ($this->connect->errorCode()!=0){
             print_r($this->connect->errorInfo());  
        }
        return $this->connect->fetch();
    }
    
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }

    public function selectWithoutDeveloppeur() {
        $this->selectWIdDev->execute();
        if ($this->selectWIdDev->errorCode()!=0){
             print_r($this->selectWIdDev->errorInfo());  
        }
        return $this->selectWIdDev->fetchAll();
    }
    
    public function selectById($email){ 
        $this->selectByEmail->execute(array(':email'=>$email)); 
        if ($this->selectByEmail->errorCode()!=0){
            print_r($this->selectByEmail->errorInfo()); 
        }
        return $this->selectByEmail->fetch(); 
    }
    
    public function update($email, $role, $nom, $prenom){
        $r = true;
        $this->update->execute(array(':email'=>$email, ':role'=>$role, ':nom'=>$nom, ':prenom'=>$prenom));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function updateMdp($email, $mdp){
        $r = true;
        $this->updateMdp->execute(array(':email'=>$email, ':mdp'=>$mdp));
        if ($this->update->errorCode()!=0){
             print_r($this->updateMdp->errorInfo());  
             $r=false;
        }
        return $r;
    }
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
}