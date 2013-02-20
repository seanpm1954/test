<?php

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/bids', 'getBids');
$app->get('/bids/:id',	'getBid');
$app->get('/bids/search/:query', 'findByName');
$app->post('/bids', 'addBid');
$app->put('/bids/:id', 'updateBid');
$app->delete('/bids/:id', 'deleteBid');

$app->run();

function getBids() {
	$sql ="SELECT bidLog.bidID,
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
		$db = getConnection();
		//$stmt = $db->query($sql);  
		$bids =  mysqli_query($db,$sql);
		$db = null;
		echo json_encode($bids);
}

function getBid($id) {
	$sql = "SELECT * FROM bidLog WHERE bidID=:id";
	$db = getConnection();
		//$stmt = $db->query($sql);  
		$bid =  mysqli_query($db,$sql);
		$db = null;
		echo json_encode($bid);
}

function addBid() {
	error_log('addBid\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$bid = json_decode($request->getBody());
	//$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";

}

function updateBid($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$bid = json_decode($body);
	//$sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
	}

function deleteBid($id) {
	//$sql = "DELETE FROM wine WHERE id=:id";
}

function findByName($query) {
	//$sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
	
}

function getConnection() {
	/*
	$dbhost="127.0.0.1";
	$dbuser="james";
	$dbpass="jpmgolf";
	$dbname="insul8";
	*/
	$dbh = mysqli_connect('localhost','james','jpmgolf','insul8');
	return $dbh;
}

?>