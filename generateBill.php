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
			}
			elseif($row["membershipAmount"]=="10000")
			{
				$discount=0.3*$totalPrice;
			}
			elseif($row["membershipAmount"]=="30000")
			{
				$discount=0.4*$totalPrice;
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
				$html='bill msg';
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