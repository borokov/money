<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<head>
  <title>Add Operation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="robots" content="noindex"/>
  <link rel="stylesheet" media="screen" type="text/css" title="defaut" href="design.css" />
</head>

<body>
<?php
  include("connectSql.php");
  connectMaBase();
  $sql = 'SELECT category FROM operation WHERE date > "'.date("Y-m-d H:i:s", strtotime("-1 year")).'" GROUP BY category';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
  mysql_close ();  
?>

<div id="conteneur">
  <div id="header"> <div> <h1>Add<h1> </div> </div>
<div id="corps">
  <hr/>

  <form name="operation" method="post" action="doAdd.php">
  <table>
    <tr><td>Val :</td><td> <input class="text_input" type="text" name="value"/></td></tr> 
    <tr><td>Categorie :</td> 
    <td>
    <select class="text_input" name="category">
    <?php                                
        while ($data = mysql_fetch_array($req)) {
          $category = $data['category'];
          echo('<option value="'.$category.'">'.$category.'</option>');
        }
      ?>
    </select>
    </td>
    </tr>
    </table>
    <input class="button_input" type="submit" name="add" value="add"/>
  </form>

</div>
<div id="footer"></div>
</div>
</body>
</html>
