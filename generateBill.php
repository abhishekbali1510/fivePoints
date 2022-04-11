<?php
	require 'conn.php';
	require 'mail.php';
	session_start();
	if($_SESSION['login']==true)
	{
		$sql = "SELECT * FROM customerDetails WHERE customerMobile='".$_SESSION["currentCustomer"]."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
		
		if(!empty($_POST["save"])) {
			
			$itemCount = count($_POST["item_name"]);
			
			for($i=0;$i<$itemCount;$i++) {
				if($i==0)
				{
					$allItems=$_POST["item_name"][$i];
				}
				else
				{
					$allItems=$allItems.",".$_POST["item_name"][$i];
					
				}
				$totalPrice=$totalPrice + $_POST["item_price"][$i];
			}
			if($row["membershipAmount"]=="5000")
			{
				$discount=0.2*$totalPrice;
				$discperc=20;
			}
			elseif($row["membershipAmount"]=="10000")
			{
				$discount=0.3*$totalPrice;
				$discperc=30;
			}
			elseif($row["membershipAmount"]=="30000")
			{
				$discount=0.4*$totalPrice;
				$discperc=40;
			}
			$paidAmount=$totalPrice-$discount;

			if($paidAmount>$row["moneyLeft"])
			{
				$_SESSION['error3']="not sufficient balance";
			}
			else
			{
				$_SESSION['error3']="";
				$sql="INSERT INTO `customerHistory` (`customerMobile`, `items`, `totalPrice`, `discount`, `paidAmount`) VALUES ('".$row["customerMobile"]."', '".$allItems."','".$totalPrice."' , '".$discount."', '".$paidAmount."');";
				$result = $conn->query($sql);

				//money deduction
				$moneyUpdate=$row["moneyLeft"]-$paidAmount;
				$sql="UPDATE `customerDetails` SET `moneyLeft` = '".$moneyUpdate."' WHERE `customerDetails`.`customerMobile` = '".$_SESSION["currentCustomer"]."'";
				$result = $conn->query($sql);

				$sql = "SELECT * FROM customerDetails WHERE customerMobile='".$_SESSION["currentCustomer"]."'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				
				//sending mail
				$html='<html>
				<head>
					<title>Five Points</title>
					<style>
			
						table {
						  font-family: arial, sans-serif;
						  border-collapse: collapse;
						  width: 100%;
						}
						td, th {
						  border: 1px solid #dddddd;
						  text-align: left;
						  padding: 8px;
						}
						tr:nth-child(even) {
						  background-color: #dddddd;
						}
						*{
						  font-size: 15px;
						}
						
						</style>
				</head>
				<body>
				
				
			
						<section style="display: flex; justify-content: space-between;">
						  <section></section>
			
			
			
			
						  <section style="border: 1px solid black; width: 100%; ">
			
							<h2 style="font-size: 30px; margin-left: 30px; text-decoration: underline 2px #dc143c;">Five<i style="font-size: 30px; color: #dc143c;">Points</i></h2>
			
							<div style="display: flex;">
								<div style="width: 70%; height: 3vh; background: #dc143c;">
			
								</div>
			
								<div style="margin-top: -17px; margin-left: 10px; margin-right: 10px;">
									<h2 style="font-size: 20px;">INVOICE</h2>
								</div>
							   
							<div style="width: 30%; height: 3vh; background: #dc143c;">
							
							</div>
						</div>
						<b style="margin-right: 50px;margin-left: 30px;">Invoice for :'.$row["customerName"].' </b>
						<h3 style="margin-left: 30px; display: flex; justify-content: space-between;">
						
							<b style="margin-right: 50px;">Date :'.date("jS F Y ").' </b>
							
						</h3>
						<p style="margin-left: 30px;">
							Five Points Unisex Salon<br>
							D2-01, Sector-E,Pocket-1,Vasant Kunj,<br> New Delhi-110070<br>
							fivepointsE1@gmail.com
						</p>
			
						<table>
			
							<tr>
							  <th>S.No.</th>
							  <th>Services</th>
							  <th>Rate</th>
							  <th>Discount</th>
							  <th>Amount</th>
			
							</tr>';
						for($i=0;$i<$itemCount;$i++)
							{
								$html=$html.' <tr>
								<td>'.($i+1).'</td>
								<td>'.$_POST["item_name"][$i].'</td>
								<td>'.$_POST["item_price"][$i].'</td>
								<td>'.$discperc.'%</td>
								<td>'.($_POST["item_price"][$i]-$_POST["item_price"][$i]*$discperc/100).'</td>
							  </tr>';
							}
						$html=$html.'<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Sub Total : '.$totalPrice.'<br>Discount : '.$discperc.'%</td>
					  </tr>
	
					  <tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="background: #dc143c; color: #fff;">Total : '.$paidAmount.'</td>
					  </tr>
					  <tr>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td></td>
					  <td style="background: #dc143c; color: #fff;">Membership Amount Left : '.$row["moneyLeft"].'</td>
					</tr>
				  </table>
	
				  <div style="border: 1px solid #000; text-align: right; padding: 5px; padding-right: 30px;">
					
				  </div>
	
				  <h4 style="margin-left: 30px;">
				  Thanks For Visiting Five Points Unisex Salon
				  </h4>
				  <p style="margin-left: 30px;">
					Declararion : <br>
					This declares that this invoice shows the actual price of the goods described and that all particulars are true and correct
				  </p>
	
	
					<div style="display: flex;">
					  <div style="width: 70%; height: 1vh; background: #dc143c;">
	
					  </div>
	
					  
					
				  <div style="width: 30%; height: 1vh; background: #dc143c;">
	
				  </div>
			  </div>
	
	
				</section>
	
	
	
	
				  <section></section>
				</section>
	
		</body>
	</html>';
				echo smtp_mailer($row['customerEmail'],'subject',$html);
			}
			


		}
	}
	else
	{
	  header("location: index.php");
	  //redirect to dashboard
	}
	
