<?php
$host = 'localhost'; 
$user = 'dar'; 
$pass = 'dar'; 
$base = 'zadmin_dar'; 


@$db = mysql_connect ($host,$user,$pass);
@mysql_select_db($base,$db);
mysql_query("SET NAMES 'utf8'");
ini_set('display_errors', '0');

?>