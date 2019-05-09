<?php

function UtilisateurModification($twig, $db, $action) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if( !isset($_GET["email"])) // si id n"k pas passé en parameter $_GET
    {
        if(isset($_POST["btModifier"])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Utilisateur($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire                                             ( à modifier en fonction de la page )
            $email = $_POST["email"];
            $nom = $_POST["inputNom"];
            $prenom = $_POST["inputPrenom"];
            $role = $_POST["inputRole"];
          
            $exec = $class_element->update($email, $role, $nom, $prenom); // et on met a jour l"element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page["message_invalid_modif"] = "Echec de la modification des informations de l'utilisateur"; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page["popup_type"] = "success";
                $infos_page["popup_message"] = "Modification des informations de l'utilisateur réussie"; //      ( à modifier en fonction de la page )
            }

            if(!empty($_POST["inputPassword"]))
            {
                $p1 = $_POST["inputPassword"];
                $p2 = $_POST["inputPassword2"];
                if ($p1 == $p2)
                {
                    $p1 = password_hash($p1, PASSWORD_DEFAULT);
                    $exec = $class_element->updateMdp($email, $p1);
                    if(!$exec)
                    {
                        if(!isset($infos_page["message_invalid_modif"]))
                            $infos_page["message_invalid_modif"] = "Echec de la modification du mot de passe";
                        else
                            $infos_page["message_invalid_modif"] .= " et échec de la modification du mot de passe"; //  ( à modifier en fonction de la page )
                    }
                    else
                    {
                        $infos_page["popup_type"] = "success";
                        if(!isset($infos_page["popup_message"]))
                            $infos_page["popup_message"] = "Modification du mot de passe réussie";
                        else
                            $infos_page["popup_message"] .= " et modification du mot de passe réussie"; //  ( à modifier en fonction de la page )
                    }
                }
                else
                {
                    if(!isset($infos_page["message_invalid_modif"]))
                        $infos_page["message_invalid_modif"] = "Echec de la modification du mot de passe";
                    else
                        $infos_page["message_invalid_modif"] .= " et échec de la modification du mot de passe"; //  ( à modifier en fonction de la page )
                }
            }
        }
    }

    if(isset($_GET["email"]) || isset($infos_page["message_invalid_modif"])) // Si id est passer en parametre alors
    {
        $class_element = new Utilisateur($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById(isset($_GET["email"]) ? $_GET["email"] : $_POST["email"]);
        if ($element != null){
            $infos_page["element_infos"] = $element; // on envoi les infos sur l"element si il existe
        }
        else // Sinon on affiche un message d"erreur
        {
            $infos_page["popup_type"] = "danger";
            $infos_page["popup_message"] = "Utilisateur invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    
    $action($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionUtilisateur($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    $class_element = new Utilisateur($db);//                                                                         ( à modifier en fonction de la page )
    $liste = $class_element->select();  // Recuperation de la liste d"elements

    $class_role = new Role($db);
    $liste_role = $class_role->select();

    echo $twig->render("utilisateur/utilisateur.html.twig", array("infos_page"=>$infos_page, "liste"=>$liste, "liste_role"=>$liste_role)); //    ( à modifier en fonction de la page )
}

function actionUtilisateurProfil($twig, $db, $infos_page = array()) 
{
    if(isset($_GET["email"])  || isset($_POST["email"])) // Si id est passer en parametre alors
    {
        $id_element = isset($_GET["email"]) ? $_GET["email"] : $_POST["email"];

        $class_element = new Utilisateur($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($id_element);
        if ($element != null){
            $class_role = new Role($db);

            $liste_role = $class_role->select();

            $idDev = $class_element->selectDevelopperId($id_element);
            if($idDev != null) {
                $class_maitrise = new Maitrise($db);
                $class_participation = new Participation($db);
                
                $element["idDev"] = $idDev["id"];
                $element["liste_maitrise"] = $class_maitrise->selectByIdDev($idDev["id"]);
                $element["liste_equipe"] = $class_participation->selectByIdDev($idDev["id"]);
            }

            echo $twig->render("utilisateur/utilisateur_profil.html.twig", array("infos_page"=>$infos_page, "element"=>$element, "liste_role"=>$liste_role));
        } else {
            $infos_page["popup_type"] = "danger";
            $infos_page["popup_message"] = "Utilisateur invalide"; //                            ( à modifier en fonction de la page )

            actionUtilisateur($twig, $db, $infos_page);
        }
    } else {
        actionUtilisateur($twig, $db);
    }
}

function actionUtilisateurSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET["email"]))
    {
        $class_element = new Utilisateur($db); //                                                            ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET["email"]); // Suppression de l"element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d"un message d"erreur si la suppresion n"a pas fonctionner
        {
            $infos_page["popup_type"] = "danger";
            $infos_page["popup_message"] = "Problème de suppression dans la table utilisateur"; //           ( à modifier en fonction de la page )
        }
        else // Affichage d"un message de succe si le contraire
        {
            $infos_page["popup_type"] = "success";
            $infos_page["popup_message"] = "Utilisateur supprimée avec succès"; //                           ( à modifier en fonction de la page )
        }
    }

    actionUtilisateur($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionUtilisateurProfilModif($twig, $db){ UtilisateurModification($twig, $db, "actionUtilisateurProfil"); } 
function actionUtilisateurModif($twig, $db){ UtilisateurModification($twig, $db, "actionUtilisateur"); } 