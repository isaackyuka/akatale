<?php 
require_once('includes/database.php');
if(isset($_POST['register'])){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$emailaddr = $_POST['emailaddr'];
	$emailaddr2 = $_POST['emailaddr2'];
	$passwd = $_POST['passwd'];
	$passwd2 = $_POST['passwd2'];
	/* $deladdress = $_POST['deladdress'];
	$city = $_POST['city'];
	$region = $_POST['region'];
	$ctry = $_POST['ctry'];
	$phoneno = $_POST['phoneno']; */
	if(($passwd === $passwd2) && ($emailaddr === $emailaddr2)){
	$query = mysql_query("insert into customer (firstname, lastname, email, password) values('$fname', '$lname', '$emailaddr', '$passwd')");
	if($query){
	 
	echo "<script type='text/javascript'> 
window.location.href = 'register.php?msg=You were registered Successfully.';
</script>"; 
	}
	} else{
		echo "<script type='text/javascript'> 
window.location.href = 'register.php?msg=Password or Email Addrress mismatch';
</script>"; 
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
  <div id="main"><h2>Register Customer</h2>
  <form action="register.php" method="post" >
  <?php if(isset($_GET['msg'])) {
$msg = $_GET['msg'];
echo '<span style="color:#0C0;">'.$msg.'</span>';
} else {
echo '';
} ?>
  <fieldset><legend>LOGIN DETAILS</legend>
<p><label>First Name</label><br/><input type="text" name="fname" /></p><p><label>Last Name</label><br/><input type="text" name="lname" /></p>
  <p><label>Email Address</label><br/><input type="email" name="emailaddr" /></p>
  <p><label>Confirm Email Address</label><br/><input type="email" name="emailaddr2" /></p>
  <p><label>Password</label><br/><input type="password" name="passwd" /></p>
  <p><label>Confirm Password</label><br/><input type="password" name="passwd2"  /></p>
</fieldset>
 
 <fieldset><legend>ADDRESS DETAILS</legend>
<p><label>Delivery Address</label><br/>
 <textarea name="deladdrees" rows="6" cols="30"></textarea>
 </p>
 <p><label>City</label><br/><input type="text" name="city" /></p>
 <p><label>Region</label><br/><input type="text" name="region" /></p>
 <p><label>Country</label><br /><input type="text" name="ctry"  /></p>
 <p><label>Phone Number</label><br/><input type="tel" name="phoneno"  /></p>
</fieldset>
 <p> <input type="submit" name="register" value="REGISTER"  /></p>
 </form>
  </div>
  <div id="sidebar"></div>
</div>
<div id="footer"></div>
</body>
</html><?php }?>