<?php

function actionTache($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    $class_element = new Tache($db);//                                                                         ( à modifier en fonction de la page )
    $liste = $class_element->select();  // Recuperation de la liste d'elements

    $class_developpeur = new Developpeur($db);
    $liste_developpeur = $class_developpeur->select();

    $class_projet = new Projet($db);
    $liste_projet = $class_projet->select();

    echo $twig->render('tache/tache.html.twig', array('infos_page'=>$infos_page, 'liste'=>$liste,'liste_developpeur'=>$liste_developpeur,'liste_projet'=>$liste_projet)); //    ( à modifier en fonction de la page )
}

function actionTacheSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET['code']))
    {
        $class_element = new Tache($db); //                                                            ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET['code']); // Suppression de l'element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table tache'; //           ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Tache supprimée avec succès'; //                           ( à modifier en fonction de la page )
        }
    }

    actionTache($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionTacheAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Tache($db); //                                                               ( à modifier en fonction de la page )

        // Recuperation des element passer en $_POST                                                        ( à modifier en fonction de la page )
        $libelle=$_POST['inputLibelle'];
        $cout=$_POST['inputCout'];
        $heures=$_POST['inputHeures'];
        $idDev=$_POST['inputIdDev'];
        $codeProjet=$_POST['inputCodeProjet'];
        
      
        $exec = $class_element->insert($libelle,$cout,$heures,$idDev,$codeProjet); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page )
        if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table tache '; //    ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Ajout de la tache reussie"; //                              ( à modifier en fonction de la page )
        }
    }

    actionTache($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionTacheModif($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['code'])) // Si id est passer en parametre alors
    {
        $class_element = new Tache($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['code']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Tache invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Tache($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire                                             ( à modifier en fonction de la page )
            $code = $_POST['code'];
            $libelle=$_POST['inputLibelle'];
            $cout=$_POST['inputCout'];
            $heures=$_POST['inputHeures'];
            $idDev=$_POST['inputIdDev'];
            $codeProjet=$_POST['inputCodeProjet'];
          
            $exec = $class_element->update($code,$libelle,$cout,$heures,$idDev,$codeProjet); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = 'Echec de la modification de la tache'; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification de la tache réussie"; //      ( à modifier en fonction de la page )
            }
        }
    }
    
    actionTache($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}