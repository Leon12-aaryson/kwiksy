<?php
include "conn.php";

try {
	$query = "SELECT * FROM `Data`";
	$stmt = $conn->prepare($query);

	$stmt->execute();

	// Fetch all results
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Output the results as JSON
	echo json_encode($results);
} catch (PDOException $e) {
	// Handle any errors
	echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}