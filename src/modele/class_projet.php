<?php
class Projet
{
    private $db;
    private $insert;
    private $select;
    private $selectName;
    private $update;
    private $delete;

    public function __construct($db)
    {
        $this->db = $db;
        $this->insert = $db->prepare("insert into Projet(libelle,idEquipe) values (:libelle,:idEquipe)"); 
        $this->select = $db->prepare("select code, Projet.libelle as libelleProjet, Equipe.libelle as libelleEquipe from Projet left join Equipe on Equipe.id = Projet.idEquipe order by libelleProjet");   
        $this->selectName = $db->prepare("select code, Projet.libelle as libelleProjet, Equipe.libelle as libelleEquipe, Projet.idEquipe from Projet left join Equipe on Equipe.id = Projet.idEquipe where code=:code");
        $this->update = $db->prepare("update Projet set libelle=:libelle, idEquipe=:idEquipe where code=:code");
        $this->delete = $db->prepare("delete from Projet where code=:code");
    }

    public function insert ($libelle,$idEquipe)
    {
        $this->insert->execute(array(':libelle'=>$libelle, ':idEquipe'=>$idEquipe));
        if ($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());  
        }
        return $this->insert->rowCount();
    }

    public function select ()
    {
        $this->select->execute();
        if ($this->select->errorCode()!=0)
        {
            print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }

    public function selectById($code)
    {
        $this->selectName->execute(array(':code' => $code));
        if ($this->selectName->errorCode()!=0)
        {
            print_r($this->selectName->errorInfo());  
        }
        return $this->selectName->fetch();
    }

    public function update ($code, $libelle, $idEquipe)
    {
        $r = true;
        $this->update->execute(array(':libelle'=>$libelle, ':idEquipe'=>$idEquipe, ':code'=>$code));
        if ($this->update->errorCode()!=0)
        {
            print_r($this->update->errorInfo());
            $r = false;  
        }
        return $r;
    }

    public function delete ($code)
    {
        $r = true;
        $this->delete->execute(array(':code'=>$code));
        if ($this->delete->errorCode()!=0)
        {
            print_r($this->delete->errorInfo());  
            $r=false;
        }
        return $r;
    }

}