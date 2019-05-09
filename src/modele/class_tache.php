<?php
class Tache
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
        $this->insert = $db->prepare("insert into Tache(libelle,cout,heures,idDev,codeProjet) values(:libelle,:cout,:heures,:idDev,:codeProjet)");
        $this->select = $db->prepare("SELECT Tache.code, Tache.libelle, cout, heures, Utilisateur.nom, Utilisateur.prenom, Projet.libelle as 'nProjet' 
        FROM Tache INNER JOIN Developpeur ON Tache.idDev = Developpeur.id
        INNER JOIN Utilisateur ON Developpeur.idUtilisateur = Utilisateur.email 
        INNER JOIN Projet ON Tache.codeProjet = Projet.code"); 
        $this->selectById = $db->prepare("select code,libelle,cout,heures,idDev,codeProjet from Tache where code=:code");
        $this->update = $db->prepare("update Tache set libelle=:libelle,cout=:cout,heures=:heures,idDev=:idDev,codeProjet=:codeProjet where code=:code");
        $this->delete=$db->prepare("delete from Tache where code=:code");
        $this->selectByIdProjet = $db->prepare("SELECT Tache.code, Tache.libelle, cout, heures, Utilisateur.nom, Utilisateur.prenom
        FROM Tache INNER JOIN Developpeur ON Tache.idDev = Developpeur.id
        INNER JOIN Utilisateur ON Developpeur.idUtilisateur = Utilisateur.email
        WHERE codeProjet=:codeProjet"); 
    }

    public function insert ($libelle,$cout,$heures,$idDev,$codeProjet)
    {
        $r=true;
        $this->insert->execute(array(':libelle'=>$libelle,':cout'=>$cout,':heures'=>$heures,':idDev'=>$idDev,':codeProjet'=>$codeProjet));
        if ($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());  
            $r=false;
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

    public function selectById ($code)
    {
        $this->selectById->execute(array(':code' => $code));
        if ($this->selectById->errorCode()!=0)
        {
            print_r($this->selectById->errorInfo());  
        }
        return $this->selectById->fetch();
    }

    public function update ($code,$libelle,$cout,$heures,$idDev,$codeProjet)
    {
        $r = true;
        $this->update->execute(array(":code"=>$code,':libelle'=>$libelle,':cout'=>$cout,':heures'=>$heures,':idDev'=>$idDev,':codeProjet'=>$codeProjet));
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

    public function selectByIdProjet ($codeProjet)
    {
        $this->selectByIdProjet->execute(array(':codeProjet' => $codeProjet));
        if ($this->selectByIdProjet->errorCode()!=0)
        {
            print_r($this->selectByIdProjet->errorInfo());  
        }
        return $this->selectByIdProjet->fetchAll();

    }
}