<?php
// initialize the db once and for all in the config/init_db.php file and include it in the config/connect.php file 
// so that the db is initialized only once and not every time the connect.php file is included in a page 
// this will help in reducing the overhead of initializing the db every time a page is loaded

// Create db travago if it does not exist and create tables if they do not exist  here

// Create a new database named travago
include 'init_db.php'; 

$host = "localhost";

$root = "root";
$root_password = "";

$user = 'root';
$pass = 'root';
$db = "travago";

try {
  $dbh = new PDO("mysql:host=$host", $root, $pass);

  $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;
                -- drop user $user@localhost;
                -- flush privileges;
                -- CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                -- GRANT ALL ON `$db`.* TO '$user'@'localhost';
                -- FLUSH PRIVILEGES;
                ");

} catch (PDOException $e) {
  die("DB ERROR: " . $e->getMessage());
}


/////////////////////////////////////////////////////////////////////////////////
// try {
//   // Create a new table named users
//   $pdo = new PDO("mysql:host=$servername;dbname=travago", $username, $password);
//   // set the PDO error mode to exception
//   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS users (
//     id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//     username VARCHAR(50) NOT NULL,
//     email VARCHAR(100) NOT NULL,
//     password VARCHAR(100) NOT NULL,
//     isVerified BOOLEAN DEFAULT FALSE,
//     address VARCHAR(255),
//     phone VARCHAR(20),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     user_type ENUM('admin', 'user', 'agency') DEFAULT 'user' NOT NULL,
//     company_id INT
// )");
//   if ($stmt->execute()) {
//     echo "Table users created successfully<br>";
//   }
// } catch (PDOException $e) {
//   echo $sql . "<br>" . $e->getMessage();
// }
// try {
//   // Create a new table named users
//   $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//   $sql = "CREATE TABLE IF NOT EXISTS companies (
//     id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//     name VARCHAR(100) NOT NULL,
//     address VARCHAR(255),
//     phone VARCHAR(20),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )";
//   $pdo->exec($sql);

//   echo "Table companies created successfully<br>";

// } catch (PDOException $e) {
//   echo $sql . "<br>" . $e->getMessage();
// }