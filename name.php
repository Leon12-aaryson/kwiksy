<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['name'] ?? '';

    if (!empty($search)) {
        $query = "SELECT * FROM `Data` WHERE `name` LIKE :search_name";
        $stmt = $conn->prepare($query);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search_name', $searchTerm);

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

