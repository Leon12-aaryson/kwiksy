<?php
// Include the database connection file
include "conn.php";

try {
	// Prepare the SQL query to fetch all data from the table
	$query = "SELECT * FROM `Data`";
	$stmt = $conn->prepare($query);

	// Execute the query
	$stmt->execute();

	// Fetch all results
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Output the results as JSON
	echo json_encode($results);
} catch (PDOException $e) {
	// Handle any errors
	echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}