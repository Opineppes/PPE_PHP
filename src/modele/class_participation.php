<?php

class Participation{

    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    private $selectById;

    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into Participation(idDev, idEquipe) values (:idDev, :idEquipe);");
        $this->select = $db->prepare("select idDev, idEquipe, niveau from Participation order by niveau");
        $this->delete = $db->prepare("delete from Participation where idDev=:idDev AND idEquipe=:idEquipe");
        $this->selectById = $db->prepare("select idDev, idEquipe, niveau from Participation where idDev=:idDev and idEquipe=:idEquipe");
        $this->selectByIdDev = $db->prepare("select Equipe.id, libelle, idResponsable from Participation inner join Equipe on idEquipe = Equipe.id where idDev=:idDev");
    }
    
    //insert une valeur dans la table
    //renvoi un boolean en fonction du succe de l'insertion et
    //si l'insertion echou, renvoi le code d'erreur
    public function insert($idDev, $idEquipe){
        $this->insert->execute(array(':idDev'=>$idDev, ':idEquipe'=>$idEquipe));

        if ($this->insert->errorCode() != 0){
            print_r($this->insert->errorInfo());
            return array(false, $this->insert->errorCode());
        }

        return array(true);
    }

    //selctionne toute les equipe de la table
    //renvoi faux si la selection a echoue
    //renvoi la liste si la selection a reussi
    public function select(){
        $this->select->execute();

        if ($this->select->errorCode() != 0){
            print_r($this->select->errorInfo());
            return false;
        }

        return $this->select->fetchAll();
    }

    //selection toute les information relative aux participations en fonction de son idDev
    //renvoi faux si la selection a echoue
    //renvoi la liste des participation ayant l'idEquipe passer en parametre si la selection a reussi
    public function selectByIdDev($idDev){
        $this->selectByIdDev->execute(array(":idDev"=>$idDev));

        if ($this->selectByIdDev->errorCode() != 0){
            print_r($this->selectByIdDev->errorInfo());
            return false;
        }

        return $this->selectByIdDev->fetchAll();
    }

    //selection toute les information relative aux participations en fonction de son idEquipe
    //renvoi faux si la selection a echoue
    //renvoi la liste des participation ayant l'idDev passer en parametre  si la selection a reussi
    public function selectByIdEquipe($idEquipe){
        $this->selectById->execute(array(':idEquipe'=>$idEquipe));

        if ($this->selectById->errorCode() != 0){
            print_r($this->selectById->errorInfo());
            return false;
        }

        return $this->selectById->fetchAll();
    }

    //supprimer une participation de la table en fonction de ses ids
    //renvoi faux si la suppression a echoue
    //renvoi vrai si la suppresion a echoue
    public function delete($idDev, $idEquipe){
        $this->delete->execute(array(':idDev'=>$idDev, ':idEquipe'=>$idEquipe));

        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            return false;
        }
        
        return true;
    }
}