<?php
require("config.php");
session_start();

// Check if session variables are set and assign them to local variables


if(isset($_POST["modify"])) {
    // Retrieve form data
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $email = isset($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) : "";
    $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : "";
    $fixNumber = isset($_POST["fixNumber"]) ? $_POST["fixNumber"] : "";
    $typeCreation = isset($_POST["type"]) ? $_POST["type"] : "";
    $id_equipe = isset($_POST["id_equipe"]) ? $_POST["id_equipe"] : "";
    $id_user = isset($_POST["id_user"]) ? $_POST["id_user"] : "";
    
    try {
        // Establish database connection
        $connection = new PDO($dsn, $db_user, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare and execute the SQL update statement
        $sql = "UPDATE equipe SET type=:type, name_boss=:first_name,fax_number=:fix_number WHERE id=:id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":first_name", $firstName);
        $statement->bindValue(":fix_number", $fixNumber);
        $statement->bindValue(":type", $typeCreation);
        $statement->bindValue(":id", $id_equipe);
        $statement->execute();
        $sql2 = "UPDATE user SET email=:email, type=:type WHERE id=:id";
        $statement2 = $connection->prepare($sql2);
        $statement2->bindValue(":email", $email);  
        $statement2->bindValue(":type", $typeCreation);
        $statement2->bindValue(":id", $id_user);

        $statement2->execute(); // Execute the second statement
        
        // Redirect after successful update
        header("Location: ../../Administration-Equipe.php");
        exit(); // Terminate script execution after redirect
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
