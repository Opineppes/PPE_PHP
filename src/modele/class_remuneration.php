<?php 

class Remuneration{

    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    private $selectById;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select id, coutHoraire from Remuneration order by id");
        $this->insert = $db->prepare("insert into Remuneration(coutHoraire) values (:coutHoraire)");
        $this->update = $db->prepare("update Remuneration set coutHoraire=:coutHoraire where id=:id");
        $this->delete = $db->prepare("delete from Remuneration where id=:id");
        $this->selectById = $db->prepare("select id, coutHoraire from Remuneration where id=:id");
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

    public function insert($coutHoraire){
        $r = true;
        $this->insert->execute(array(':coutHoraire'=>$coutHoraire));
        if ($this->insert->errorCode()!=0){
            print_r($this->insert->errorInfo());
            $r=false;
        }
        return $r;
    }

    public function update($id,$coutHoraire){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':coutHoraire'=>$coutHoraire));
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