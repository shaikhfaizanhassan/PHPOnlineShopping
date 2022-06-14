<?php
	//Connection Database
		$con = mysqli_connect("localhost","root","","shop_aroundDB");
	
	//function for getting the ip address
	function getUserIP() 
	{
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
	}
	
	//Getting Default For Customers
	function GetDefault()
	{
		global $con;
		$c_customer = $_SESSION['customer_email'];
		$get_c = "select * from customers where customer_email='$c_customer'";
		$get_run = mysqli_query($con,$get_c);
		$row = mysqli_fetch_array($get_run);
			$customer_id = $row['customer_id'];
			if(!isset($_GET['my_orders'])){
				if(!isset($_GET['edit_account'])){
					if(!isset($_GET['change_pass'])){
						if(!isset($_GET['delete_account'])){
		
	$get_order = "select * from customer_order where customer_id ='$customer_id' AND order_status='pinding'";
			$run_order = mysqli_query($con,$get_order);
			$count_order = mysqli_num_rows($run_order);
			
			if($count_order>0)
			{
				echo "
						<br><br><br><br>
						<div style='text-align:center'>				
						<h1>Order Information</h1><br>
						<h1>You Have ($count_order) Pinding Orders</h1><br>
						<h2>Please See Your Orders Detail By Clicking This <a href='my_account.php?my_orders'>
						Link</a></h2>
						</div>
				 ";
			}	
			else
			{
				echo "		
				<br><br><br><br>
						<div style='text-align:center'>				
						<h1>Order Information</h1><br>
						<h1>You Have No Pinding Orders</h1><br>
						<h2>Please See Your Orders Detail By Clicking This <a href='my_account.php?my_orders'>Link</a></h2>
						</div>
						
					 ";
				
			}
						}
					}
				}
			}
	}
	
	//Creating Cart Insert Into Cart
	function cart()
	{
		if(isset($_GET['all_cart']))
		{
			global $con;
			$ip_add = getUserIP();
			$p_id = $_GET['all_cart'];
			$check_pro = "select * from cart where ip_add='$ip_add' AND p_id='$p_id'";
			$run_check = mysqli_query($con,$check_pro);
			if(mysqli_num_rows($run_check)>0)
			{
				echo "";
			}
			else
			{
				$q = "insert into cart (p_id,ip_add) values ('$p_id','$ip_add')";
				$run_q = mysqli_query($con,$q);
				echo "<script>window.open('index.php','_self')</script>";
			}
		}
	}
	
	//Getting Total Items
	function total_items()
	{
		if(isset($all_cart))
		{
			global $con;
			$ip_add = getUserIP();
			$get_item = "select * from cart where ip_add='$ip_add'";
			$run_item = mysqli_query($con,$get_item);
			$count_item = mysqli_num_rows($run_item);
		}
		else
		{
			global $con;
			$ip_add = getUserIP();
			$get_item = "select * from cart where ip_add='$ip_add'";
			$run_item = mysqli_query($con,$get_item);
			$count_item = mysqli_num_rows($run_item);
		}
		echo $count_item;
	}
	
	//Creating Total Price
	function Total_Price()
	{
		global $con;
		$ip_add = getUserIP();
		$total =0;
		$sel_price = "select * from cart where ip_add='$ip_add'";
		$run_price = mysqli_query($con,$sel_price);
			while($record = mysqli_fetch_array($run_price))
			{
		$pro_id  = $record['p_id'];
		$pro_price = "select * from products where product_id='$pro_id'";
		$run_pro = mysqli_query($con,$pro_price);
			while($p_price = mysqli_fetch_array($run_pro))
			{
				$product_price = array($p_price['product_price']);
				$value = array_sum($product_price);
				$total +=$value;
			}	
			}
			echo $total;
	}
	
	//Getting Categories
		function GetCategories()
		{
			global $con;
			$get_cat = "select * from categories";
			$run_cat = mysqli_query($con,$get_cat);
			
			while($row = mysqli_fetch_array($run_cat))
			{
				$catid = $row['cat_id'];
				$cattitle = $row['cat_title'];
				
				echo "<li><a href='index.php?cat=$catid'>$cattitle</a></li>";
			}
		}
	//Getting Brands
		function GetBrands()
		{
			global $con;
			$get_brand = "select * from brands";
			$run_brand = mysqli_query($con,$get_brand);
			
			while($row = mysqli_fetch_array($run_brand))
			{
				$brandid = $row[0];
				$brandtitle = $row[1];
				
				echo "<li><a href='index.php?brand=$brandid'>$brandtitle</a></li>";
			}
		}	
	//Getting Products
		function GetProduct()
		{
			if(!isset($_GET['cat']))
			{
				if(!isset($_GET['brand']))
				{
					global $con;
					$get_product = "select * from products order by rand() LIMIT 0,4";
					$run_product = mysqli_query($con,$get_product);
					
					while($row = mysqli_fetch_array($run_product))
					{
							$pro_id = $row[0];
							$pro_title = $row[4];
							$pro_cat = $row[1];
							$pro_brand = $row[2];
							$pro_desc = $row[9];
							$pro_price = $row[8];
							$pro_image = $row[5];
						
							echo "
		<li style='width:300px; margin:10px; border:1px solid; padding:5px; margin-left:30px;'> <a 
		href='detail.php?pro_detail=$pro_id'><img src='admin/product_images/$pro_image' alt='' 
		style='width:300px; height:300px;' /></a>
        <div class='product-info'>
			 <h3>$pro_title</h3>
              <div class='product-desc' style='text-align:center'>
                <h4>$pro_desc</h4>
                <p>_____________</p>
                <strong class='price'>$ $pro_price</strong> 
				<a href='index.php?all_cart=$pro_id'><input type='submit' name='shop' value='Add To 
				Cart' style='width:150px; height:25px; background-color:'></a>
				</div>
            </div>
          </li>
          				 		";					
					}
				}
			}
		}	
	//Getting Product Detail Start
	function Product_Detail()
		{
			if(isset($_GET['pro_detail']))
			{
				global $con;
					$product_id = $_GET['pro_detail'];
					$get_product = "select * from products where product_id='$product_id'";
					$run_product = mysqli_query($con,$get_product);
					while($row = mysqli_fetch_array($run_product))
					{
							$pro_id = $row[0];
							$pro_title = $row[4];
							$pro_cat = $row[1];
							$pro_brand = $row[2];
							$pro_desc = $row[9];
							$pro_price = $row[8];
							$pro_image1 = $row[5];
							$pro_image2 = $row[6];
							$pro_image3 = $row[7];
							echo "
		<li style='width:180px; margin:10px; border:1px solid; height:px; padding:5px; 
		margin-left:30px;'> <a 
		href='detail.php?pro_detail=$pro_id'><img src='admin/product_images/$pro_image1' alt='' 
		style='width:180px; height:180px;' /></a>
            <div class='product-info'>
			 <h3>$pro_title</h3>
              <div class='product-desc' style='text-align:center'>
                <h4>$pro_desc</h4>
                <p>_____________</p>
                <strong class='price'>$ $pro_price</strong> 
				<a href='index.php?all_cart=$pro_id'>
				<input type='submit' name='shop' value='Add To Cart' style='width:150px'></a>
				</div>
            </div>
        </li>
		  <li style='width:180px; margin:10px; border:1px solid; height:px; padding:5px; 
		  margin-left:30px;'>
			<img src='admin/product_images/$pro_image2' alt='' 
			style='width:180px; height:180px;' />
			<div class='product-info'>
			 <h3>$pro_title</h3>
            </div>
		  </li>
		<li style='width:180px; margin:10px; border:1px solid; padding:5px; margin-left:30px;'>
			<img src='admin/product_images/$pro_image3' alt='' 
			style='width:180px; height:180px;' />
			<div class='product-info'>
			 <h3>$pro_title</h3>
            </div>
		</li>
		 				 ";					
					}
			}
		}
	//Getting All Product From Database
	function Get_All_Product()
	{
		global $con;
		$get_all_pro = "select * from products";
		$run_all_pro = mysqli_query($con,$get_all_pro);
		while($row_all_pro = mysqli_fetch_array($run_all_pro))
		{
							$pro_id 	= $row_all_pro[0];
							$pro_title 	= $row_all_pro[4];
							$pro_cat 	= $row_all_pro[1];
							$pro_brand 	= $row_all_pro[2];
							$pro_desc 	= $row_all_pro[9];
							$pro_price 	= $row_all_pro[8];
							$pro_image 	= $row_all_pro[5];
			echo "	
		<li style='width:300px; margin:10px; border:1px solid; padding:5px; 					 			 		margin-left:30px;'> <a 
		href='detail.php?pro_detail=$pro_id'><img src='admin/product_images/$pro_image' alt='' 
		style='width:300px; height:300px;' /></a>
        <div class='product-info'>
			 <h3>$pro_title</h3>
              <div class='product-desc' style='text-align:center'>
                <h4>$pro_desc</h4>
                <p>_____________</p>
                <strong class='price'>$ $pro_price</strong> 
		<a href='index.php?all_cart=$pro_id'><input type='submit' name='shop' value='Add To Cart' 	        style='width:150px; height:25px; background-color:'></a>
				</div>
            </div>
          </li>
				 ";
		}
	}	
	//Gettting Categories Product Click On Categories 
	function Get_categories_Product()
	{
		global $con;
		if(isset($_GET['cat']))
		{
			$cat_id = $_GET['cat'];
			$get_cat_pro = "select * from products where cat_id='$cat_id'";
			$run_cat_pro = mysqli_query($con,$get_cat_pro);
			$count_cat_pro = mysqli_num_rows($run_cat_pro);
			if($count_cat_pro==0)
			{
				echo "<h1 style='text-align:center; margin-top:30px;'>No Record Found In This Brands</h1>";
			}
			while($row_get_cat_row = mysqli_fetch_array($run_cat_pro))
			{
					 		$pro_id 	= $row_get_cat_row[0];
							$pro_title 	= $row_get_cat_row[4];
							$pro_cat 	= $row_get_cat_row[1];
							$pro_brand 	= $row_get_cat_row[2];
							$pro_desc 	= $row_get_cat_row[9];
							$pro_price 	= $row_get_cat_row[8];
							$pro_image 	= $row_get_cat_row[5];
				echo "
		<li style='width:180px; margin:10px; border:1px solid; height:px; padding:5px; 
		margin-left:30px;'> <a 
		href='detail.php?pro_detail=$pro_id'><img src='admin/product_images/$pro_image' alt='' 
		style='width:180px; height:180px;' /></a>
            <div class='product-info'>
			 <h3>$pro_title</h3>
              <div class='product-desc' style='text-align:center'>
                <h4>$pro_desc</h4>
                <p>_____________</p>
                <strong class='price'>$ $pro_price</strong> 
				<a href='index.php?all_cart=$pro_id'>
				<input type='submit' name='shop' value='Add To Cart' style='width:150px'></a>
				</div>
            </div>
        </li>
					 ";
			}
		}
	}	
	//Getting Brands Product Click On Brands
	function Get_Brands_Product()
	{
		global $con;
		if(isset($_GET['brand']))
		{
			$brand_id = $_GET['brand'];
			$gat_brand_pro = "select * from products where brand_id = '$brand_id'";
			$run_brand_pro = mysqli_query($con,$gat_brand_pro);
			$count_brand_pro = mysqli_num_rows($run_brand_pro);
			if($count_brand_pro==0)
			{
				echo "<h1 style='text-align:center; margin-top:30px;'>No Record Found In This Brands</h1>";
			}
			while($row_brand_pro = mysqli_fetch_array($run_brand_pro))
			{
							$pro_id 	= $row_brand_pro[0];
							$pro_title 	= $row_brand_pro[4];
							$pro_cat 	= $row_brand_pro[1];
							$pro_brand 	= $row_brand_pro[2];
							$pro_desc 	= $row_brand_pro[9];
							$pro_price 	= $row_brand_pro[8];
							$pro_image 	= $row_brand_pro[5];
			echo "
		<li style='width:180px; margin:10px; border:1px solid; height:px; padding:5px; 
		margin-left:30px;'> <a 
		href='detail.php?pro_detail=$pro_id'><img src='admin/product_images/$pro_image' alt='' 
		style='width:180px; height:180px;' /></a>
            <div class='product-info'>
			 <h3>$pro_title</h3>
              <div class='product-desc' style='text-align:center'>
                <h4>$pro_desc</h4>
                <p>_____________</p>
                <strong class='price'>$ $pro_price</strong> 
				<a href='index.php?all_cart=$pro_id'>
				<input type='submit' name='shop' value='Add To Cart' style='width:150px'></a>
				</div>
            </div>
        </li>
					 ";
							
			}
		}
	}
?>