<?php

class Maitrise{

    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    private $selectById;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select idOutil, idDev, niveau from Maitrise order by niveau");
        $this->insert = $db->prepare("insert into Maitrise(niveau) values (:niveau)");
        $this->update = $db->prepare("update Maitrise set niveau=:niveau where idOutil=:idOutil AND idDev=:idDev");
        $this->delete = $db->prepare("delete from Maitrise where idOutil=:idOutil AND idDev=:idDev");
        $this->selectById = $db->prepare("select idOutil, idDev, niveau from Maitrise where idOutil=:idOutil and idDev=:idDev");
        $this->selectByIdDev = $db->prepare("select Outil.libelle, Outil.version, Maitrise.niveau from Maitrise INNER JOIN Outil ON Outil.id = Maitrise.idOutil where idDev=:idDev");
    }

    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectById($idOutil, $idDev){
        $this->selectById->execute(array(':idOutil'=>$idOutil, ':idDev'=>$idDev));
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function selectByIdDev($idDev){
        $this->selectByIdDev->execute(array(':idDev'=>$idDev));
        if ($this->selectByIdDev->errorCode()!=0){
            print_r($this->selectByIdDev->errorInfo());
        }
        return $this->selectByIdDev->fetchAll();
    }

    public function insert($niveau){
        $r = true;
        $this->insert->execute(array(':niveau'=>$niveau));
        if ($this->insert->errorCode()!=0){
            print_r($this->insert->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function update($idOutil, $idDev, $niveau){
        $r = true;
        $this->update->execute(array(':idOutil'=>$idOutil, ':idDev'=>$idDev, ':niveau'=>$niveau));
        if ($this->update->errorCode()!=0){
            print_r($this->delete->errorInfo());
			$r=false;
        }
        return $r;
    }

    public function delete($idOutil, $idDev){
        $r = true;
        $this->delete->execute(array(':idOutil'=>$idOutil, ':idDev'=>$idDev));
        if ($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r=false;
        }
        return $r;
    }
}