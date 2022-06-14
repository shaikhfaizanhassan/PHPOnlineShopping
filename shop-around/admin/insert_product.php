<?php
include ("includes/dbcon.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Untitled Document</title>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
  
<style>
	fieldset
	{
		background-color:#F8F8F8;
		width:700px;
		height:auto;
		margin:auto;
	}
	
	legend
	{
		font-size:25px;
		color:green;
		font-weight:bolder;
	}
	
	input
	{
		width:300px;
		height:30px;
		font-size:18px;
	}
	
	select
	{
		width:300px;
		height:30px;
		font-size:18px;
	}
	
	th
	{
		text-align:inherit;
	}	
	
	
	textarea
	{
		width:300px;
		height:150px;
	}
	
	
</style>
</head>

<body>
<div class="container-fluid">
<fieldset>
    	<legend>Product Insert Area By Admin</legend>
        	<table>
            	<form action="insert_product.php" method="post" enctype="multipart/form-data">
                	
                    <tr>
                    	<th>Product Title</th>
                        <td><input type="text" name="product_title" class="form-control"></td>
                    </tr>
                    <tr>
                    	<th>Product Categores</th>
                    	<td><select name="product_cart" class="form-control">
                        	<option hidden="true">Select Categories</option>
                            	<?php
								$get_cats = "select * from categories";
								$run = mysqli_query($con,$get_cats);
									while($row = mysqli_fetch_array($run))
									{
										$cats_id 	= 	$row['cat_id'];
										$cats_title = 	$row['cat_title'];
									
									echo "<option value='$cats_id'>$cats_title</option>";   
                       				}
                                    ?>
                       
                        </select>    
                    	</td>
                    </tr>
                    <tr>
                    	<th>Product Brand</th>
                        <td><select name="product_brand" class="form-control">
                        	<option hidden="true">Select Brand</option>
                            	<?php
					$get_brand = "select * from brands";
					$run = mysqli_query($con,$get_brand);
						while($row = mysqli_fetch_array($run))
						{
							$brand_id = $row[0];
							$brand_title = $row[1];
					echo "<option value='$brand_id'>$brand_title</option>";
                } 
				?>
					   		</select>    
                    	</td>
                        
                    </tr>
                    <tr>
                    	<th>Product Image 1</th>
                        <td><input type="file" name="product_img1" class="form-control"></td>
                    </tr>
                    <tr>
                    	<th>Product Image 2</th>
                        <td><input type="file" name="product_img2" class="form-control"></td>
                    </tr>
                    <tr>
                    	<th>Product Image 3</th>
                        <td><input type="file" name="product_img3" class="form-control"></td>
                    </tr>
                    <tr>
                    	<th>Product Price</th>
                        <td><input type="text" name="product_Price" class="form-control"></td>
                    </tr>
                    <tr>
                    	<th>Product Description</th>
                        <td><textarea name="product_desc"></textarea></td>
                    </tr>
                    <tr>
                    	<th>Product Keyword</th>
                        <td><input type="text" name="product_keywords" class="form-control"></td>
                    </tr>
                    
                    <tr>
                    	<th></th>
                        <td><input type="submit" name="btn" value="Insert Product"></td>
                    </tr>
                </form>
            </table>
    </fieldset>
</div>
</body>
</html>

<?php 
		if(isset($_POST['btn']))
		{
			$p_title = $_POST['product_title'];
			$p_cart = $_POST['product_cart'];
			$p_brand = $_POST['product_brand'];
			$p_price = $_POST['product_Price'];
			$p_desc = $_POST['product_desc'];
			$p_status = 'On';
			$p_keywor = $_POST['product_keywords'];
			
			
			//images Name
			$p_img1 = $_FILES['product_img1']['name'];
			$p_img2 = $_FILES['product_img2']['name'];
			$p_img3 = $_FILES['product_img3']['name'];
			
			
			//Images Tmp 
			$tmp_img1 = $_FILES['product_img1']['tmp_name'];
			$tmp_img2 = $_FILES['product_img2']['tmp_name'];
			$tmp_img3 = $_FILES['product_img3']['tmp_name'];
			
			//uplording images to its folder
			move_uploaded_file($tmp_img1,"product_images/$p_img1");
			move_uploaded_file($tmp_img2,"product_images/$p_img2");
			move_uploaded_file($tmp_img3,"product_images/$p_img3");
			
			//Query Insertion
			
			$insert_product = "insert into products (cat_id,brand_id,date,product_title,product_img1,product_img2,product_img3,product_price,product_desc,product_keyword,status) values ('$p_cart','$p_brand',NOW(),'$p_title','$p_img1','$p_img2','$p_img3','$p_price','$p_desc','$p_keywor','$p_status')";	
			
			$run = mysqli_query($con,$insert_product);
			
			if($run>0)
			{
				echo '<script>alert("Product Insert Successfully Done !")</script>';
			}
			
			else
			{
				echo '<script>alert("Product Insert Failed !")</script>';
			}
			
		}
	?>