
<style>
	table
	{
		margin:auto;
		width:720px;
		margin-top:50px;
	}
	
	tr td
	{
		text-align:center;
		border:1px solid;
	}
	
	h1
	{
		text-align:center;
	}
</style>

<?php
	include ('include/dbcon.php');
	
	//Getting Customer ID
	$c_customer = $_SESSION['customer_email'];
	$get_c = "select * from customers where customer_email='$c_customer'";
	$run_c = mysqli_query($con,$get_c);
	$row_c = mysqli_fetch_array($run_c);
	
	$customer_id = $row_c['customer_id'];
	

?>

<table>
	<h1>Manage Account</h1>
	<tr style="font-size:15px; font-weight:bolder">
    	<td>Order No</td>
        <td>Due Amount</td>
        <td>Invoice No</td>
        <td>Totals Products</td>
        <td>Order Date</td>
        <td>Paid/UnPaid</td>
        <td>Status</td>
    </tr>
    
    <?php
		$get_order = "select * from customer_order where customer_id='$customer_id'";
		$run_order = mysqli_query($con,$get_order);
		
		$i=0;
		
		while($row_orders = mysqli_fetch_array($run_order))
		{
			$order_id = $row_orders[0];
			$due_amount = $row_orders[2];
			$inviceno = $row_orders[3];
			$totalpro = $row_orders[4];
			$orderdate = $row_orders[5];
			$status = $row_orders[6];
			$i++;
			
			if($status=='pinding')
			{
				$status='Unpaid';
			}
			else
			{
				$status ='Paid';
			}
			
			
			
			echo "
				<tr align='center' style='font-size:15px'>
					<td>$i</td>
					<td>$due_amount</td>
					<td>$inviceno</td>
					<td>$totalpro</td>
					<td>$orderdate</td>
					<td>$status</td>
					<td><a href='confirm.php?order_id=$order_id' style='color:black'>Confirm Paid</a></td>
				</tr>
			
				";
			
			
		}
		
	?>
    
    <?php
		$get_order = "select * from customer_order where customer_id='$customer_id'";
		$run_order = mysqli_query($con,$get_order);
		
		$i=0;
		
		while($row_orders = mysqli_fetch_array($run_order))
		{
			$order_id = $row_orders[0];
			$due_amount = $row_orders[2];
			$inviceno = $row_orders[3];
			$totalpro = $row_orders[4];
			$orderdate = $row_orders[5];
			$status = $row_orders[6];
			$i++;
			
			if($status=='pinding')
			{
				$status='Unpaid';
			}
			else
			{
				$status ='Paid';
			}
		}
	?>
    
    
</table>
<br>
<p style="font-size:18px; float:right"><a href="my_account.php">Back To My Account</a></p>