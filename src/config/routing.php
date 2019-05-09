<?php

function getPage($twig, $db){

    // Inscrire vos contrôleurs ici

    //page vitrine
    $lesPages['accueil'] = "actionAccueil;0";
    $lesPages['mentions'] = "actionMentions;0";
    $lesPages['apropos'] = "actionApropos;0";
    $lesPages['maintenance'] = "actionMaintenance;0";

    //page de securite
    $lesPages['inscrire'] = "actionInscrire;0";
    $lesPages['connexion'] = "actionConnexion;0";
    $lesPages['deconnexion'] = "actionDeconnexion;0";

    //pages utilisateur
    $lesPages['utilisateur'] = "actionUtilisateur;1";
    $lesPages['utilisateursuppr'] = "actionUtilisateurSuppr;1";
    $lesPages['utilisateurmodif'] = "actionUtilisateurModif;1";

    $lesPages['utilisateurprofil'] = "actionUtilisateurProfil;1";
    $lesPages['utilisateurprofilmodif'] = "actionUtilisateurProfilModif;1";

    //pages entreprise
    $lesPages['entreprise'] = "actionEntreprise;1";
    $lesPages['entreprisesuppr'] = "actionEntrepriseSuppr;1";
    $lesPages['entrepriseajout'] = "actionEntrepriseAjout;1";
    $lesPages['entreprisemodif'] = "actionEntrepriseModif;1";
    $lesPages['entreprisews'] = "actionEntrepriseWS;1";
    
    $lesPages['entrepriseprofil']="actionEntrepriseProfil;1";
    $lesPages['entrepriseprofilmodif']="actionEntrepriseProfilModif;1";

    //pages projet
    $lesPages['projet'] = "actionProjet;1";
    $lesPages['projetsuppr'] = "actionProjetSuppr;1";
    $lesPages['projetajout'] = "actionProjetAjout;1";
    $lesPages['projetmodif'] = "actionProjetModif;1";
    $lesPages['projetws'] = "actionProjetWS;0";

    $lesPages['projetprofil']="actionProjetProfil;1";
    $lesPages['projetprofilmodif']="actionProjetProfilModif;1";

    //pages equipe
    $lesPages['equipe'] = "actionEquipe;1";
    $lesPages['equipesupprws'] = "actionEquipeSupprWS;1";
    $lesPages['equipeajoutws'] = "actionEquipeAjoutWS;1";
    $lesPages['equipemodifws'] = "actionEquipeModifWS;1";
    $lesPages['equipews'] = "actionEquipeWS;0";

    //pages outil
    $lesPages['outil'] = "actionOutil;1";
    $lesPages['outilsuppr'] = "actionOutilSuppr;1";
    $lesPages['outilajout'] = "actionOutilAjout;1";
    $lesPages['outilmodif'] = "actionOutilModif;1";

    //pages remuneration
    $lesPages['remuneration'] = "actionRemuneration;1";
    $lesPages['remunerationsuppr'] = "actionRemunerationSuppr;1";
    $lesPages['remunerationajout'] = "actionRemunerationAjout;1";
    $lesPages['remunerationmodif'] = "actionRemunerationModif;1";

    //pages contrat
    $lesPages['contrat'] = "actionContrat;1";
    $lesPages['contratsuppr'] = "actionContratSuppr;1";
    $lesPages['contratajout'] = "actionContratAjout;1";
    $lesPages['contratmodif'] = "actionContratModif;1";
    $lesPages['contratws'] = "actionContratWS;0";

    //pages developpeur
    $lesPages['developpeur'] = "actionDeveloppeur;1";
    $lesPages['developpeursuppr'] = "actionDeveloppeurSuppr;1";
    $lesPages['developpeurajout'] = "actionDeveloppeurAjout;1";
    $lesPages['developpeurmodif'] = "actionDeveloppeurModif;1";

    //pages tache
    $lesPages['tache'] = "actionTache;1";
    $lesPages['tachesuppr'] = "actionTacheSuppr;1";
    $lesPages['tacheajout'] = "actionTacheAjout;1";
    $lesPages['tachemodif'] = "actionTacheModif;1";

    // $lesPages contient deux informations en valeur 
    //    avant ; la fonction
    //    apres ; le droit necessaire a l'affichage

    $page = 'accueil'; //nous definissons la variable $page avec une valeur par defaut
    if ($db!=null){
        if( isset( $_GET['page'] ) && isset($lesPages[ $_GET['page'] ]) ){
            // Si une page a été passer en parametre, et que celle ci existe dans $lesPages, alors nous attribuons la valeur passer en parametre a $page
            $page = $_GET['page']; 
        }

        $role = explode( ";", $lesPages[$page] ) [1];

        // Si la page necessite un droit d'acce et que: soit la personne n' est pas connectée, 
        //                                              soit elle ne possede pas de role
        //                                              soit que son role ne correspond pas au role requis
        if( $role != 0 && ( !isset($_SESSION['login']) || !isset($_SESSION['role']) || $role != $_SESSION['role'] ))
        {
            // nous redefinisson la page a la page d'accueil
            $page = "accueil";
        }
    }
    else
    {
        // Si la base de donnée n'est pas accessible nous redirigeon ver la page maintenance;
        $page = 'maintenance';
    }

    $twig->addGlobal("page", $page); //nous ajoutons une variable global a twig afin de savoir sur quel page nous nous trouvons

    // La fonction envoie le contenu
    return explode(";", $lesPages[$page])[0];
}