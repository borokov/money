<?php
include("connectSql.php");

//On r�cup�re les valeurs entr�es par l'utilisateur :
$value=htmlspecialchars($_POST['value']);
$category=htmlspecialchars($_POST['category']);
                    
$base = connectMaBase();
                    
//On pr�pare la commande sql d'insertion
$sql = 'UPDATE operation SET cashed=1,date=now() WHERE id='.$_POST['id'];
                    
mysqli_query($base, $sql) or die ('Erreur SQL : '.$sql.'<br />'.mysqli_error($base)); 
                    
// on ferme la connexion
mysqli_close($base);

header('Location: index.php');  
?>
