<?php 
if(isset($_GET['cat'])){
	$clcat=$_GET['cat'];
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

?>
<h2>Clothing Inventory</h2>
 <?php if(isset($message)) {
echo '<span style="color:#0C0;">'.$message.'</span>';
} else {
echo '';
} ?>

<?php 

$sql = "SELECT * FROM products where groupCode='cl' AND clothing_category='{$clcat}' ORDER BY id ASC";
  $query = mysql_query($sql);
  if(mysql_num_rows($query) > 0){
  echo '<ul id="product">';
  while($row=mysql_fetch_array($query)){
	echo '<li><a href="index.php?page=item&id='.$row['id'].'"><img src="uploads/'.$row['image'].'" width="100" height="200"><br/> <strong>'.$row['name'].'</strong><br/>'.$row['price'].'<br/></a></li>';  
  }
  echo '</ul>';
  } else {
	echo 'We donot have that piece in our stores at the moment.';  
  }
  ?>