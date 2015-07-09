<?php
//Use the follwoing for local testing
/*require("phpsqlajax_dbinfo.php");
$con=mysqli_connect($host, $user, $password, $database);
$tableSchema = "studioacc";*/

//uncomment the following before pushing to production
$con=mysqli_connect('mysql6.000webhost.com', 'a6834248_studio', 'element101'); 
 mysqli_select_db($con,'a6834248_studio'); 
$tableSchema = "a6834248_studio";
 ?>