<?php
class Contrat
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
        $this->insert = $db->prepare("insert into Contrat(dateDebut, dateFin, dateSignature, cout, codeProjet, idEntreprise) values(:dateDebut, :dateFin, :dateSignature, :cout, :codeProjet, :idEntreprise)");
        $this->select = $db->prepare("SELECT Contrat.id,Entreprise.id as'idEntreprise',Projet.code,Contrat.dateDebut,Contrat.dateFin, Contrat.dateSignature,Contrat.cout,Projet.libelle as 'Nprojet',Entreprise.libelle as 'Nentreprise' 
        from Contrat inner JOIN Projet ON Contrat.codeProjet=Projet.code
        INNER Join Entreprise ON Contrat.idEntreprise=Entreprise.id"); //"select id,dateDebut, dateFin, dateSignature, cout, codeProjet, idEntreprise from Contrat"
        $this->selectById = $db->prepare("select id,dateDebut, dateFin, dateSignature, cout, codeProjet, idEntreprise from Contrat where id=:id");
        $this->update = $db->prepare("update Contrat set dateDebut=:dateDebut, dateFin=:dateFin, dateSignature=:dateSignature, cout=:cout, codeProjet=:codeProjet, idEntreprise=:idEntreprise where id=:id");
        $this->delete=$db->prepare("delete from Contrat where id=:id");
    }

    public function insert ($dateDebut,$dateFin,$dateSignature,$cout,$codeProjet,$idEntreprise)
    {
        $r=true;
        $this->insert->execute(array(':dateDebut'=>$dateDebut,':dateFin'=>$dateFin,':dateSignature'=>$dateSignature,':cout'=>$cout,':codeProjet'=>$codeProjet,':idEntreprise'=>$idEntreprise));
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

    public function selectById ($id)
    {
        $this->selectById->execute(array(':id' => $id));
        if ($this->selectById->errorCode()!=0)
        {
            print_r($this->selectById->errorInfo());  
        }
        return $this->selectById->fetch();
    }

    public function update ($id,$dateDebut,$dateFin,$dateSignature,$cout,$codeProjet,$idEntreprise)
    {
        $r = true;
        $this->update->execute(array(":id"=>$id,':dateDebut'=>$dateDebut,':dateFin'=>$dateFin,':dateSignature'=>$dateSignature,':cout'=>$cout,':codeProjet'=>$codeProjet,':idEntreprise'=>$idEntreprise));
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