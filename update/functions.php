<?php

function defender_xss_full($arr){
     $filter = array("<",">","=","(",")",";","/","&","?"); 
     foreach($arr as $num=>$xss){
        $xss=htmlspecialchars(strip_tags($xss));
        $arr[$num]=str_replace($filter, "|", $xss);
     }
       return $arr;
}
function defender_xss($arr){
    $filter = array("<",">"); 
     foreach($arr as $num=>$xss){
        $xss=htmlspecialchars(strip_tags($xss));
        $arr[$num]=str_replace($filter, "|", $xss);
     }
       return $arr;
}
function defender_xss_min($arr){
    $filter = array("<",">"); 
     foreach($arr as $num=>$xss){
        $arr[$num]=str_replace($filter, "|", $xss);
     }
       return $arr;
}
function defender_sql($arr){
    $counter= 0;
    $copy_arr = $arr;
    $filter = array("update","select","group by","from","where","into","set","union","char","order"); 
     foreach($copy_arr as $num=>$xss){
     	  $xss=mysql_real_escape_string($xss);
     	  $xss = strtolower($xss);
        $copy_arr[$num]=str_replace($filter, "WARNING_SQL_INGECT_WORD", $xss, $counter);
     }
     if ($counter == 0) {
     	     foreach($arr as $num=>$xss){
           $arr[$num]=mysql_real_escape_string($xss);
           }
     return $arr;
     }
     else {return $copy_arr;}      
}


function apostroff_repl($arr){
    $filter = array("'"); 
     foreach($arr as $num=>$xss){
        $arr[$num]=str_replace($filter, "`", $xss, $apostroff_counter);
     }
     if ($apostroff_counter > 0) {$_SESSION['apostroff_counter'] = $apostroff_counter;}
     else { if (isset($_SESSION['apostroff_counter'])) {unset($_SESSION['apostroff_counter']);}}
   return $arr;
}


function apostroff_back($arr){
	$copy_arr = $arr;
	if (isset($_SESSION['apostroff_counter'])) {	
    $filter = array("`"); 
     foreach($arr as $num=>$xss){
        $arr[$num]=str_replace($filter, "'", $xss, $apostroff_counter_2);
     }
     if ($apostroff_counter_2 = $_SESSION['apostroff_counter']) {return $arr; unset($_SESSION['apostroff_counter']);}
     else {return $copy_arr; unset($_SESSION['apostroff_counter']);}
	}
   else {return $copy_arr;}
}
?>

