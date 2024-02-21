<?php
include_once 'util.php';
if(isset($_POST['save']))
{	 
	 $name = $_POST['name'];
	 $shipping_street__c = $_POST['shipping_street__c'];
	 $shipping_city__c = $_POST['shipping_city__c'];
	 $co_exhibitor_total__c = $_POST['co_exhibitor_total__c'];
	 $query = "INSERT INTO salesforce.exhibitor_contract__c(name,shipping_street__c,shipping_city__c,co_exhibitor_total__c) 
	 values ('$name','$shipping_street__c','$shipping_city__c','$co_exhibitor_total__c')";
	 if($result = pg_query($query)){
		 echo "Data Added Successfully.";
	 }
	 else{
		echo "Error.";
	 }
}
?>
