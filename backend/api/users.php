<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    // Replace with your actual database connection info
    $host = 'mysql';
    $dbname = 'your_database';
    $user = 'your_user';
    $password = 'your_password';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare('SELECT * FROM users');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($users);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
