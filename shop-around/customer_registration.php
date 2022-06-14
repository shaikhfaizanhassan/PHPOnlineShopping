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
	table
	{
		width:400px;
		margin:auto;
		height:100px;
		margin-top:50px;
		
		
	}
	
	input
	{
		width:220px;
		height:25px;
		font-size:15px;
	}
	
	th
	{
		font-size:20px;
		width:300px;
		
		
	}
	
	.reg_heading
	{
		margin-left:160px;
		margin-top:-40px;
		position:absolute;
		color:#B73C3E;
	}
	
	td
	{
		font-size:15px;
	}
	
	a{
		text-decoration:none;
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
      <span>Cost: <strong><?php Total_Price(); ?></strong></span> </div>
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
          <form action="customer_registration.php" method="post" enctype="multipart/form-data">
          		<table>
                		<h1 class="reg_heading">Customer Registration Form</h1>
                    <tr>
                    	<td>Full Name</td>
                        <td><input type="text" name="c_name" /></td>
                    </tr>
                    <tr>
                    	<td>Email Address</td>
                        <td><input type="text" name="c_email" /></td>
                    </tr>
                    <tr>
                    	<td>Password</td>
                        <td><input type="text" name="c_pass" /></td>
                    </tr>
                    <tr>
                    	<td>Country</td>
                        <td><input type="text" name="c_country" /></td>
                    </tr>
                    <tr>
                    	<td>City</td>
                        <td><input type="text" name="c_city" /></td>
                    </tr>
                    <tr>
                    	<td>Contact Number</td>
                        <td><input type="text" name="c_contact" /></td>
                    </tr>
                    <tr>
                    	<td>Address</td>
                        <td><input type="text" name="c_add" /></td>
                    </tr>
                    <tr>
                    	<td>Customer Image</td>
                        <td><input type="file" name="c_image" /></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><input type="submit" name="btn_reg" value="Registration" /></td>
                    </tr>
                </table>
          </form>
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
            <h3>Welcome Guests !<br />
             <span style="color:red">Contact Customer Support</span></h3>
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


<?php
	if(isset($_POST['btn_reg']))
	{
		$cname = $_POST['c_name'];
		$cemail = $_POST['c_email'];
		$cpass = $_POST['c_pass'];
		$ccountry = $_POST['c_country'];
		$cadd = $_POST['c_add'];
		$ccity = $_POST['c_city'];
		$ccontact = $_POST['c_conntact'];
		$c_image_name = $_FILES['c_image']['name'];
		$c_image_size = $_FILES['c_image']['size'];
		$c_image_tmp = $_FILES['c_image']['tmp_name'];
		$c_ip = getUserIP();
		
		move_uploaded_file($c_image_tmp,"customers/images/$c_image_name");
		
		$insert_customer = "insert into customers 
		(customer_name,customer_email,customer_pass,customer_country,customer_city,customer_contact,
		customer_address,customer_image,customer_ip)
		values 
		('$cname','$cemail','$cpass','$ccountry','$ccity','$ccontact','$cadd','$c_image_name','$c_ip')
		";
		
		$run_customer = mysqli_query($con,$insert_customer);
		
		$sel_query = "select * from cart where ip_add='$c_ip'";
		$run_cart = mysqli_query($con,$sel_query);
		
		$check_cart = mysqli_num_rows($run_cart);
		
		if($check_cart>0)
		{
			$_SESSION['customer_email']=$cemail;
			echo "<script>alert('Account Created Successfully')</script>";
			echo "<script>window.open('checkout.php','_self')</script>";
		}
		
		else
		{
			$_SESSION['customer_email']=$cemail;
			echo "<script>alert('Account Created Successfully')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		
		}
		
	}
?>