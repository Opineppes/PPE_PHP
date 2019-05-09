<?php
function EntrepriseModification($twig, $db,$action) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['id'])) // Si id est passer en parametre alors
    {
        $class_element = new Entreprise($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['id']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Entreprise invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Entreprise($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire    ( à modifier en fonction de la page )
            $libelle= $_POST['inputLibelle'];                                         
            $id = $_POST['id'];
            $nomContact = $_POST['inputNomContact'];
            $adresse= $_POST['inputAdresse'];
            $ville = $_POST['inputVille'];
            $cp= $_POST['inputCp'];


            $exec = $class_element->update($id,$libelle,$adresse,$cp,$ville,$nomContact); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = 'Echec de la modification de la entreprise'; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification de la entreprise réussie"; //      ( à modifier en fonction de la page )
            }
        }
    }
    
    $action($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

// Affichage de la liste des entreprise
function actionEntreprise($twig, $db, $infos_page = array())
{

    //envoi de la liste et des informations complementaire de la page (popup_message, popup_type, message_invalid_ajout, element_infos, ...)
    echo $twig->render('entreprise/entreprise.html.twig', array('infos_page'=>$infos_page));
}

//Suppression de l'entreprise
function actionEntrepriseSuppr($twig, $db)
{
    $infos_page = array();
    if(isset($_GET['id']))
    {
        $class_element = new Entreprise($db);

        // Suppression de l'element a partir de son identifiant
        $exec = $class_element->delete($_GET['id']); 
        if (!$exec)
        {
            //si la suppression a echoué nous definissons les variable permettant l'affichage d'un popup type erreur
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table entreprise';
        }
        else
        {
            //si la suppression a echoué nous definissons les variable permettant l'affichage d'un popup type succe
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'entreprise supprimée avec succès';
        }
    }
    
    // Affichage de la page avec la liste des elements
    actionEntreprise($twig, $db, $infos_page);
}

function actionEntrepriseAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Entreprise($db); //                                                               ( à modifier en fonction de la page )

        // Recuperation des element passer en $_POST ( à modifier en fonction de la page )
        $libelle= $_POST['inputLibelle'];                                                      
        $nomContact = $_POST['inputNomContact'];
        $adresse= $_POST['inputAdresse'];
        $ville = $_POST['inputVille'];
        $cp= $_POST['inputCp'];

        
      
        $exec = $class_element->insert($libelle,$adresse,$cp,$ville,$nomContact); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page )
        if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table Entreprise '; //    ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Ajout de l'entreprise reussi"; //                              ( à modifier en fonction de la page )
        }
    }

    actionEntreprise($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionEntrepriseProfil($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    if(isset($_GET["id"])  || isset($_POST["id"])) // Si id est passer en parametre alors
    {
        $id_element = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"]; //condition d'attribution 

        $class_element = new Entreprise($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($id_element);
        if ($element != null){
          
            echo $twig->render("entreprise/entreprise_profil.html.twig", array("infos_page"=>$infos_page, "element"=>$element));

        } else {
            $infos_page["popup_type"] = "danger";
            $infos_page["popup_message"] = "Entreprise invalide"; //                            ( à modifier en fonction de la page )

            actionEntreprise($twig, $db, $infos_page);
        }
    } else {
        actionEntreprise($twig, $db);
    }
}

function actionEntrepriseProfilModif($twig, $db){ EntrepriseModification($twig, $db, "actionEntrepriseProfil"); } 
function actionEntrepriseModif($twig, $db){ EntrepriseModification($twig, $db, "actionEntreprise"); } 

function actionEntrepriseWS($twig, $db)
{
   $entreprise = new Entreprise($db);
   echo json_encode($entreprise->select());
}