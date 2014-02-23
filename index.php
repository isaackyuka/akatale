<?php 
session_start();
require_once('includes/database.php');
require_once('includes/functions.php');
if(isset($_GET['page'])){
	$pages=array("products", "cart", "item", "category");
	if(in_array($_GET['page'], $pages)) {
		$_page=$_GET['page'];
	} else {
		$_page="products";
	}
}else {
	$_page="products";
}
$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
	$return_url = base64_decode($_GET["return_url"]); //return url
	session_destroy();
	header('Location:'.$return_url);
}
//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["cart"]))
{
	$product_code 	= $_GET["removep"]; //get the product code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["cart"] as $cart_itm) //loop through session array var
	{
		if($cart_itm["code"]!=$product_code){ //item does,t exist in the list
			$product[] = array('name'=>$cart_itm["name"], 'id'=>$cart_itm["id"], 'quantity'=>$cart_itm["quantity"], 'price'=>$cart_itm["price"]);
		}
		
		//create a new product list for cart
		$_SESSION["cart"] = $product;
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Akatale</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="header"><h1 style="float:left;"><a href="index.php">Akatale.com</a></h1> 
 <div style="float:right;">
 <?php
  if(isset($_SESSION['lname'])){
	
 echo $_SESSION['lname']. ' <a href="logout.php?return_url='.$current_url.'">,Logout</a>';
  }else {
	  ?>
   <a href="login.php" ><strong> LOGIN </strong></a> /
    <a href="register.php"><strong>REGISTER</strong></a> 

 <?php
  }
  ?>
  </div>
</div>
<div id="container">
<div id="vert-menu">
<h2><a href="index.php">CLOTHING</a></h2>
<ul>
<?php 
$sqlc = mysql_query("SELECT * FROM clothes_for");

while($rowc = mysql_fetch_array($sqlc)){
	echo '<li><h3>'.$rowc['person'].'</h3>';
	$sqls = mysql_query("SELECT * FROM clothes_categories WHERE forCode='".$rowc['code']."'");
echo '<ul>';
while($rows = mysql_fetch_array($sqls)){
	echo '<li><a href="index.php?page=category&cat='.$rows['catCode'].'">'.$rows['name'].'</a></li>';
}
echo '<ul></li>';
}
?>
</ul>
</div>
  
  <div id="sidebar">
  <img src="images/youcart.fw.png" width="163" height="54" /><br/>
  <?php 
  if(isset($_SESSION['cart'])){
	  $sql="SELECT * FROM products WHERE id IN (";
	  foreach($_SESSION['cart'] as $id => $value) {
		  $sql.=$id.",";
	  }
	  $sql=substr($sql, 0, -1).") ORDER BY name ASC";
	  $query=mysql_query($sql);
	  echo '<ol>';
	  while($row=mysql_fetch_array($query)){
		  
		  ?>
          <li><strong><?php echo $row['name'];?></strong><br/>
          <?php echo 'Price: '.$row['price'];?><br/>
          <?php echo 'Quantity: '.$_SESSION['cart'][$row['id']]['quantity'];?>
     <?php echo '<span class="remove-itm"><a href="index.php?removep='.$row["id"].'&return_url='.$current_url.'">&times;</a></span>';?>
          </li>
          <?php
	  }
	  echo '</ol>
	  <br/>
	  <hr/> <a href="index.php?page=cart"><button>Go to your cart</button></a> or';
	  echo '<span class="empty-cart"><a href="index.php?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
	  
  } else {
	echo "<p>Your Cart is Empty. PLease add some products.</p>";  
  }
  ?>
        </div>
        <div id="main">
  
  <?php 
   
  require($_page.".php"); 
  
  ?>
  </div>
</div>
<div id="footer"></div>
</body>
</html>