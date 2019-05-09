<?php 

class Outil{

    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    private $selectById;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select id, libelle, version from Outil order by libelle");
        $this->insert = $db->prepare("insert into Outil(libelle, version) values (:libelle, :version)");
        $this->update = $db->prepare("update Outil set libelle=:libelle, version=:version where id=:id");
        $this->delete = $db->prepare("delete from Outil where id=:id");
        $this->selectById = $db->prepare("select id, libelle, version from Outil where id=:id");
    }

    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectById($id){
        $this->selectById->execute(array(':id'=>$id));
        if ($this->selectById->errorCode()!=0){
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function insert($libelle,$version){
        $r = true;
        $this->insert->execute(array(':libelle'=>$libelle, ':version'=>$version));
        if ($this->insert->errorCode()!=0){
            print_r($this->insert->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function update($id,$libelle,$version){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':version'=>$version));
        if ($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
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