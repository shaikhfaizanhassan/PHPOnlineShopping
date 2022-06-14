<?php
	session_start();
	include ("../include/dbcon.php");
	include ("../function/functions.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Shop Around</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
<script src="../js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="../js/jquery.jcarousel.pack.js" type="text/javascript"></script>
<script src="../js/jquery-func.js" type="text/javascript"></script>
<style>
	table
	{
		width:400ppx;
		margin:auto;
		height:220px;
	}
	
	input
	{
		width:200px;
		height:25px;
		font-size:15px;
	}
	select
	{
		width:200px;
		height:25px;
		font-size:15px;
	}
	
	td
	{
		font-size:15px;
		font-weight:bolder;
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
    
    <div id="cart"> <a href="../cart.php" class="cart-link">Your Shopping Cart</a>
      <div class="cl">&nbsp;
      </div>
      
      <span>Items: <strong><?php total_items(); ?></strong></span> &nbsp;&nbsp; 
      <span>Cost: <strong><?php Total_Price(); ?></strong></span> </div>
    <!-- End Cart -->
    <!-- Navigation -->
    <div id="navigation">
      <ul>
        <li><a href="../index.php" class="active">Home</a></li>
        <li><a href="../all_products.php">All Product</a></li>
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
      <!-- End Content Slider -->
      <!-- Products -->
      <div class="products">
      <?php cart(); ?>
      <div class="cl">&nbsp;</div>
        <ul>
		<br />     
     	<h1 style="text-align:center; text-decoration:underline">Confirm Payment Mode</h1>
        <br /><br />
		<?php
			//Getting Confirm Payment	
			include ('include/dbcon.php');
	
			if(isset($_GET['order_id']))
			{
			$order_id = $_GET['order_id'];
			}
		?>
        <?php
		@$get_values = "select * from customer_order where order_id='$order_id'";
		$run_values = mysqli_query($con,$get_values);
		
		while($row = mysqli_fetch_array($run_values))
		{
			$invoiceno = $row[3];
			$amount = $row[2];
			$dates = $row[5];
	?>
    <form action="confirm.php?update_id=<?php echo $order_id; ?>" method="post">
    	<table>
        	<tr>
            	<td>Invoice No</td>
                <td><input type="text" name="invoice_no" readonly="readonly" value="<?php echo 
				$invoiceno; ?>"></td>
            </tr>
            <tr>
            	<td>Amount Sent</td>
                <td><input type="text" name="amountsent" readonly="readonly" value="<?php echo $amount
				; ?>"></td>
            </tr>
            <tr>
            	<td>Select Payment Mode</td>
                <td><select name="payment_method">
                	<option hidden="true">Select Payment Mode</option>
                    <option>Bank Transfers</option>
                    <option>Paypal Payment</option>
                    <option>UBL OMMI / Easy Paisa</option>
                </select>
                </td>
            </tr>
            
            <tr>
            	<td>Transaction Ref ID</td>
                <td><input type="text" name="TI" value=""></td>
            </tr>
            
            <tr>
            	<td>Esay Paisa OMMI Code</td>
                <td><input type="text" name="ommi" value=""></td>
            </tr>
            <tr>
            	<td>Payment Date</td>
                <td><input type="text" name="payment_date" readonly="readonly" value="<?php echo 
				$dates; ?>"></td>
            </tr>
            
            <tr>
            	<td></td>
                <td><input type="submit" name="btn_confirm" value="Confirm Payment"></td>
            </tr>
        </table>
    </form>
    
    <?php } ?>
 	<?php
		//Insert into Payment table
		if(isset($_POST['btn_confirm']))
		{
			$update_id 		= $_GET['update_id'];
			$invoice 		= $_POST['invoice_no'];	
			$amount 		= $_POST['amountsent'];
			$payment_method = $_POST['payment_method'];
			$ref_no 		= $_POST['TI'];
			$code 			= $_POST['ommi'];
			$date 			= $_POST['payment_date'];
			
			$insert_payment = "insert into payments 
			(invoice_no,amount,payment_mode,ref_no,code,payment_date)
			values 
			('$invoice','$amount','$payment_method','$ref_no','$code','$date')
			";
			
			$run_payment = mysqli_query($con,$insert_payment);
			
			$update_order = "update customer_order set order_status='Complete' where order_id='$update_id'";
			
			$run_update = mysqli_query($con,$update_order);
			
			if($run_payment>0)
			{
			echo "<script>alert('Payment Receive Your Order Will Be Completed within 24 Horus ')</script>";
			}
		}
		
	?>
    
    
    
    
    
    
    		
            <?php
			//Getting Include Pages On Variable Click 
				if(isset($_GET['my_orders']))
				{
					include ('my_orders.php');
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
        <h2>My Profile <span></span></h2>
        <div class="box-content">
			<?php
				if(!isset($_SESSION['customer_email']))
				{
					echo "<h3>Welcome</h3>";	
				}			
				else
				{
					echo "<h3 style='color:red'>Welcome : </h3>" . $_SESSION['customer_email'];	
				
				}
			?>

		  <br />
          
        </div>
        
		<?php
			if(!isset($_SESSION['customer_email']))
			{
				echo "<h3>Please Login & See Your Account</h3>";
			}
			
			else
			{
				$customer_session = $_SESSION['customer_email'];
				$get_customer_pic = "select * from customers where customer_email='$customer_session'";
				$run_customer_pic = mysqli_query($con,$get_customer_pic);
				$row_customer = mysqli_fetch_array($run_customer_pic);
				
				$customer_picture = $row_customer['customer_image'];
				$customer_name = $row_customer['customer_name'];
			echo "<h2>$customer_name</h2>";
			echo "<img src='images/$customer_picture' width='222' height='230' />";
        
        
			}
		?>
        <h2><a href="#" style="color:white;">Change Picture</a></h2>
        
      </div>
      <!-- End Search -->
      <!-- Categories -->
      <div class="box categories">
        <h2>Manage Account <span></span></h2>
        <div class="box-content">
          <ul>
          		<li><a href="my_account.php?my_orders">My Orders</a></li>
                <li><a href="my_account.php?edit_account">Edit Accounts</a></li>
                <li><a href="my_account.php?change_pass">Change Password</a></li>
                <li><a href="my_account.php?delete_account">Delete Accounts</a></li>
                <li><a href="../logout.php">Logout</a></li>
                
 		 </ul>
         
        </div>
      </div>
      <!-- End Categories -->
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
          <li><a href="#"><img src="../css/images/small1.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small2.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small3.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small4.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small5.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small6.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small7.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small1.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small2.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small3.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small4.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small5.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small6.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small7.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small1.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small2.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small3.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small4.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small5.jpg" alt="" /></a></li>
          <li><a href="#"><img src="../css/images/small6.jpg" alt="" /></a></li>
          <li class="last"><a href="#"><img src="../css/images/small7.jpg" alt="" /></a></li>
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
