<?php session_start();
if ((isset($_SESSION['user_id'])) && (isset($_SESSION['password_secret_id_string']))) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title> Мини-чат Multiservice</title>
  <link rel="stylesheet" href="css/general.css" type="text/css" media="screen" />
</head>
<body>
  <form method="post" id="form">
    <table>
      <tr>
        <td></td>
        <td><input class="text user" id="nick" type="hidden" value="<?php echo $_SESSION['login']; ?>" /></td>
      </tr>
      <tr>
        <td style="vertical-align: top;"><label>Сообщение</label></td>
        <td><textarea class="text" id="message" cols="30" rows="2"></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td><input id="send" type="submit" value="Отправить" /></td>
      </tr>
    </table>
  </form>
<div id="container" >
<div class="content" >
      <h1>Последние сообщения</h1>
      <div id="loading"><img src="css/images/loading.gif" alt="Загрузка..." /></div>
      <p>
    </div>
</div>
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="shoutbox.js"></script>
  <script type="text/javascript" src="jquery.timers.js"></script>
</body>
</html>
<?php 
}
else {

header("Location: index.php");
die();
}

?>