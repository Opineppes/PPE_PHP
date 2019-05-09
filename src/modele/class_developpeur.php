<?php
class Developpeur
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
        $this->insert = $db->prepare("insert into Developpeur(tel, idRem, idUtilisateur) values (:tel, :idRem, :idUtilisateur)"); 
        $this->select     = $db->prepare("select Developpeur.id, nom, prenom, tel, idRem, idUtilisateur, email, coutHoraire from Developpeur inner join Utilisateur on Utilisateur.email = idUtilisateur inner join Remuneration on Remuneration.id = Developpeur.idRem order by nom");   
        $this->selectName = $db->prepare("select Developpeur.id, nom, prenom, tel, idRem, idUtilisateur, email from Developpeur inner join Utilisateur on Utilisateur.email = idUtilisateur where id=:id");
        $this->update = $db->prepare("update Developpeur set tel=:tel, idRem=:idRem where id=:id");
        $this->delete = $db->prepare("delete from Developpeur where id=:id");
    }

    public function insert ($tel,$idRem,$idUtilisateur)
    {
        $this->insert->execute(array(':tel'=>$tel, ':idRem'=>$idRem, ':idUtilisateur'=>$idUtilisateur));
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

    public function selectById ($id)
    {
        $this->selectName->execute(array(':id' => $id));
        if ($this->selectName->errorCode()!=0)
        {
            print_r($this->selectName->errorInfo());  
        }
        return $this->selectName->fetch();
    }

    public function update ($tel,$idRem,$id)
    {
        $r = true;
        $this->update->execute(array(':tel'=>$tel, ':idRem'=>$idRem, ':id'=>$id));
        if ($this->update->errorCode()!=0)
        {
            print_r($this->update->errorInfo());
            $r = false;  
        }
        return $r;
    }

    public function delete ($id)
    {
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0)
        {
            print_r($this->delete->errorInfo());  
            $r=false;
        }
        return $r;
    }

}