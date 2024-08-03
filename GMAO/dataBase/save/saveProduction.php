<?php
require("config.php");
require("confirm_login.php");
session_start();

// Check if user is logged in
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";

if(isset($_POST["save"])){
    // Retrieve form data
    $password = password_hash( $_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $fixNumber = $_POST["FixNumber"];
    
    // Establish database connection
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error handling
    
    if(verify($email,$connection)){
        header("location: ../../Administration-Production-Creat.php");
    }else{
    try {
        // Start a transaction
        $connection->beginTransaction(); 
        
        // Select existing administration ID
        $sql1 = "SELECT id FROM administration WHERE user_id=:user_id";
        $statement = $connection->prepare($sql1);
        $statement->bindValue(":user_id", $id);
        $statement->execute();
        $id_administration = $statement->fetchColumn(); 
        
        // Insert new user record
        $sql2 = "INSERT INTO user (email, password, type) VALUES (:email, :password, :type)";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);
        $statement->bindValue(":type", "Production");
        $statement->execute();
        $id_user = $connection->lastInsertId();
        
        // Provide a default value for maintenance_id
        $defaultMaintenanceId = 0; // Example default value
        
        // Insert new production record
        $sql3 = "INSERT INTO production (first_name, last_name, fax_number, administration_id, maintenance_id, user_id) VALUES (:first_name, :last_name, :fix_number, :administration_id, :maintenance_id, :user_id)";
        $statement = $connection->prepare($sql3);
        $statement->bindValue(":first_name", $firstName);
        $statement->bindValue(":last_name", $lastName);
        $statement->bindValue(":fix_number", $fixNumber);
        $statement->bindValue(":administration_id", $id_administration);
        // Provide a default value for maintenance_id
        $statement->bindValue(":maintenance_id", $defaultMaintenanceId);
        $statement->bindValue(":user_id", $id_user);
        $statement->execute();
        
        // Commit the transaction
        $connection->commit();
        
        // Redirect to a specific page upon successful insertion
        header("Location: ../../Administration-Production-Creat.php");
        exit(); // Terminate script execution after redirection
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $connection->rollBack();
        // Handle or log the exception
        echo "Error: " . $e->getMessage();
    }
}
}
?>
