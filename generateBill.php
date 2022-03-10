<?php
	session_start();
	if($_SESSION['login']==true)
	{
		if(!empty($_POST["save"])) {
			$conn = mysqli_connect("localhost","root","test", "blog_samples");
			$itemCount = count($_POST["item_name"]);
			$itemValues=0;
			$query = "INSERT INTO item (item_name,item_price) VALUES ";
			$queryValue = "";
			for($i=0;$i<$itemCount;$i++) {
				if(!empty($_POST["item_name"][$i]) || !empty($_POST["item_price"][$i])) {
					$itemValues++;
					if($queryValue!="") {
						$queryValue .= ",";
					}
					$queryValue .= "('" . $_POST["item_name"][$i] . "', '" . $_POST["item_price"][$i] . "')";
				}
			}
			$sql = $query.$queryValue;
			if($itemValues!=0) {
				$result = mysqli_query($conn, $sql);
				if(!empty($result)) $message = "Added Successfully.";
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
<TITLE>PHP jQuery Dynamic Textbox</TITLE>
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
        <div>money left : 5000</div>
      
        <div>membership amount : 10000</div>
        
        <div>name : Rohan</div>
        
        <div>mobile : 9654210264</div>
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
<h3>TOTAL : 5000</h3>
<h3>Discount : 5000</h3>
<h3>paid amount : 5000</h3>
<span class="success"><?php if(isset($message)) { echo $message; }?></span>
</DIV>
<DIV class="footer">
<input type="submit" name="save" value="Print" />
</DIV>
</DIV>
</form>
</BODY>
</HTML>