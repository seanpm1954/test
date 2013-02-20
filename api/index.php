<?php

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/bids', 'getbids');
$app->get('/bids/:id',	'getbid');
$app->get('/bids/search/:query', 'findByName');
$app->post('/bids', 'addWine');
$app->put('/bids/:id', 'updateWine');
$app->delete('/bids/:id', 'deleteWine');

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
            	customers.CustName,
            	`user`.username
            FROM bidLog INNER JOIN customers ON bidLog.customerID = customers.CustomerID
            	 INNER JOIN `user` ON bidLog.userID = `user`.userID ";
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
            	customers.CustName,
            	`user`.username
            FROM bidLog INNER JOIN customers ON bidLog.customerID = customers.CustomerID
            	 INNER JOIN `user` ON bidLog.userID = `user`.userID WHERE bidID=:id";
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

function addWine() {
	error_log('addWine\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$wine = json_decode($request->getBody());
	$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("name", $wine->name);
		$stmt->bindParam("grapes", $wine->grapes);
		$stmt->bindParam("country", $wine->country);
		$stmt->bindParam("region", $wine->region);
		$stmt->bindParam("year", $wine->year);
		$stmt->bindParam("description", $wine->description);
		$stmt->execute();
		$wine->id = $db->lastInsertId();
		$db = null;
		echo json_encode($wine); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateWine($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$wine = json_decode($body);
	$sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("name", $wine->name);
		$stmt->bindParam("grapes", $wine->grapes);
		$stmt->bindParam("country", $wine->country);
		$stmt->bindParam("region", $wine->region);
		$stmt->bindParam("year", $wine->year);
		$stmt->bindParam("description", $wine->description);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($wine); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteWine($id) {
	$sql = "DELETE FROM wine WHERE id=:id";
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
	$sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"wine": ' . json_encode($wines) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getConnection() {
	$dbhost="127.0.0.1";
	$dbuser="james";
	$dbpass="jpmgolf";
	$dbname="insul8";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

?>