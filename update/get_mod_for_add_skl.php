<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kateg=$_REQUEST['kateg']; $brend=$_REQUEST['brend'];

if (($kateg <> '') && ($brend <> '')) {
$result = mysql_query("SELECT DISTINCT `nomer_mod` FROM `prase` WHERE `ID_kategorii`='$kateg' AND `ID_brenda`='$brend' ORDER BY `nomer_mod`",$db);

printf("<option value=''>Выберите номер модели</option>");
 while ($myrow = mysql_fetch_array($result)) {
     printf (" <option value='%s'>%s</option>" , mysql_real_escape_string($myrow["nomer_mod"]), $myrow["nomer_mod"]);
    }
}
else {
   	printf("<option value=''></option>");
   	session_start();

   	unset($_SESSION['sklad_add_br']);
   	unset($_SESSION['sklad_add_mod']);
   	unset($_SESSION['sklad_add_razmer']);
   	unset($_SESSION['sklad_add_cvet']);
   	unset($_SESSION['sklad_add_mater']);	
	}
}

?>