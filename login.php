<?php
$title = 'Login';
require_once 'header.inc.php';

$url = (isset($url))? $url : 'moz/index.php';

if(!isset($_POST['login'])){
	echo '<form action="login.php" method="POST">
        <input type="hidden" name="login" value="process" />';
	echo '<table>
      <tr><td colspan="2">
          <p align="center">Login!</td>
      </tr>
      <tr>
        <td>Username:</td>
        <td>
          <p align="center"><input type="text" name="login_user" size="20">
          </p>
        </td>
        <td>
        <p align="center"><input type="submit" value="Login" name="Submit">
        </p>
        </td>
        </tr>
        </table>
        </center>';
} 
else if($_POST['login'] == 'process'){
    // Login check
    $login_user = (isset($_POST['login_user']))? $_POST['login_user'] : '';
    if (preg_match('/[^A-Za-z0-9_]/', $login_user)) {
        error('Invalid username. Valid characters are A-Z a-z 0-9 and _');
    }

    $one_week = time() + 86400*7;
    setcookie('mozhack', $login_user, "$one_week", "/", "");

    echo '<html><head>
    <center>If you are not automatically redirected, click <a href="'.$url.'">here</a>.
    <meta http-equiv=refresh content="0;url=\'index.php\'"></head></html>';
}

require_once "footer.inc.php";
?>
