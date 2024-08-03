<?php
require("config.php");
session_start();
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
$id_user = isset($_POST["id_user"]) ? $_POST["id_user"] : "";
if(isset($_POST["delete"])){
    $production_id = $_POST["production_id"];
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Add this line for error handling
    
    try {
        // Prepare and execute the SQL update statement
        $sql = "DELETE  from production WHERE id=:id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $production_id);
        $statement->execute();
        $sql3 = "DELETE FROM user WHERE id=:id";
        $statement2 = $connection->prepare($sql3); // Use a different variable for the statement
        $statement2->bindValue(":id", $id_user);
        $statement2->execute();
        header("Location: ../../Administration-Production.php");
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
}
?>
