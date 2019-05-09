<?php
class Entreprise
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
        $this->insert = $db->prepare("insert into Entreprise(libelle,adresse,cp,ville,nomContact) values (:libelle,:adresse, :cp, :ville, :nomContact)"); 
        $this->select = $db->prepare("select id ,libelle ,adresse, cp, ville, nomContact from Entreprise order by libelle");   
        $this->selectName = $db->prepare("select id, libelle,adresse, cp, ville, nomContact from Entreprise where id=:id");
        $this->update = $db->prepare("update Entreprise set libelle=:libelle,adresse=:adresse, cp=:cp, ville=:ville, nomContact=:nomContact where id=:id");
        $this->delete = $db->prepare("delete from Entreprise where id=:id");
    }

    public function insert ($libelle,$adresse,$cp,$ville,$nomContact)
    {
        $r = true;
        $this->insert->execute(array(':libelle'=>$libelle,':adresse'=>$adresse, ':cp'=>$cp, ':ville'=>$ville, ':nomContact'=>$nomContact));
        if ($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());  
            $r = false;
        }
        return $r;
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

    public function update ($id,$libelle,$adresse,$cp,$ville,$nomContact)
    {
        $r = true;
        $this->update->execute(array(':id'=>$id,':libelle'=>$libelle,':adresse'=>$adresse,':cp'=>$cp,':ville'=>$ville,':nomContact'=>$nomContact));
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