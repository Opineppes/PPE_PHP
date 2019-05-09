<?php

function actionOutil($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    $class_element = new Outil($db);//                                                                         ( à modifier en fonction de la page )
    $liste = $class_element->select();  // Recuperation de la liste d'elements
    echo $twig->render('outil/outil.html.twig', array('infos_page'=>$infos_page, 'liste'=>$liste)); //    ( à modifier en fonction de la page )
}

function actionOutilSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET['id']))
    {
        $class_element = new Outil($db); //                                                            ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET['id']); // Suppression de l'element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table outil'; //           ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Outil supprimé avec succès'; //                           ( à modifier en fonction de la page )
        }
    }

    actionOutil($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionOutilAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Outil($db); //                                                               ( à modifier en fonction de la page )

        // Recuperation des element passer en $_POST                                                        ( à modifier en fonction de la page )
        $inputLibelle = $_POST['inputLibelle'];
        $inputVersion = $_POST['inputVersion'];
        
      
        $exec = $class_element->insert($inputLibelle, $inputVersion); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page ) 
        if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table outil '; //    ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Ajout de l'outil reussi"; //                              ( à modifier en fonction de la page )
        }
    }

    actionOutil($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionOutilModif($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['id'])) // Si id est passer en parametre alors
    {
        $class_element = new Outil($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['id']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Outil invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Outil($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire                                             ( à modifier en fonction de la page )
            $id = $_POST['id'];
            $libelle = $_POST['inputLibelle'];
            $version = $_POST['inputVersion'];

            $exec = $class_element->update($id, $libelle, $version); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = 'Echec de la modification de l\'outil'; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification de l'outil réussi"; //      ( à modifier en fonction de la page )
            }
        }
    }
    
    actionOutil($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

// WebService pour la recuperation de la liste des elements
function actionOutilWS($twig, $db)
{
   $outil = new Outil($db);
   echo json_encode($outil->select());
}