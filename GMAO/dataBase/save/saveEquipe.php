<?php
require("config.php");
require("confirm_login.php");
session_start();

try {
    // Check if the save button is clicked
    if(isset($_POST["save"])){

        // Validate and sanitize form data
        $password = password_hash( $_POST["password"], PASSWORD_BCRYPT);
        $email = isset($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) : "";
        $firstName = isset($_POST["firstName"]) ? htmlspecialchars($_POST["firstName"]) : "";
        $fixNumber = isset($_POST["fixNumber"]) ? htmlspecialchars($_POST["fixNumber"]) : "";
        $typeCreation = isset($_POST["type"]) ? htmlspecialchars($_POST["type"]) : "";
     
        // Check for empty fields
        if(empty($password) || empty($email) || empty($firstName) || empty($fixNumber) || empty($typeCreation)) {
            throw new Exception("Please fill out all required fields.");
        }

        // Connect to the database using PDO
        $connection = new PDO($dsn, $db_user, $db_password);
        // Set PDO to throw exceptions on errors
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if(verify($email,$connection)){
            header("location: ../../Administration-Equipe-Creat.php");
        }else{

        
        // Begin a transaction
        $connection->beginTransaction();

        // Retrieve the administration ID for the current user
        $sql1 = "SELECT id FROM administration WHERE user_id=?";
        $statement = $connection->prepare($sql1);
        $statement->execute([$_SESSION["id"]]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $id_administration = $row['id'];

        // Insert new user record
        $sql2 = "INSERT INTO user (email, password, type) VALUES (?, ?, ?)";
        $statement = $connection->prepare($sql2);
        $statement->execute([$email, $password, $typeCreation]);
        $id_user = $connection->lastInsertId();

        // Insert new record into equipe table
        $sql3 = "INSERT INTO equipe (type, name_boss,fax_number, maintenance_administration_id, user_id) 
                 VALUES (?, ?, ?, ?, ?)";
        $statement = $connection->prepare($sql3);
        $statement->execute([$typeCreation, $firstName, $fixNumber, $id_administration, $id_user]);

        // Commit the transaction
        $connection->commit();

        // Redirect after successful insertion
        header("Location: ../../Administration-Equipe.php");
        exit();
    }
}
} catch (Exception $e) {
    // Rollback the transaction if an error occurs
    $connection->rollback();
    // Log errors
    error_log("Exception: " . $e->getMessage());
    // Display a user-friendly error message
    echo "An unexpected error occurred: " . $e->getMessage() . ". Please try again later. If the problem persists, please contact support.";
}
?>
