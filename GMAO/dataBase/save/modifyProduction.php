<?php
require("config.php");
session_start();

if(isset($_POST["modify"])){
    // Retrieve form data
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $FixNumber = $_POST["FixNumber"];
    $production_id = $_POST["production_id"];
    $id_user= $_POST["id_user"];
    
    try {
        // Establish database connection
        $connection = new PDO($dsn, $db_user, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare and execute the SQL update statement
        $sql1 = "UPDATE production SET first_name=:first_name, last_name=:last_name, fax_number=:fix_number WHERE id=:id";
        $statement = $connection->prepare($sql1);
        $statement->bindValue(":first_name", $firstName);
        $statement->bindValue(":last_name", $lastName);
        $statement->bindValue(":fix_number", $FixNumber);
        $statement->bindValue(":id", $production_id);
        $statement->execute();
       // Modify table user
        $sql2="UPDATE user SET email=:email WHERE id=:id_user";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":id_user", $id_user);
        $statement->execute();
        header("Location: ../../Administration-Production.php");
        // header("Location: ../../Administration-Production.php");
        exit(); // Ensure script execution stops after redirection or echo
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to the appropriate page if the form was not submitted properly

    exit();
}
?>
