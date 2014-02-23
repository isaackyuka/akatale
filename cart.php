<a href="index.php"><button>CONTINUE SHOPPING</button></a><br/>
<h2>CURRENTLY IN YOUR SHOPPING CART</h2>
<form method="post" action="PesapalAPI-Files/pesapal-iframe.php">
<?php 
  if(isset($_SESSION['cart'])){
	  $sql="SELECT * FROM products WHERE id IN (";
	  foreach($_SESSION['cart'] as $id => $value) {
		  $sql.=$id.",";
	  }
	  $sql=substr($sql, 0, -1).") ORDER BY name ASC";
	  $query=mysql_query($sql);
	  $total=0;
	  echo '<table><tr><th>YOUR ITEMS</th><th>QUANTITY</th><th>PRICE</th><th>ITEM PRICE</th></tr>';
	  while($row=mysql_fetch_array($query)){
		  $subtotal=$_SESSION['cart'][$row['id']]['quantity']*$row['price'];
		  $total+=$subtotal;
		  ?>
          <tr><td><img src="uploads/<?php echo $row['image']; ?>" align="left" width="50" height="70"><strong><?php echo $row['name'];?></strong></td>
         <td> <input type="text" name="quantity" size="2" value="<?php echo $_SESSION['cart'][$row['id']]['quantity'] ?>" /></td><td>
		  <?php echo $currency.''. $row['price'];?></td>
          <td>
          <?php echo $currency.''.$_SESSION['cart'][$row['id']]['quantity']*$row['price']; ?>
          </td>
          </tr>
          <?php
	  }
	  echo '</table>
	  <br/>Total Price:'.$currency.''.$total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	  echo '<input type="hidden" name="amount" value="'.$total.'" />';
		
		echo '<input type="submit" name="checkout" value="PROCEED TO CHECKOUT" />
	  <br/>';
	  
  } else {
	echo "<p>Your Cart is Empty. PLease add some products.</p>";  
  }
  ?>
</form>
<style>
#main{
	
}
</style>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#sidebar').addClass("vanish");
});

</script>