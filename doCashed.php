<?php
include("connectSql.php");

//On r�cup�re les valeurs entr�es par l'utilisateur :
$value=htmlspecialchars($_POST['value']);
$category=htmlspecialchars($_POST['category']);
                    
connectMaBase();
                    
//On pr�pare la commande sql d'insertion
$sql = 'UPDATE operation SET cashed=1,date=now() WHERE id='.$_POST['id'];
                    
mysql_query ($sql) or die ('Erreur SQL : '.$sql.'<br />'.mysql_error()); 
                    
// on ferme la connexion
mysql_close();

header('Location: index.php');  
?>
