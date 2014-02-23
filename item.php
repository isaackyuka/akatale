
<?php 

if(isset($_GET['id'])){
	$id = intval($_GET['id']);
} else {
header("location:index.php");	
}
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'])){
		$_SESSION['cart'][$id]['quantity']++;
	} else {
		$sqls="SELECT * FROM products WHERE id={$id}";
		$querys=mysql_query($sqls);
		if(mysql_num_rows($querys) !=0){
			$rows=mysql_fetch_array($querys);
			
			$_SESSION['cart'][$rows['id']]=array(
				"quantity" => 1,
				"price" => $rows['price']
			);
		}else{
			$message="This product is not available";
		}
	}
} else {
	
}
echo '<img src="uploads/'.get_product_image($id).'" align="left">';
echo '<strong>'.get_product_name($id).'</strong><br />'.get_product_desc($id).'<br/>ITEM PRICE:'. get_price($id);
echo '<br/><a href="index.php?page=item&action=add&id='.$id.'"><img src="images/addtocart.fw.png" width="100" height="50" alt="Add to Cart"></a>';

  ?>