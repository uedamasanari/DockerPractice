<?php

class Database {
  private $pdo;

  public function __construct() {
    // ここにデータベース接続設定を記載してください。
    $host = 'mysql';
    $dbname = 'your_database';
    $user = 'your_user';
    $password = 'your_password';

    try {
      $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    } catch (PDOException $e) {
      die('Connection failed: ' . $e->getMessage());
    }
  }

  public function saveImagePath(string $filename): string {
    $stmt = $this->pdo->prepare('INSERT INTO images (path) VALUES (:path)');
    $stmt->bindValue(':path', $filename, PDO::PARAM_STR);
    $stmt->execute();
    $imageId = $this->pdo->lastInsertId();

    return $imageId;
  }

  public function getImages() {
      $stmt = $this->pdo->prepare("SELECT * FROM images");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
?>