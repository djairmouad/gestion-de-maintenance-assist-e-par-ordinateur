<?php
require("config.php");
session_start();


if(isset($_POST["delete"])){
    $id_Maint = $_POST["Number"];
    $id_equipe = isset($_POST["id_equipe"]) ? $_POST["id_equipe"] : "";
    $id_user = isset($_POST["id_user"]) ? $_POST["id_user"] : "";
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Add this line for error handling
    
    try {
        // Prepare and execute the SQL update statement
        $sql = "DELETE  from equipe WHERE id=:id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $id_equipe);
        $statement->execute();
        $sql2 = "DELETE FROM user WHERE id=:id";
        $statement2 = $connection->prepare($sql2); // Use a different variable for the statement
        $statement2->bindValue(":id", $id_user);
        $statement2->execute();
        header("Location: ../../Administration-Equipe.php");
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
}
?>
