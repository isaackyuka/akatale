<?php 
session_start();
require_once('includes/database.php');

if(isset($_POST['login'])){
	
	$email = trim($_POST['emailaddr']);
	$passwd = trim($_POST['passwd']);
	$myemail = stripslashes($email);
$mypassword = stripslashes($passwd);
$dbemail = mysql_real_escape_string($myemail);
$dbpasswd = mysql_real_escape_string($mypassword);
	$query = mysql_query("SELECT * FROM customer WHERE email='$dbemail' AND password='$dbpasswd' ");
	$count=mysql_num_rows($query);
	if($count==1){
		$row=mysql_fetch_array($query);
		$_SESSION['lname'] = $row['lastname'];
		$_SESSION['fname'] = $row['firstname'];
		$_SESSION['email'] = $row['email'];
		if(isset($_GET['return_url'])){
$return_url = base64_decode($_GET["return_url"]); //return url
	header('Location:'.$return_url);
} else{
	header("location:index.php");
}
		
	}  else{
		echo "<script type='text/javascript'> 
window.location.href = 'login.php?msg=Password or Email Addrress mismatch';
</script>"; 
echo mysql_error();
	}
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Akatale</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
fieldset{
	width:auto;
	float:left;
	overflow:hidden;
}
input, textarea{
	width:250px;
}
#main{width:700px;
}
</style>
</head>

<body>
<div id="header"><h1>Akatale.com</h1></div>
<div id="container">
  <div id="main"><h2>Login Customer</h2>
  <form action="login.php" method="post">
  <fieldset><legend>LOGIN</legend>
   <?php if(isset($_GET['msg'])) {
$msg = $_GET['msg'];
echo '<span style="color:#0C0;">'.$msg.'</span>';
} else {
echo '';
} ?>
  <p><label>Email Address</label><br/><input type="email" name="emailaddr" /></p>
  <p><label>Password</label><br/><input type="password" name="passwd" /></p>
  <p> <input type="submit" name="login" value="LOGIN"  /><br/> <a href="register.php">REGISTER</a></p>
</fieldset>
 </form>
  </div>
  <div id="sidebar"></div>
</div>
<div id="footer"></div>
</body>
</html>

<?php } ?>