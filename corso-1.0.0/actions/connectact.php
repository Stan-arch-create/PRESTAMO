<?php
require('actions/database.php');

//validation du formulaire
if(isset($_POST['envoyer'])){
     
    //vérifié si l'utilisateur a bien complété tous les champs
    if ( !empty($_POST['email']) AND !empty($_POST['password']) ){

        //Les données de l'user
        $user_email =htmlspecialchars($_POST['email']);
        $user_password =htmlspecialchars($_POST['password'],PASSWORD_DEFAULT);

        //Vérifier si l'utilisateur existe
        $recupemailUser = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $recupemailUser->execute(array($user_email));

        if($recupemailUser->rowCount() >0){

            //Récupérer les données de l'utilisateur
            $usersInfos = $recupemailUser->fetch();

            //Vérifier si le mot de passe est correct
            if(password_verify($user_password, $usersInfos['password'])){

                 //Authentifier l'utilisateur sur  le site et récupérer ses donnés dans des variables globales sessions
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $usersInfos['id'];
                $_SESSION['nom'] = $usersInfos['nom'];
                $_SESSION['email'] = $usersInfos['email'];

                header('Location: formemp.php');

            }else{
                $errmsg = "Votre mot de passe est incorrect!"; 
            }

        }else{
            $errmsg = "Votre pseudo est incorrect!";
        }

    }else{
        $errmsg = "Veuillez remplir tout les champs!";
    }


}
