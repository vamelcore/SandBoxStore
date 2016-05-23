<?php

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $nom = $_REQUEST['nom']; $raz = $_REQUEST['raz'];

if (($nom <> '') && ($raz <> '')) {
printf("<option value=''>Выберите цвет</option>");
session_start();
$myarray_tovar = $_SESSION['myarray_tovar'];
$index_tov = $_SESSION['myarray_tovar_ind'];
$flag_array = array(); $flag_index = 0;
for ($i=0; $i<$index_tov; $i++) {

    if (($nom == $myarray_tovar['nomer_mod'][$i]) && ($raz == $myarray_tovar['razmer'][$i])) 
    {
	$flag_val = true;
	for ($j=0; $j<=$flag_index; $j++) {if ($flag_array[$j] == $myarray_tovar['cvet'][$i]) {$flag_val = false;}}
	if ($flag_val == true) {
	$flag_array[$flag_index] = $myarray_tovar["cvet"][$i];   
	printf ("<option value='%s'>%s</option>" , $myarray_tovar["cvet"][$i], $myarray_tovar["cvet"][$i]);
	$flag_index++;
	}
	
	}
	
}

}
}
?>