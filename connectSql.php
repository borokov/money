<?php
error_reporting(E_ALL ^ E_DEPRECATED);
function connectMaBase(){
    $base = mysql_connect ('localhost', 'user', 'password');  
    mysql_select_db ('db_name', $base) ;
}
?>
