<?php

function actionRemuneration($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    $class_element = new Remuneration($db);//                                                                         ( à modifier en fonction de la page )
    $liste = $class_element->select();  // Recuperation de la liste d'elements
    echo $twig->render('remuneration/remuneration.html.twig', array('infos_page'=>$infos_page, 'liste'=>$liste)); //    ( à modifier en fonction de la page )
}

function actionRemunerationSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET['id']))
    {
        $class_element = new Remuneration($db); //                                                            ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET['id']); // Suppression de l'element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table rémunération'; //           ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Rémunération supprimée avec succès'; //                           ( à modifier en fonction de la page )
        }
    }

    actionRemuneration($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionRemunerationAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Remuneration($db); //                                                               ( à modifier en fonction de la page )

        // Recuperation des element passer en $_POST                                                        ( à modifier en fonction de la page )
        $inputCoutHoraire = $_POST['inputCoutHoraire'];
        
      
        $exec = $class_element->insert($inputCoutHoraire); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page )
        if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table rémunération '; //    ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Ajout de la rémunération reussi"; //                              ( à modifier en fonction de la page )
        }
    }

    actionRemuneration($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionRemunerationModif($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['id'])) // Si id est passer en parametre alors
    {
        $class_element = new Remuneration($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['id']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Rémunération invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Remuneration($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire                                             ( à modifier en fonction de la page )
            $id = $_POST['id'];
            $coutHoraire = $_POST['inputCoutHoraire'];
          
            $exec = $class_element->update($id, $coutHoraire); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = 'Echec de la modification de la rémunération'; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification de la rémunération réussie"; //      ( à modifier en fonction de la page )
            }
        }
    }
    
    actionRemuneration($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}