<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $search = $_POST['phone'] ?? ''; // Change 'search_phone' to 'phone'

  if (!empty($search)) {
    $query = "SELECT * FROM `Data` WHERE `phone` LIKE :search_phone";
    $stmt = $conn->prepare($query);
    $searchTerm = '%' . $search . '%';
    $stmt->bindParam(':search_phone', $searchTerm);

    if ($stmt->execute()) {
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ($results) {
        echo json_encode($results);
      } else {
        echo json_encode(["status" => "no_results", "message" => "No results found"]);
      }
    } else {
      echo json_encode(["status" => "error", "message" => "Query failed"]);
    }
  } else {
    echo json_encode(["status" => "error", "message" => "Search term is empty"]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
