<?php
require('actions/database.php');

//validation du formulaire
if(isset($_POST['envoyer'])){
     
    //vérifié si l'utilisateur a bien complété tous les champs
    if ( !empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['pays']) AND !empty($_POST['montant']) AND !empty($_POST['profession']) AND !empty($_POST['objet']) ){
         //Les données de l'user
        $user_nom =htmlspecialchars($_POST['nom']);
        $user_prenom =htmlspecialchars($_POST['prenom']);
        $user_pays =htmlspecialchars($_POST['pays']);
        $user_montant =htmlspecialchars($_POST['montant']);
        $user_profession =htmlspecialchars($_POST['profession']);
        $user_objet =htmlspecialchars($_POST['objet']);
        $user_id_auteur = $_SESSION['id'];
        $user_nom_auteur = $_SESSION['nom'];

         //Insérer l'utilisateur dans la bdd
         $inserdemande = $bdd->prepare('INSERT INTO demande(nom,prenom,pays,montant,profession,objet,id_auteur,nom_auteur) VALUES (?,?,?,?,?,?,?,?) ');
         $inserdemande->execute(array($user_nom , $user_prenom , $user_pays , $user_montant , $user_profession , $user_objet,$user_id_auteur,$user_nom_auteur));
         $errmsg = "Veillez revenir d'ici 24h pour voir le statut de votre demande";
    }

}
