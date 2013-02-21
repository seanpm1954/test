<?php

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/bids', 'getbids');
$app->get('/bids/:id',	'getbid');
$app->get('/bids/search/:query', 'findByName');
$app->post('/bids', 'addbid');
$app->put('/bids/:id', 'updatebid');
$app->delete('/bids/:id', 'deletebid');

$app->get('/customers', 'getcustomers');

$app->run();

function getbids() {
	$sql = "SELECT bidLog.bidID,
            	bidLog.customerID,
            	bidLog.userID,
            	bidLog.bidDate,
            	bidLog.projectName,
            	bidLog.projectType,
            	bidLog.bidAmount,
            	bidLog.`status`,
            	bidLog.startDate,
            	bidLog.location,
            	bidLog.comments,
            	customers.CustName,
            	`users`.username
            FROM bidLog INNER JOIN customers ON bidLog.customerID = customers.CustomerID
            	 INNER JOIN `users` ON bidLog.userID = `users`.userID ";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$bids = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($bids);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getbid($id) {
	$sql = "SELECT bidLog.bidID,
            	bidLog.customerID,
            	bidLog.userID,
            	bidLog.bidDate,
            	bidLog.projectName,
            	bidLog.projectType,
            	bidLog.bidAmount,
            	bidLog.`status`,
            	bidLog.startDate,
            	bidLog.location,
                bidLog.comments,
            	customers.CustName,
            	`users`.username
            FROM bidLog INNER JOIN customers ON bidLog.customerID = customers.CustomerID
            	 INNER JOIN `users` ON bidLog.userID = `users`.userID WHERE bidID=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$bid = $stmt->fetchObject();
		$db = null;
		echo json_encode($bid);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function addbid() {
	error_log('addbid\n\n', 4, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$bid = json_decode($request->getBody());
	$sql = "INSERT INTO bidLog (customerID, userID, bidDate, projectName, projectType, bidAmount, status, startDate, location, comments) VALUES (:customerID, :userID, :bidDate, :projectName, :projectType, :bidAmount, :status, :startDate, :location, :comments)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("customerID", $bid->customerID);
		$stmt->bindParam("userID", $bid->userID);
		$stmt->bindParam("bidDate", $bid->bidDate);
		$stmt->bindParam("projectName", $bid->projectName);
		$stmt->bindParam("projectType", $bid->projectType);
        $stmt->bindParam("bidAmount", $bid->bidAmount);
		$stmt->bindParam("status", $bid->status);
		$stmt->bindParam("startDate", $bid->startDate);
		$stmt->bindParam("location", $bid->location);
        $stmt->bindParam("comments", $bid->comments);
		$stmt->execute();
		$db = null;
		echo json_encode($bid);
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updatebid($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$bid = json_decode($body);
	$sql = "UPDATE bidLog SET  customerID=:customerID,projectName=:projectName WHERE bidID=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("customerID", $bid->customerID);
        $stmt->bindParam("projectName", $bid->projectName);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($bid);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deletebid($id) {
	$sql = "DELETE FROM bidLog WHERE bidID=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function findByName($query) {
	$sql = "SELECT * FROM bidLog WHERE UPPER(name) LIKE :query ";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$bids = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"bid": ' . json_encode($bids) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getConnection() {
	$dbhost="localhost";
	$dbuser="james";
	$dbpass="jpmgolf";
	$dbname="insul8";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}


function getcustomers() {
	$sql = "SELECT * from customers";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);
		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($customers);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
?>