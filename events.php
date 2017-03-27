<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<head>
  <title>Money</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="robots" content="noindex"/>
  <link rel="stylesheet" media="screen" type="text/css" title="defaut" href="design.css" />
</head>

<body>
<?php
include("connectSql.php");
?>

<div id="conteneur">
  <div id="header"> <div> <h1>Vive les pandas !!! <h1> </div> </div>
<div id="corps">
<hr/>

<?php
  //On se connecte
  connectMaBase();
?>

<?php
  $sql = 'SELECT SUM(value) FROM events';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
  $data = mysql_fetch_assoc($req);

  $total = $data['SUM(value)'];
?>

  <div>Total: <?php echo($total) ?> &euro;</div>



<?php                                
  // On prépare la requête 
  $sql = 'SELECT * FROM events';  
                                 
  // On lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas (or die)  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
?>

<table>
  <tr>
    <th>Echeance</th>
    <th>Category</th>
    <th>Value</th>
    <th></th>
  </tr>                           
<?php                                
        //boucle
        while ($data = mysql_fetch_array($req)) {
          echo '<tr>';
            // on affiche les résultats 
            echo '<td>'.date('d/m', strtotime($data['date'])).'</td>'; 
            echo '<td>'.html_entity_decode(stripslashes($data['category'])).'</td>';  
            echo '<td class="value">'.html_entity_decode(stripslashes($data['value'])).' &euro;</td>';  
            ?>
              <td>
              <form name="cached" method="post" action="doAdd.php">
                <input type="hidden" name="value" value="<?php echo($data['value']); ?>"/>
                <input type="hidden" name="category" value="<?php echo(html_entity_decode(html_entity_decode(stripslashes($data['category'])))); ?>"/>
                <input class="button_input" type="submit" value="pay"/>
              </form>
              </td>
            <?php 
            
          echo '</tr>';
        }  
        //On libère la mémoire mobilisée pour cette requête dans sql
        //$data de PHP lui est toujours accessible !
        mysql_free_result ($req);  
?>
</table>
                
<?php     
        //On ferme sql
        mysql_close ();  
?>
<br/>

</div>
<div id="footer"></div>
</div>
</body>
</html>
