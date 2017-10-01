<?php
include("connectSql.php");

//On recupere les valeurs entrees par l'utilisateur :
$value=addslashes(htmlspecialchars(htmlentities($_POST['value'])));
$category=addslashes(htmlspecialchars(htmlentities($_POST['category'])));
                    
$base = connectMaBase();
                    
//On prepare la commande sql d'insertion
$sql = 'INSERT INTO operation (value, category) VALUES ('.$value.',"'.$category.'")';
                    
mysqli_query($base, $sql) or die ('Erreur SQL : '.$sql.'<br />'.mysqli_error($base)); 
                    
// on ferme la connexion
mysqli_close($base);

header('Location: index.php');  
?>
