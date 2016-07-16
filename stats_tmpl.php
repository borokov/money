
<?php

  $deltaMonth = 12;
  $minDate = strtotime("-".$deltaMonth." month");
  $maxDate = strtotime("now");
  

  // incomes
  $sql = 'SELECT SUM(value) FROM operation WHERE value > 0 AND category = "VSG" AND date > "'.date("Y-m-d H:i:s", $minDate).'"';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
  $data = mysql_fetch_assoc($req);
  $income = $data['SUM(value)'];

  // outcomes
  $sql = 'SELECT SUM(value) FROM operation WHERE value < 0 AND value>-1000 AND category!="Epargne" AND date > "'.date("Y-m-d H:i:s", $minDate).'"';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
  $data = mysql_fetch_assoc($req);
  $outcome = $data['SUM(value)'];

  // epargne
  $sql = 'SELECT SUM(value) FROM operation WHERE category="Epargne" AND date > "'.date("Y-m-d H:i:s", $minDate).'"';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
  $data = mysql_fetch_assoc($req);
  $epargne = $data['SUM(value)'];
  
  // CPAM
  $sql = 'SELECT SUM(value) FROM operation WHERE category="CPAM" AND date > "'.date("Y-m-d H:i:s", $minDate).'"';  
  $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
  $data = mysql_fetch_assoc($req);
  $CPAM = $data['SUM(value)'];

?>
  
   <script type="text/javascript">
      $(function () {
        $('#graphAllN1').highcharts({
            chart: { type: 'pie' },
            title: { text: '' },
            plotOptions: { pie: { dataLabels: { format: '<b>{point.name}</b>: <br/>{point.percentage:.1f}%, <br/>{point.y} €' } } },
            series: [{
                data: [
                  <?php  
                    $sql = 'SELECT SUM(value),category FROM operation WHERE date > "'.date("Y-m-d H:i:s", $minDate).'" AND value < 0 GROUP BY category';
                    $req =mysql_query($sql) or die("Erreur SQL !<br />".$sql."<br />".mysql_error());

                    while ($data = mysql_fetch_array($req)) 
                    {
                      $category = addslashes($data['category']);
                      $sumValue = $data['SUM(value)'];
                     if ($sumValue < 0) 
                     {
                        echo("{ name: '".$category."', y: ".abs($sumValue)." },");
                     }
                    }
                  ?>
                ]
            }]
        });
      });
  </script>

<div id="graphAllN1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

<br/>
<div>In (hors epargne): <?php echo(floor($income/$deltaMonth)) ?> &euro; / mois</div>
<div>Out (hors epargne): <?php echo(floor($outcome/$deltaMonth)) ?> &euro; / mois</div>
<div>Epargne moyenne: <?php echo(floor(-$epargne/$deltaMonth)) ?> &euro; / mois</div>
<div>CPAM: <?php echo($CPAM) ?> &euro; </div>



