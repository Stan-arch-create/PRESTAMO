<?php

try{
    $bdd= new PDO("mysql:host=localhost;dbname=pret","root","");
}catch(Exception $e){
    die("Une erreur à été trouvé : ". $e->getMessage());
}
