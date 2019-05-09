<?php
function ProjetModification($twig, $db, $action) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['code'])) // Si id est passer en parametre alors
    {
        $class_element = new Projet($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['code']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Code invalide"; //                            ( à modifier en fonction de la page )
        }
        
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Projet($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire                                             ( à modifier en fonction de la page )
            $code = $_POST['code'];
            $libelleProjet = $_POST['inputLibelleProjet'];
            $inputIdEquipe = $_POST["inputIdEquipe"];
          
            $exec = $class_element->update($code, $libelleProjet, $inputIdEquipe); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = 'Echec de la modification du projet'; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification du projet réussie"; //      ( à modifier en fonction de la page )
            }
        }        
    }
    $action($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
    
}

function actionProjet($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{

    $class_equipe = new Equipe($db);
    $liste_equipe = $class_equipe->select();
    
    echo $twig->render('projet/projet.html.twig', array('infos_page'=>$infos_page, "liste_equipe"=>$liste_equipe)); //    ( à modifier en fonction de la page )
}

function actionProjetSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET['code']))
    {
        $class_element = new Projet($db); //                                                            ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET['code']); // Suppression de l'element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table projet'; //           ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Projet supprimé avec succès'; //                           ( à modifier en fonction de la page )
        }
    }

    actionProjet($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionProjetAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Projet($db); //                                                               ( à modifier en fonction de la page )

        // Recuperation des element passer en $_POST                                                        ( à modifier en fonction de la page )
        $inputLibelleProjet = $_POST['inputLibelleProjet'];
        $inputIdEquipe = $_POST["inputIdEquipe"];
        
      
        $exec = $class_element->insert($inputLibelleProjet, $inputIdEquipe); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page )
        if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table projet '; //    ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Ajout du projet réussi"; //                              ( à modifier en fonction de la page )
        }
    }

    actionProjet($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionProjetProfil($twig, $db, $infos_page = array())
{
    if(isset($_GET['code']) || isset($_POST['code']))
    {
        $id_element = isset($_GET['code']) ? $_GET['code'] : $_POST["code"];

        $class_element = new Projet($db);

        $element = $class_element->selectById($id_element);
        if ($element != null){
            $class_tache = new Tache($db);

            $element["liste_tache"] = $class_tache->selectByIdProjet($element["code"]);
            
            echo $twig->render("projet/projet_profil.html.twig", array("infos_page"=>$infos_page, "element"=>$element));
        
        }else{
            $infos_page["popup_type"] = "danger";
            $infos_page["popup_message"] = "Projet invalide"; //                            ( à modifier en fonction de la page )

            actionProjet($twig, $db, $infos_page);
        }
    } else {
        actionProjet($twig, $db);
    }
}

function actionProjetProfilModif($twig, $db){ ProjetModification($twig, $db, "actionProjetProfil"); } 
function actionProjetModif($twig, $db){ ProjetModification($twig, $db, "actionProjet"); } 

function actionProjetWS($twig, $db)
{
   $projet = new Projet($db);
   echo json_encode($projet->select());
}