<?php
require("config.php");
require("confirm_login.php");
session_start();
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";

if(isset($_POST["save"])){
    $password = password_hash( $_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $FixNumber = $_POST["FixNumber"];
    
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Add this line for error handling
    if(verify($email,$connection)){
        header("location: ../../Administration-Maintenance-Creat.php");
    }else{
    try {
        $connection->beginTransaction(); // Start a transaction

        // Select existing administration ID
        $sql1 = "SELECT id FROM administration WHERE user_id=:user_id";
        $statement = $connection->prepare($sql1);
        $statement->bindValue(":user_id", $id);
        $statement->execute();
        $id_administration = $statement->fetchColumn(); // Fetch the single value directly
        //Insert new user record
        $sql2="INSERT INTO user (email,password,type)VALUES(:email,:password,:type)";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);
        $statement->bindValue(":type", "Maintenance");
        $statement->execute();
        $id_user=$connection->lastInsertId();
        // Insert new maintenance record
        $sql3 = "INSERT INTO maintenance (first_name, last_name, fax_number, administration_id,user_id ) VALUES (:first_name, :last_name, :fix_number, :administration_id,:user_id )";
        $statement = $connection->prepare($sql3);
        $statement->bindValue(":first_name", $firstName);
        $statement->bindValue(":last_name", $lastName);
        $statement->bindValue(":fix_number", $FixNumber);
        $statement->bindValue(":administration_id", $id_administration);
        $statement->bindValue(":user_id", $id_user);
        $statement->execute();
        
        $connection->commit(); // Commit the transaction
        header("Location: ../../Administration-Maintenance.php");
    } catch (PDOException $e) {
        $connection->rollBack(); // Rollback the transaction in case of an error
        throw $e; // Re-throw the exception for further handling or logging
    }
}
}

?>
