<?php
	session_start();
	include ("include/dbcon.php");
	include ("function/functions.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Shop Around</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery.jcarousel.pack.js" type="text/javascript"></script>
<script src="js/jquery-func.js" type="text/javascript"></script>
<style>
.customer_table
{
	width:700px;
	margin:auto;
}



th
{
	font-size:15px;
}

#t1{
	background-color:#337F88;
	color:white;
	font-size:14px;
	transition-duration:0.5s;

}

#t1:hover
{
	background-color:#554646;
	transition-duration:0.5s;
}

a
{
	color:white;
	text-decoration:none;
	
}
a:hover
{
	color:white;
}



</style>
</head>
<body>
<!-- Shell -->
<div class="shell">
  <!-- Header -->
  <div id="header">
    <h1 id="logo"><a href="#">shoparound</a></h1>
    <!-- Cart -->
    
    <div id="cart"> <a href="cart.php" class="cart-link">Your Shopping Cart</a>
      <div class="cl">&nbsp;
      </div>
      
      <span>Items: <strong><?php total_items(); ?></strong></span> &nbsp;&nbsp; 
      <span>Cost: <strong><?php Total_Price(); ?></strong></span> 
      </div>
    <!-- End Cart -->
    <!-- Navigation -->
    <div id="navigation">
      <ul>
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="all_products.php">All Product</a></li>
        <li><a href="#">My Account</a></li>
        <li><a href="#">Sign Up</a></li>
        <li><a href="#">Shopping Cart</a></li>
      	<li><a href="#">Contact Us</a></li>
      	
      </ul>
    </div>
    <!-- End Navigation -->
  </div>
  
  <!-- End Header -->
  <!-- Main -->
  <div id="main">
    <div class="cl">&nbsp;</div>
    <!-- Content -->
    <div id="content">
      <!-- Content Slider -->
      <div id="slider" class="box">
        <div id="slider-holder">
          <ul>
            <li><a href="#"><img src="css/images/slide1.jpg" alt="" /></a></li>
            <li><a href="#"><img src="css/images/slide1.jpg" alt="" /></a></li>
            <li><a href="#"><img src="css/images/slide1.jpg" alt="" /></a></li>
            <li><a href="#"><img src="css/images/slide1.jpg" alt="" /></a></li>
          </ul>
        </div>
        <div id="slider-nav"> <a href="#" class="active">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> </div>
      </div>
      <!-- End Content Slider -->
      <!-- Products -->
      <div class="products">
      <?php cart(); ?>
    <div class="cl">&nbsp;</div>
        <ul>
          	<form action="cart.php" method="post" enctype="multipart/form-data">
            	<table class="customer_table">
                	<tr>
                    	<th>Remove</th>
                        <th>Products Title</th>
                        <th>Images</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php
						$ip_add = getUserIP();
						$total = 0;
						$sel_price = "select * from cart where ip_add='$ip_add'";
						$run_price = mysqli_query($con,$sel_price);
						  while($record = mysqli_fetch_array($run_price))
						  {
							  $pro_id = $record['p_id'];
							  $pro_price = "select * from products where product_id='$pro_id'";
							  $run_pro_price = mysqli_query($con,$pro_price);
							  while($p_price = mysqli_fetch_array($run_pro_price))
							  {
								  $product_price = array($p_price['product_price']);
								  $product_title = $p_price['product_title'];
						      	  $product_image = $p_price['product_img1'];
								  $pro_price = $p_price['product_price'];
								  $value = array_sum($product_price);
								  $total +=$value;
							
					?>
                    
                    <tr align="center">
	 	  <td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>" /></td>
		  <td><?php echo $product_title; ?></td>
          <td><img src='admin/product_images/<?php echo $product_image; ?>' width='80px' height='80px' /></td>
          <td><input type="text" name="qty" value="1" style="width:70px; height:25px" /></td>
           	 <?php
			 if(isset($_POST['update']))
			 {
			 	$qty = $_POST['qty'];
				$insert_qty = "update cart set qty='$qty' where ip_add='$ip_add'";
				$run_qty = mysqli_query($con,$insert_qty);
				$total = $total*$qty;
			 }
			 ?>             
           <td><?php echo $pro_price; ?></td>
                    </tr>
                    <?php } } ?>
                    <tr align="center">
                    
                    	<td>Sub Total</td>
                        <td colspan="4" align="right"><?php echo $total; ?>		  
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;
                       	</td>
                    </tr>
				 <tr align="center">
            <td colspan="2">
            <input id="t1" type="submit" name="update" value="Update Cart" style="width:130px; height:40px;     		border:none" />
            </td>
            <td colspan="1">
            <input id="t1" type="submit" name="contine" value="Continue Shopping" style="width:130px; height:            40px; border:none" />
            </td>
 			<td colspan="2">
        	<button id="t1" style="width:130px; height:40px;border:none">
        	<a href="checkout.php">Check Out</a>
        	</button>
        	</td>
                    </tr>
                </table>
            </form>
           <?php 
		   	function mycart()
			{
				global $con;
				if(isset($_POST['update']))
				{
					foreach($_POST['remove']as $remove_id)
					{
						$delete_product = "delete from cart where p_id='$remove_id'";
						$run_delete = mysqli_query($con,$delete_product);
						
						if($run_delete)
						{
							echo "<script>window.open('cart.php','_self')</script>";
						}
					}
				}
			}
		   
		   echo @$upcart = mycart();
		  	if(isset($_POST['contine']))
			{
				echo "<script>window.open('index.php','_self')</script>";
			}
		   ?> 
            
          
        </ul>
        
        <div class="cl">&nbsp;</div>
      	
      </div>
      <!-- End Products -->
    </div>
    <!-- End Content -->
    <!-- Sidebar -->
    <div id="sidebar">
      <!-- Search -->
      <div class="box search">
        <h2>Search by <span></span></h2>
        <div class="box-content">
         <?php
			if(!isset($_SESSION['customer_email']))
			{
				echo "<h3 style='color:red'>Welcome Ghests!</h3><br>";
			}
			else
			{
				echo "<h3 style='color:red'>Welcome:</h3>"."<span style='color:green'>". $_SESSION[    		  
				'customer_email']. "</span>";
			}
        ?>
          <br />
          <form method="get" action="result.php"  enctype="multipart/form-data">
            <label>Search Any Product</label>
            <input type="text" class="field" name="user_query" />
            <input type="submit" class="search-submit" value="Search" name="search" />
          </form>
          
        </div>
      </div>
      <!-- End Search -->
      <!-- Categories -->
      <div class="box categories">
        <h2>Categories <span></span></h2>
        <div class="box-content">
          <ul>
          		<?php
					GetCategories();
				?>
          </ul>
        </div>
      </div>
      <!-- End Categories -->
       <div class="box categories">
        <h2>Brands <span></span></h2>
        <div class="box-content">
          <ul>
          	<?php
				GetBrands();
			?>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->
    <div class="cl">&nbsp;</div>
  </div>
  <!-- End Main -->
  <!-- Side Full -->
  <div class="side-full">
    <!-- More Products -->
    <div class="more-products">
      <div class="more-products-holder">
        <ul>
          <li><a href="#"><img src="css/images/small1.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small2.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small3.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small4.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small5.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small6.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small7.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small1.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small2.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small3.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small4.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small5.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small6.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small7.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small1.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small2.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small3.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small4.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small5.jpg" alt="" /></a></li>
          <li><a href="#"><img src="css/images/small6.jpg" alt="" /></a></li>
          <li class="last"><a href="#"><img src="css/images/small7.jpg" alt="" /></a></li>
        </ul>
      </div>
      <div class="more-nav"> <a href="#" class="prev">previous</a> <a href="#" class="next">next</a> </div>
    </div>
    <!-- End More Products -->
    <!-- Text Cols -->
    <div class="cols">
      <div class="cl">&nbsp;</div>
      <div class="col">
        <h3 class="ico ico1">Donec imperdiet</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
        <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
      </div>
      <div class="col">
        <h3 class="ico ico2">Donec imperdiet</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
        <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
      </div>
      <div class="col">
        <h3 class="ico ico3">Donec imperdiet</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
        <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
      </div>
      <div class="col col-last">
        <h3 class="ico ico4">Donec imperdiet</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet, metus ac cursus auctor, arcu felis ornare dui.</p>
        <p class="more"><a href="#" class="bul">Lorem ipsum</a></p>
      </div>
      <div class="cl">&nbsp;</div>
    </div>
    <!-- End Text Cols -->
  </div>
  <!-- End Side Full -->
  <!-- Footer -->
  <div id="footer">
    <p class="left"> <a href="#">Home</a> <span>|</span> <a href="#">Support</a> <span>|</span> <a href="#">My Account</a> <span>|</span> <a href="#">The Store</a> <span>|</span> <a href="#">Contact</a> </p>
    <p class="right"> &copy; 2010 Shop Around. Design by <a href="http://chocotemplates.com">Chocotemplates.com</a> </p>
  </div>
  <!-- End Footer -->
</div>
<!-- End Shell -->
</body>
</html>
