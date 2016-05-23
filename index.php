<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();   
    header("Location: index.php");
    exit(); // после передачи редиректа всегда нужен exit или die
    // иначе выполнение скрипта продолжится.
}

if (!isset($_SESSION['user_id']) || ($_SESSION['password_secret_id_string'] <> md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) { 
    session_regenerate_id(TRUE);
    session_unset();
    session_destroy();    
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Вход на SandBOX</title>
<link href="screen.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='js/jquery-1.3.2.js'></script>

<script type='text/javascript'>
function browser()
{
    var ua = navigator.userAgent;
   
    if (ua.search(/MSIE/) > 0) return 'Internet Explorer';
    if (ua.search(/Firefox/) > 0) return 'Firefox';
    if (ua.search(/Opera/) > 0) return 'Opera';
    if (ua.search(/Chrome/) > 0) return 'Google Chrome';
    if (ua.search(/Safari/) > 0) return 'Safari';
    if (ua.search(/Konqueror/) > 0) return 'Konqueror';
    if (ua.search(/Iceweasel/) > 0) return 'Debian Iceweasel';
    if (ua.search(/SeaMonkey/) > 0) return 'SeaMonkey';
   
    // Браузеров очень много, все вписывать смысле нет, Gecko почти везде встречается
    if (ua.search(/Gecko/) > 0) return 'Gecko';

    // а может это вообще поисковый робот
    return 'Search Bot';
}
</script>

<script type="text/javascript">
        $(document).ready(function() {
	
if (browser() != 'Safari')	{
	
            $(document).mouseup(function() {
				$("#loginform").mouseup(function() {
					return false
				});
				
				$("a.close").click(function(e){
					e.preventDefault();
					$("#loginform").hide();
                    $(".lock").fadeIn();
				});
				
                if ($("#loginform").is(":hidden"))
                {
                    $(".lock").fadeOut();
                } else {
                    $(".lock").fadeIn();
                }				
				$("#loginform").toggle();
            });
			
			
			// I dont want this form be submitted
			$("form#signin").submit(function() {
			  return true;
			});
			
			// This is example of other button
			$("input#cancel_submit").click(function(e) {
					$("#loginform").hide();
                    $(".lock").fadeIn();
			});			
			
			}
			else 
			{
			$(".lock").fadeOut(); $("#loginform").toggle();	
				}
        });
</script>
</head>
<body>
<div id="cont">
  <!--<div style="position:absolute; top: 20px; right: 50px;"><a href="http://aext.net/2009/08/learning-jquery-click-event-with-locked-page-likes-mac/" style="color:#FFFFFF; font-weight: bold;""> VIEW TUT </a></div> -->
  <div class="box lock"> </div>
  <div id="loginform" class="box form">
    <h2>Необходима авторизация <a href="" class="close">Close it</a></h2>
    <div class="formcont">
      <fieldset id="signin_menu">
      <span class="message">Добро пожаловать в SandBOX ver.1.3</span>
      <form method="post" id="signin" action="login.php">
        <label for="username">Имя пользователя</label>
        <input id="username" name="username" value="" title="Пользователь" class="required" tabindex="4" type="text">
        </p>
        <p>
          <label for="password">Пароль</label>
          <input id="password" name="password" value="" title="Пароль" class="required" tabindex="5" type="password">
        </p>
        <p class="clear"></p>
        <!--<a href="#" class="forgot" id="resend_password_link">Forgot your password?</a> -->
        <p class="remember">
          <input id="signin_submit" value="Вход" tabindex="6" type="submit">
          <input id="cancel_submit" value="Отмена" tabindex="7" type="button">
        </p>
      </form>
      </fieldset>
    </div>
    <div class="formfooter"></div>
  </div>
</div>
<!-- Begin Full page background technique -->
<div id="bg">
  <div>
    <table cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="images/backg.jpg" alt=""/> </td>
      </tr>
    </table>
  </div>
</div>
<!-- End Full page background technique -->
</body>
</html>

<?php
}

else { 

header("Location: page.php");

}
 ?>

