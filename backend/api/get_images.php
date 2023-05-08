<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../database.php';

$db = new Database();

$images = $db->getImages();

http_response_code(200);
echo json_encode(['images' => $images]);
?>