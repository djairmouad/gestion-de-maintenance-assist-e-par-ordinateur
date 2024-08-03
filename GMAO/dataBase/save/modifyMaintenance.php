<?php
require("config.php");
session_start();
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";

if(isset($_POST["modify"])){
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $FixNumber = $_POST["FixNumber"];
    $id_Maint = $_POST["Number"];
    $id_user = $_POST["id_user"];
    
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Add this line for error handling
    
    try {
        // Prepare and execute the SQL update statement
        $sql = "UPDATE maintenance SET first_name=:first_name, last_name=:last_name,fax_number=:fix_number WHERE id=:id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":first_name", $firstName);
        $statement->bindValue(":last_name", $lastName);
        $statement->bindValue(":fix_number", $FixNumber);
        $statement->bindValue(":id", $id_Maint);
        $statement->execute();
         // Modify table user
         $sql2="UPDATE user SET email=:email WHERE id=:id_user";
         $statement = $connection->prepare($sql2);
         $statement->bindValue(":email", $email);
         $statement->bindValue(":id_user", $id_user);
         $statement->execute();
        header("Location: ../../Administration-Maintenance.php");
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
}
?>