?>



<HTML>
<HEAD>
<TITLE>Five Points</TITLE>
<LINK href="style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="login.css">
<SCRIPT src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
<SCRIPT>
function addMore() {
	$("<DIV>").load("input.php", function() {
			$("#product").append($(this).html());
	});	
}
function deleteRow() {
	$('DIV.product-item').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</SCRIPT>
</HEAD>
<BODY>

<header>
    <a href="customerDash.php"><div>Back</div></a>
    <!-- <a href="generateBill.php"><span>Generate bill</span></a> -->
  </header>

    <!-- <br><br><br><br> -->
    <div class= "customerInfo">
	<?php
        echo "<div>money left : ".$row["moneyLeft"]."</div>";
      
        echo "<div>membership amount : ".$row["membershipAmount"]."</div>";
        
        echo "<div>name : ".$row["customerName"]."</div>";
        
        echo "<div>mobile : ".$row["customerMobile"]."</div>";

		echo "<div>Email : ".$row["customerEmail"]."</div>";

		echo "<div>Card Number : ".$row["customerCardNumber"]."</div>";

        ?>
    </div>
    <br><br><br>


<FORM name="frmProduct" method="post" action="">
<DIV id="outer">
<DIV id="header">
<DIV class="float-left">&nbsp;</DIV>
<DIV class="float-left col-heading">Item Name</DIV>
<DIV class="float-left col-heading">Item Price</DIV>
</DIV>
<DIV id="product">
<?php require_once("input.php") ?>
</DIV>
<DIV class="btn-action float-clear">
<input type="button" name="add_item" value="Add More" onClick="addMore();" />
<input type="button" name="del_item" value="Delete" onClick="deleteRow();" />
<br>
<br>
<?php
echo "<h3>Items : ".$allItems."</h3>";
echo "<h3>TOTAL : ".$totalPrice."</h3>";
echo "<h3>Discount : ".$discount."</h3>";
echo "<h3>paid amount : ".$paidAmount."</h3>";
echo $_SESSION["error3"];
?>
<span class="success"><?php if(isset($message)) { echo $message; }?></span>
</DIV>
<DIV class="footer">
<input type="submit" name="save" value="Print" />
</DIV>
</DIV>
</form>
</BODY>
</HTML>