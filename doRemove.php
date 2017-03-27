<?php
include("connectSql.php");

//On récupère les valeurs entrées par l'utilisateur :
$value=htmlspecialchars($_POST['value']);
$category=htmlspecialchars($_POST['category']);
                    
connectMaBase();
                    
//On prépare la commande sql d'insertion
$sql = 'DELETE FROM operation WHERE id='.$_POST['id'];
                    
mysql_query ($sql) or die ('Erreur SQL : '.$sql.'<br />'.mysql_error()); 
                    
// on ferme la connexion
mysql_close();

header('Location: index.php');  
?>
