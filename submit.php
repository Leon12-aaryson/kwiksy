<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $phone = $_POST['phone'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];

  // Check if the phone number already exists
  $stmt = $conn->prepare("SELECT id FROM Data WHERE phone = :phone");
  $stmt->execute(['phone' => $phone]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    echo 'Duplicate Entry';
  } else {
    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO Data (phone, name, email, address) VALUES (:phone, :name, :email, :address)");
    $stmt->execute(['phone' => $phone, 'name' => $name, 'email' => $email, 'address' => $address]);
    echo $conn->lastInsertId();
  }
} else {
  echo 'Invalid request';
}
