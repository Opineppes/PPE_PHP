<?php

class Equipe{
    
    private $db;
    private $insert;
    private $select;
    private $delete;
    private $update;
    private $selectById;
    private $selectByIdResponsable;

    
    public function __construct($db){
        $this->db = $db;

        $this->insert = $db->prepare("insert into Equipe(libelle, idResponsable) values (:libelle, :idResponsable);");
        $this->selectLastId = $db->prepare("select id from Equipe where libelle=:libelle;");
        $this->select = $db->prepare("select Equipe.id, libelle, idResponsable, Utilisateur.nom, Utilisateur.prenom from Equipe left join Developpeur on Equipe.idResponsable = Developpeur.id left join Utilisateur on Utilisateur.email = Developpeur.idUtilisateur order by libelle");
        $this->delete = $db->prepare("delete from Equipe where id=:id");
        $this->update = $db->prepare("update Equipe set libelle=:libelle, idResponsable=:idResponsable where id=:id"); 
        $this->selectByid = $db->prepare("select id, libelle, idResponsable from Equipe where id=:id order by libelle");
        $this->selectByidResponsable = $db->prepare("select id, libelle, idResponsable from Equipe where idResponsable=:idResponsable");
    }
    
    //insert une valeur dans la table
    //renvoi un boolean en fonction du succé de l'insertion et
    //si l'insertion echou, renvoi le code d'erreur
    //si l'insertion reussi renvoi l'id de la ligne
    public function insert($libelle, $idResponsable){
        if($idResponsable=="non"){
            $idResponsable=null;  
        }

        $this->insert->execute(array(":idResponsable"=>$idResponsable, ":libelle"=>$libelle));
        $this->selectLastId->execute(array(":libelle"=>$libelle));
        if ($this->insert->errorCode() != 0){
            //print_r($this->insert->errorInfo());  
            return array(false, $this->insert->errorCode());
        }

        return array(true, $this->selectLastId->fetch()["id"]);
    }

    //met a jour la valeur dans la table
    //renvoi un boolean en fonction du succe de la mise a jour et
    //si mise a jour echou, renvoi le code d'erreur
    public function update($id, $libelle, $idResponsable){
        if($idResponsable=="non"){
          $idResponsable=null;  
        }

        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':idResponsable'=>$idResponsable));

        if ($this->update->errorCode()!=0){
            //print_r($this->update->errorInfo());  
            return array(false, $this->insert->errorInfo()[1]);
        }

        return array(true);
    }
    
    //selctionne toute les equipe de la table
    //renvoi faux si la selection a echoue
    //renvoi la liste si la selection a reussi
    public function select(){
        $this->select->execute();

        if ($this->select->errorCode() != 0){
            //print_r($this->select->errorInfo());
            return false;
        }

        return $this->select->fetchAll();
    }

    //selection toute les information relative a une equipe en fonction de son id
    //renvoi faux si la selection a echoue
    //renvoi la liste des information si la selection a reussi
    public function selectByid($id){ 
        $this->selectByid->execute(array(':id'=>$id));

        if ($this->selectByid->errorCode()!=0){
            //print_r($this->selectByid->errorInfo()); 
            return false;
        }

        return $this->selectByid->fetch(); 
    }

    //seclection la liste des equipe dont le responble est indiquer
    //renvoi faux si la selection a echoue
    //renvoi la liste des equipe si la selection a reussi
    public function selectByidResponsable($idResponsable){
        $this->selectByidResponsable->execute(array(':idResponsable'=>$idResponsable));

        if ($this->selectByidResponsable->errorCode()!=0){
            //print_r($this->selectByidResponsable->errorInfo());
            return false;
        }

        return $this->selectByidResponsable->fetchAll();
    }

    //supprimer une equipe de la table en fonction de son id
    //renvoi faux si la suppression a echoue
    //renvoi vrai si la suppresion a echoue
    public function delete($id){
        $this->delete->execute(array(':id'=>$id));

        if ($this->delete->errorCode()!=0){
            //print_r($this->delete->errorInfo());  
            return false;
        }

        return true;
    }
    
    
}