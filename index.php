<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
  <title>Money</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="robots" content="noindex" />
  <link rel="stylesheet" media="screen" type="text/css" title="defaut" href="design.css" />
  <link href="jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <link href="jquery-ui/jquery-ui.theme.min.css" rel="stylesheet">
  <script type="text/javascript" src="jquery-ui/external/jquery/jquery.js"></script>
  <script type="text/javascript" src="jquery-ui/jquery-ui.min.js"></script>
</head>

<script>
  
  var addForm;
  
  function showAdd() { 
    //addForm.show("blind", {}, 500); 
    addForm.css({'display':'block'});
  }
  function hideAdd() { 
    //addForm.hide("blind", {}, 500); 
    addForm.css({'display':'none'});
  }
  
  function showEvent() { $("#eventForm").show("blind", {}, 500); }
  function hideEvent() { $("#eventForm").hide("blind", {}, 500); }
  
  function hideAll() { hideAdd(); hideEvent(); }
  
  function doAdd(value, category) {
    $.post("doAdd.php", { value: value, category: category }, function(){location.reload(true);} );
  }

  $(function() {
    addForm = $("#addForm");
    $("#addButton").button().click(function(event) {
      hideAll();
      showAdd();
    });
    $("#doAddButton").button().click(function(event) {
      doAdd($("#doAddValue").val(), $("#selectCategory").val());
    });
    
    $("#eventsButton").button().click(function(event) {
      hideAll();
    });
    
    $("#statsButton").button().click(function(event) {
     hideAll();
    });
    
    $( "#selectCategory" ).selectmenu();
  });
</script>

<body>
  <?php
include("connectSql.php");
?>

<div id="conteneur">
<div id="header">
<div>
<h1>Vive les pandas !!! <h1> </div> </div>
<div id="corps">
<hr/>

<?php
  //On se connecte
  connectMaBase();
?>

<?php
  $sql = 'SELECT SUM(value) FROM operation';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
  $data = mysql_fetch_assoc($req);

  $finalValue = $data['SUM(value)'];

  $sql = 'SELECT SUM(value) FROM operation WHERE cashed=1';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
  $data = mysql_fetch_assoc($req);

  $currentValue = $data['SUM(value)'];
?>

  <div id="value"><span id="left">Final: <?php echo($finalValue) ?> &euro;</span> Current: <?php echo($currentValue) ?> &euro;</div>


<div id="navbar">
  <!-- <ul>
    <li><a href="add.php">add</a></li> 
    <li><a href="events.php">events</a></li>
    <li><a href="stats.php">stats</a></li>
  </ul> --> 
  
  <button id="addButton">Add</button>
  <button id="eventsButton">events</button>
  <button id="statsButton">stats</button>
</div>
  
<div id="addForm" class="ui-widget-content ui-corner-all" style="display: none">
<p>
  <?php     
    $sql = 'SELECT category FROM operation WHERE date > "'.date("Y-m-d H:i:s", strtotime("-1 year")).'" GROUP BY category';  
    $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
  ?> 
  <table>
    <tr><td>Val :</td><td> <input class="text_input" type="text" id="doAddValue"/></td></tr> 
    <tr><td>Categorie :</td> 
    <td>
    <select id="selectCategory" name="category" style="width: 200px">
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
    <button id="doAddButton">Add</button>
  </p>
</div>
  
<div id="eventForm">
 
</div>


<?php                                
  // On prepare la requete 
  $sql = 'SELECT * FROM operation ORDER BY date DESC';  
                                 
  // On lance la requ�te (mysql_query) et on impose un message d'erreur si la requ�te ne se passe pas (or die)  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());  
?>

<table>
  <tr>
    <th>Date</th>
    <th>Category</th>
    <th>Value</th>
    <th></th>
  </tr>                           
<?php                                
        $prevMonth = 0;
        while ($data = mysql_fetch_array($req)) {

          $curMonth = date('m', strtotime($data['date']));
          if ( $curMonth != $prevMonth )
          {
            echo('<tr class="separation"><td/><td/><td></td><td/></tr>');
          }
          $prevMonth = $curMonth;
          
          // style de rendu
          if ( $data['value'] < 0 )
            echo '<tr class="negative">';
          else
            echo '<tr class="positive">';
          
          // donnee
          echo '<td>'.date('d/m/y', strtotime($data['date'])).'</td>'; 
          echo '<td>'.html_entity_decode(stripslashes($data['category'])).'</td>';  
          echo '<td class="value">'.$data['value'].' &euro;</td>';  

            // if still not payed
            if ( $data['cashed'] != 1 )
            { ?>
              <td>
              <form name="cached" method="post" action="doCashed.php">
                <input type="hidden" name="id" value="<?php echo($data['id']); ?>"/>
                <input class="button_input" type="submit" value="pay"/>
              </form>
              <form name="remove" method="post" action="doRemove.php">
                <input type="hidden" name="id" value="<?php echo($data['id']); ?>"/>
                <input class="button_input" type="submit" value="del"/>
              </form>

              </td>
            <?php 
            } else {
              echo('<td></td>');
            }
            
          echo '</tr>';
        }  
        //On lib�re la m�moire mobilis�e pour cette requ�te dans sql
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