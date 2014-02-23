<?php 
$UploadDirectory    = 'uploads/'; //Upload Directory, ends with slash & make sure folder exist
if (!@file_exists($UploadDirectory)) {
    //destination folder does not exist
    die("Make sure Upload directory exist!");
}
require_once('includes/database.php');
if(isset($_POST['createSub'])) {
	
 if($_FILES['mFile']['error'])
    {
        //File upload error encountered
        die(upload_errors($_FILES['mFile']['error']));
    }
	
	$grp = $_POST['pdtgrp'];
	$name = $_POST['pdtname'];
	$type = $_POST['pdttype'];
	$pdtfor = $_POST['pdtfor'];
	$price = $_POST['pdtprice'];
	$desc = $_POST['pdtdesc'];
	$qty = $_POST['pdtqty'];
	$brand = $_POST['pdtbrand'];
	$material = $_POST['pdtmat'];
	$color = $_POST['pdtcolor'];

    $FileName           = strtolower($_FILES['mFile']['name']); //uploaded file name
    $FileTitle          = mysql_real_escape_string($_POST['pdtname']); // file title
    $ImageExt           = substr($FileName, strrpos($FileName, '.')); //file extension
    $FileType           = $_FILES['mFile']['type']; //file type
    $FileSize           = $_FILES['mFile']["size"]; //file size
    $RandNumber         = rand(0, 9999999999); //Random number to make each filename unique.
   /*  $uploaded_date      = date("Y-m-d H:i:s"); */

    switch(strtolower($FileType))
    {
        //allowed file types
        case 'image/png': //png file
        case 'image/gif': //gif file
        case 'image/jpeg': //jpeg file
        case 'application/pdf': //PDF file
        case 'application/msword': //ms word file
        case 'application/vnd.ms-excel': //ms excel file
        case 'application/x-zip-compressed': //zip file
        case 'text/plain': //text file
        case 'text/html': //html file
            break;
        default:
            die('Unsupported File!'); //output error
    }


    //File Title will be used as new File name
    $NewFileName = preg_replace(array('/s/', '/.[.]+/', '/[^w_.-]/'), array('_', '.', ''), strtolower($FileTitle));
    $NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
   //Rename and save uploded file to destination folder.
   if(move_uploaded_file($_FILES['mFile']["tmp_name"], $UploadDirectory . $NewFileName ))
   {
	
	$query = mysql_query("INSERT INTO products (groupCode, name, price, description, quantity, image, clothing_category, brand, color, material) VALUES ('$grp', '$name', '$price', '$desc', '$qty', '$NewFileName', '$type',  '$brand', '$material', '$color')") or die(mysql_error());
if($query){
	 
	echo "<script type='text/javascript'> 
window.location.href = 'create.php?msg=Your product was added Successfully.';
</script>"; 
	}
   }
  
   //function outputs upload error messages, http://www.php.net/manual/en/features.file-upload.errors.php#90522
function upload_errors($err_code) {
    switch ($err_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}
	
} 
else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Akatale</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="header"><h1>Akatale.com</h1></div>
<div id="container">
  <div id="main">
  <h2>Enter Product</h2>
  <form action="create.php" method="post" enctype="multipart/form-data" name="create">
  <?php if(isset($_GET['msg'])) {
$msg = $_GET['msg'];
echo '<span style="color:#0C0;">'.$msg.'</span>';
} else {
echo '';
} ?>
  <table><tr><td>
  <label>Products Group</label></td><td>
  <select name="pdtgrp">
  <option value="cl">Clothing</option>
  <option value="fw">Footwear</option>
  </select></td></tr><tr><td>
  <label>Name</label></td><td><input type="text" name="pdtname" /></td></tr><tr><td>
  <label>Type</label></td><td><select name="pdttype">
  <option value="jns">Jeans</option>
  <option value="pnt">Pants</option>
  <option value="tps">Tops</option>
  <option value="skt">Skirts</option>
  <option value="sht">Shirts</option>
  <option value="tsh">T-Shirts</option>
  <option value="drs">Dresses</option>
  </select></td></tr><tr><td>
  <label>Product for</label></td><td><select name="pdtfor">
  <option value="mn">Men</option>
  <option value="wmn">Women</option>
  <option value="kb">Kids - Boys</option>
  <option value="kg">Kids - Girls</option>
  </select></td></tr><tr><td>
  <label>Price</label></td><td><input type="text" name="pdtprice" /></td></tr><tr><td>
  <label>Description</label></td><td><textarea rows="4" cols="30" name="pdtdesc"></textarea></td></tr><tr><td>
  <label>Quantity</label></td><td><input type="text" name="pdtqty" /></td></tr><tr><td>
  <label>Image</label></td><td><input type="file" name="mFile" /></td></tr><tr><td>
  <label>Brand</label></td><td><input type="text" name="pdtbrand" /></td></tr><tr><td>
  <label>Material</label></td><td><select name="pdtmat">
  <option value="ctn">Cotton</option>
  <option value="nyl">Nylon</option>
  <option value="jja">Jinja</option>
  <option value="lth">Leather</option>
  <option value="bcl">Backcloth</option>
  <option value="jns">Jean</option>
  <option value="ktg">Kitenge</option>
  </select></td></tr><tr><td>
  <label>Color</label></td><td><select name="pdtcolor">
  <option value="wht">White</option>
  <option value="blk">Black</option>
  <option value="blu">Blue</option>
  <option value="grn">Green</option>
  <option value="red">Red</option>
  <option value="mrn">Maroon</option>
  <option value="ckd">Checked</option>
  </select></td></tr><tr>&nbsp;<td>
  </td><td><input type="submit" name="createSub" value="CREATE PRODUCT" /></td></tr></table>
  </form>
  </div>
  <div id="sidebar"></div>
</div>
<div id="footer"></div>
</body>
</html><?php 
}
?>