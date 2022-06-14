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
	
	.login_heading
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
<?php 
	@session_start();
	include ('include/dbcon.php');
?>
<form action="checkout.php" method="post" enctype="multipart/form-data">
          		<table>
                		<h1 class="login_heading">Customer Login Form</h1>         
                    <tr>
                    	<td>Email Address</td>
                        <td><input type="text" name="c_email" /></td>
                    </tr>
                    <tr>
                    	<td>Password</td>
                        <td><input type="text" name="c_pass" /></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><a href="#">Forgot Password</a></td>
                    </tr>
                    
                    <tr>
                    	<td></td>
                        <td><input type="submit" name="btn_login" value="Login" /></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td><a href="customer_registration.php">New Registration</a></td>
                    </tr>                
                </table>
          </form>
     
     <?php
	 	if(isset($_POST['btn_login']))
		{
			$customer_email = $_POST['c_email'];
			$customer_pass = $_POST['c_pass'];
			$sel_customer = "select * from customers where customer_email='$customer_email' AND
            customer_pass='$customer_pass'";
				 $run_customer = mysqli_query($con,$sel_customer);
				 $check_customer = mysqli_num_rows($run_customer);
				 $get_ip = getUserIP();
				 $sel_cart = "select * from cart where ip_add='$get_ip'";
				 $run_cart = mysqli_query($con,$sel_cart);
				 $check_cart = mysqli_num_rows($run_cart);
				 if($check_customer==0)
				 {
					 echo "<script>alert('Email Password Wrong')</script>";
				 	 exit();
				 }
				 if($check_customer==1 AND $check_cart==0)
				 {
					 $_SESSION['customer_email']=$customer_email;
					 echo "<script>window.open('customers/my_account.php','_self')</script>";
				 }
				 else
				 {
					 $_SESSION['customer_email']=$customer_email;
					 echo "<script>alert('Login Successfully Done')</script>";
				 	 include ('payment_options.php');
				 }
		}
	 ?>     
          
