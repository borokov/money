<?php
include("connectSql.php");

//On récupère les valeurs entrées par l'utilisateur :
$value=addslashes(htmlspecialchars(htmlentities($_POST['value'])));
$category=addslashes(htmlspecialchars(htmlentities($_POST['category'])));
                    
connectMaBase();
                    
//On prépare la commande sql d'insertion
$sql = 'INSERT INTO operation (value, category) VALUES ('.$value.',"'.$category.'")';
                    
mysql_query ($sql) or die ('Erreur SQL : '.$sql.'<br />'.mysql_error()); 
                    
// on ferme la connexion
mysql_close();

header('Location: index.php');  
?>
