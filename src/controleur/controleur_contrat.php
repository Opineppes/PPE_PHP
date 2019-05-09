<?php

function actionContrat($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    $class_projet = new Projet($db);
    $liste_projet = $class_projet->select();
   

    $class_entreprise = new Entreprise($db);
    $liste_entreprise= $class_entreprise->select();

    echo $twig->render('contrat/contrat.html.twig', array("infos_page"=>$infos_page, "liste_projet"=>$liste_projet,"liste_entreprise"=>$liste_entreprise)); //    ( à modifier en fonction de la page )
}

function actionContratSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET['id']))
    {
        $class_element = new Contrat($db); //                                                                ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET['id']); // Suppression de l'element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table contrat'; //           ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Contrat supprimée avec succès'; //                           ( à modifier en fonction de la page )
        }
    }

    actionContrat($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionContratAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Contrat($db); //                                                               ( à modifier en fonction de la page )

        // Recuperation des element passer en $_POST   ( à modifier en fonction de la page )
        $dateDebut=$_POST['inputDateDebut'];
                                                          
        $dateFin=$_POST['inputDateFin'];
        $dateSignature=$_POST['inputDateSignature'];                  
        $cout = $_POST['inputCout'];
        $codeProjet=$_POST['inputCodeProjet'];
        $idEntreprise = $_POST['inputIdEntreprise'];
      
        $exec = $class_element->insert($dateDebut,$dateFin,$dateSignature,$cout,$codeProjet,$idEntreprise); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page )
        if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table contrat '; //    ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Ajout de l'contrat reussi"; //                              ( à modifier en fonction de la page )
        }
    }

    actionContrat($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionContratModif($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['id'])) // Si id est passer en parametre alors
    {
        $class_element = new Contrat($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['id']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Contrat invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Contrat($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire ( à modifier en fonction de la page )
            $id=$_POST['id'];                                               
            $dateDebut=$_POST['inputDateDebut'];
            $dateFin=$_POST['inputDateFin'];
            $dateSignature=$_POST['inputDateSignature'];                  
            $cout = $_POST['inputCout'];
            $codeProjet=$_POST['inputCodeProjet'];
            $idEntreprise = $_POST['inputIdEntreprise'];
          
            $exec = $class_element->update($id,$dateDebut,$dateFin,$dateSignature,$cout,$codeProjet,$idEntreprise); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = "Echec de la modification du contrat"; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification du contrat réussie"; //      ( à modifier en fonction de la page )
            }
        }
    }
    
    actionContrat($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionContratWS($twig, $db)
{
   $contrat = new Contrat($db);
   echo json_encode($contrat->select());
}