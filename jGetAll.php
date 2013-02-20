<?php
header('Content-Type: application/json');

$db = mysqli_connect('localhost','james','jpmgolf','insul8');
if(!$db)
		{
			echo "Could not connect to the server";
		}
		else
		{
			$query="SELECT bidLog.bidID,
                    	customer.CustName,
                    	customer.CustomerID,
                    	`user`.username,
                    	`user`.userID,
                    	bidLog.bidDate,
                    	bidLog.projectName,
                    	bidLog.projectType,
                    	bidLog.bidAmount,
                    	bidLog.`status`,
                    	bidLog.startDate,
                    	bidLog.location,
                    	bidLog.comments
                    FROM customer INNER JOIN bidLog ON customer.CustomerID = bidLog.customerID
                    	 INNER JOIN `user` ON `user`.userID = bidLog.userID
                    ORDER BY bidLog.bidDate ASC";
			$result = mysqli_query($db,$query);

			while($row = mysqli_fetch_array($result, MYSQL_ASSOC))
			{
				$main_arr[] = $row;
			}

 		$json=json_encode($main_arr);
 		
 		echo $json;
 	}

?> 