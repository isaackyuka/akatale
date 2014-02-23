<?php 
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

?>
<h2>Clothing Inventory</h2>
 <?php if(isset($message)) {
echo '<span style="color:#0C0;">'.$message.'</span>';
} else {
echo '';
} ?>

<?php 
$sql = "SELECT * FROM products ORDER BY id ASC";
  $query = mysql_query($sql);
  echo '<ul id="product">';
  while($row=mysql_fetch_array($query)){
	echo '<li><a href="index.php?page=item&id='.$row['id'].'"><img src="uploads/'.$row['image'].'" width="120" height="200"><br/> <strong>'.$row['name'].'</strong><br/>'.$row['price'].'<br/><a href="index.php?page=products&action=add&id='.$row['id'].'">Add to Cart</a></a></li>';  
  }
  echo '</ul>';
  ?>