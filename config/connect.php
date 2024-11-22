<!-- 
    Connection to the database using PDO (PHP Data Objects) to connect to a MySQL database. 
    This file should be included at the top of each page that requires a connection to the database.
 -->
<?php

$host = "127.0.0.1";
$dbname = "travago";
$username = "root";
$password = "root";
$dsn = "mysql:host=$host;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die('Connection failed: ' . $e->getMessage());
}

// ///////////////////////////////////////////////////////////////////////////////
// try {
//     // Create a new table named users
//     $pdo = new PDO($dsn, $username, $password);
//     // set the PDO error mode to exception
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $stmt = $pdo->prepare(
//         "CREATE TABLE IF NOT EXISTS users (
//         id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//         username VARCHAR(50) NOT NULL,
//         email VARCHAR(100) NOT NULL,
//         password VARCHAR(100) NOT NULL,
//         isVerified BOOLEAN DEFAULT FALSE,
//         address VARCHAR(255),
//         phone VARCHAR(20),
//         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//         user_type ENUM('admin', 'user', 'agency') DEFAULT 'user' NOT NULL,
//         company_id INT NOT NULL
//         )"
//     );
//     $stmt->execute();
// } catch (PDOException $e) {
//     echo $sql . "<br>" . $e->getMessage();
// }

// try {
//     // Create a new table named companies
//     $pdo = new PDO($dsn, $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $sql = "CREATE TABLE IF NOT EXISTS companies (
//     id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//     name VARCHAR(100) NOT NULL,
//     address VARCHAR(255),
//     phone VARCHAR(20),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )";
//     $pdo->exec($sql);


// } catch (PDOException $e) {
//     echo $sql . "<br>" . $e->getMessage();
// }

// // insert a company travago
// try {
//     $pdo = new PDO($dsn, $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $name = "Travago";
//     $address = "123 Main St, New York, NY 10001";
//     $phone = "123-456-7890";

//     $stmt = $pdo->prepare("INSERT INTO companies (name, address, phone) VALUES (:name, :address, :phone)

//     ");
//     $stmt->bindParam(':name', $name);
//     $stmt->bindParam(':address', $address);
//     $stmt->bindParam(':phone', $phone);

//     $stmt->execute();
//     // get the id of the company
//     // $company = $pdo->lastInsertId();

// } catch (PDOException $e) {
//     echo $sql . "<br>" . $e->getMessage();
// }

// INSERT AN ADMIN
// try {
//     $username = "admin";
//     $email = "admin@travago.com";
//     $password = "admin";
//     $isVerified = true;
//     $address = "123 Main St, New York, NY 10001";
//     $phone = "123-456-7890";
//     $user_type = "admin";
//     $company = 1;

//     $stmt = $pdo->prepare("INSERT INTO users (username, email, password, user_type, company_id, isVerified) 
//         VALUES (:username, :email, :password, :user_type, :company_id, :isVerified)");
//     $stmt->bindValue(':username', $username);
//     $stmt->bindValue(':email', $email);
//     $stmt->bindValue(':password', $password);
//     $stmt->bindValue('isVerified', $isVerified);
//     $stmt->bindValue('address', $address);
//     $stmt->bindValue('phone', $phone);
//     $stmt->bindValue(':user_type', $user_type);
//     $stmt->bindValue(':company_id', $company);

//     $stmt->execute();
// } catch (PDOException $e) {
//     echo $sql . "<br>" . $e->getMessage();
// }

?>