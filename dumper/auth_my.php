<?php include ("../config.php");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {
  
if($this->connect($host, '', $user, $pass)) {
$this->CFG['my_db'] = $base;
$this->CFG['exitURL'] = '../users.php';
$auth = 1;
  } 
  }
else {
$auth = 0;	
	}
?>