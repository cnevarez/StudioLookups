﻿<?php
   require("connect.php");
	
	if(!$con) {
	
		echo 'Could not connect to the database.';
	} else {
	
		if(isset($_POST['queryString'])) {
			$queryString = $con->real_escape_string($_POST['queryString']);
			
			if(strlen($queryString) >0) {

				$query = $con->query("SELECT id FROM studioaccids WHERE id LIKE '$queryString%' LIMIT 15");
				$num_rows = mysqli_num_rows($query);
				if($query) {
				echo '<ul>';
					echo '<ul>';
					if($num_rows !== 0){
							while ($result = $query ->fetch_object()) {
								echo '<li onClick="fill2(\''.addslashes($result->id).'\');">'.$result->id.'</li>';
							}	
					}else{
						echo " No suggestions found ";	
					}
					echo '</ul>';
					
				} else {
					echo 'OOPS we had a problem :(';
				}
			} else {
				// do nothing
			}
		} else {
			echo '<img src="http://www.deliberateblog.com/wp-content/uploads/2013/11/grumpy-cat-no.png"/>';
		}
	}
?>