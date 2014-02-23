<?php
function get_product_image($pid){
		$result=mysql_query("select image from products where id=$pid");
		$row=mysql_fetch_array($result);
		
		return $row['image'];
}
	function get_product_name($pid){
		$result=mysql_query("select name from products where id=$pid");
		$row=mysql_fetch_array($result);
		
		return $row['name'];
	}
	
	function get_product_desc($pid){
		$result=mysql_query("select description from products where id=$pid");
		$row=mysql_fetch_array($result);
		return $row['description'];
	}
	function get_price($pid){
		$result=mysql_query("select price from products where id=$pid");
		$row=mysql_fetch_array($result);
		return $row['price'];
	}
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['id']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	function get_order_total(){
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['id'];
			$q=$_SESSION['cart'][$i]['quantity'];
			$price=get_price($pid);
			$sum+=$price*$q;
		}
		return $sum;
	}
	function addtocart($pid,$q){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['id']=$pid;
			$_SESSION['cart'][$max]['quantity']=$q;
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['id']=$pid;
			$_SESSION['cart'][0]['quantity']=$q;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['id']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}
	
?>

<?php //empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
	$return_url = base64_decode($_GET["return_url"]); //return url
	session_destroy();
	header('Location:'.$return_url);
}
//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["cart"]))
{
	$id 	= $_GET["removep"]; //get the product code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["cart"] as $cart_itm) //loop through session array var
	{
		if($cart_itm["code"]!=$product_code){ //item does,t exist in the list
			$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
		}
		
		//create a new product list for cart
		$_SESSION["products"] = $product;
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}


?>