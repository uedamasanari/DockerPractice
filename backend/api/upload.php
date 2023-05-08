<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit();
}

// Check if the uploaded file exists
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['error' => 'No image uploaded']);
  exit();
}

// Save the uploaded file
$image = $_FILES['image'];
$uploadDir = 'uploads/';
$filename = uniqid() . '_' . $image['name'];
$filePath = $uploadDir . $filename;

// Create upload directory if it doesn't exist
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

// Move the uploaded file to the upload directory
if (!move_uploaded_file($image['tmp_name'], $filePath)) {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to save the uploaded image']);
  exit();
}

// Connect to the database
require_once '../database.php';
$db = new Database();

// Save the image path to the database
$imagePath = $db->saveImagePath($filename);

// Return the image path
http_response_code(200);
echo json_encode(['imagePath' => $imagePath]);
