<?php
include("connectSql.php");

//On recupere les valeurs entrees par l'utilisateur :
$value=htmlspecialchars($_POST['value']);
$category=htmlspecialchars($_POST['category']);
                    
$base = connectMaBase();
                    
//On prepare la commande sql d'insertion
$sql = 'DELETE FROM operation WHERE id='.$_POST['id'];
                    
mysqli_query($base, $sql) or die ('Erreur SQL : '.$sql.'<br />'.mysqli_error($base)); 
                    
// on ferme la connexion
mysqli_close($base);

header('Location: index.php');  
?>
