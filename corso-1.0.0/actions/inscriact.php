<?php
require('actions/database.php');

//validation du formulaire
if(isset($_POST['envoyer'])){
     
    //vérifié si l'utilisateur a bien complété tous les champs
    if ( !empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['password']) ){

        //Les données de l'user
        $user_nom =htmlspecialchars($_POST['nom']);
        $user_email =htmlspecialchars($_POST['email']);
        $user_password =password_hash($_POST['password'],PASSWORD_DEFAULT);

        //Vérifier si l'utilisateur existe déjà sur le site
        $userexiste = $bdd->prepare('SELECT email FROM users WHERE email = ?');
        $userexiste->execute(array($user_email));

        if($userexiste->rowCount() == 0){
            
            //Insérer l'utilisateur dans la bdd
            $insertuser = $bdd->prepare('INSERT INTO users(nom,email,password) VALUES (?,?,?) ');
            $insertuser->execute(array($user_nom , $user_email , $user_password));

            //Récupérer les informations de l'utilisateur
            $getinfoUser = $bdd->prepare('SELECT id,nom,email FROM users WHERE nom=? AND email=? ');
            $getinfoUser->execute(array($user_nom, $user_email ));

            $userInfos = $getinfoUser->fetch();

            //Authentifier l'utilisateur sur  le site et récupérer ses donnés dans des variables globales sessions
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $userInfos['id'];
            $_SESSION['nom'] = $userInfos['nom'];
            $_SESSION['email'] = $userInfos['email'];

            //Rediriger l'utilisateur dans la page d'acceuil
            header('Location: formemp.php');

        }else{
            $errmsg = "L'utilisateur existe déjà";
        }

    }else{
        $errmsg = "Veuillez remplir tout les champs!";
    }


}
