<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  
	  $nom = $_REQUEST['nom']; $raz = $_REQUEST['raz']; $cvet = $_REQUEST['cvet']; $mat = $_REQUEST['mat']; $tov_kat = $_REQUEST['tov_kat'];
	  if (isset($_REQUEST['mag'])) {$mag = $_REQUEST['mag'];} else {$mag = 'all';}

if (($nom <> '') && ($raz <> '') && ($cvet <> '') && ($mat <> '') && ($tov_kat <> '')) {

session_start();
$myarray_tovar = $_SESSION['myarray_tovar'];
$index_tov = $_SESSION['myarray_tovar_ind'];

for ($i=0; $i<$index_tov; $i++) {

    if (($nom == $myarray_tovar['nomer_mod'][$i]) && ($raz == $myarray_tovar['razmer'][$i]) && ($cvet == $myarray_tovar['cvet'][$i]) && ($mat == $myarray_tovar['material'][$i])) 
    {

$cena_for_prod = $myarray_tovar['cena'][$i];
$voznag_for_prod = $myarray_tovar['voznag'][$i];

if ($mag <> 'all') {
$res_diff_cena = mysql_query("SELECT * FROM `diff_cena` WHERE `ID_magazina` = '$mag' AND `ID_tovara` = '{$myarray_tovar['ID'][$i]}'",$db);
          if (mysql_num_rows($res_diff_cena) > 0) {
		  $myr_diff_cena = mysql_fetch_array($res_diff_cena);
		  $cena_for_prod = $myr_diff_cena['new_cena'];
		  $voznag_for_prod = $myr_diff_cena['new_bonus'];
		  }
}

switch($tov_kat) {
	case "cena":
	    printf('<input type="text" name="cena" id="index_cena" readonly value="%s">',$cena_for_prod);
	    break;
	case "voznag":
	    printf('<input type="text" name="voznag" id="index_voznag" readonly value="%s">',$voznag_for_prod);
	    break;
//	case "cena_edit":
//	    printf('<input name="cena" type="text" value="%s">',$myrow_tov['cena']);	 
//	    break;
//	case "voznag_edit":
//	    printf('<input name="voznag" type="text" value="%s">',$myrow_tov['voznag']);
//	    break;
	case "tov_id":
	    printf('<input type="hidden" name="tovar_id" id="ident_tovar" value="%s">',$myarray_tovar['ID'][$i]);
	    break;   
                 }	
	
	}
	
}

}
}
?>