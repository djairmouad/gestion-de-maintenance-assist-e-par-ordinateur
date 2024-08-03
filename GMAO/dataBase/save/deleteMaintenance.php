<?php
require("config.php");
session_start();
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";

if(isset($_POST["delete"])){
    $id_Maint = isset($_POST["Number"]) ? $_POST["Number"] : "";
    $id_user = isset($_POST["id_user"]) ? $_POST["id_user"] : "";
    // Validate and sanitize user input
    if(!empty($id_Maint) && is_numeric($id_Maint)) {
        $id_Maint = intval($id_Maint);

        try {
            $connection = new PDO($dsn, $db_user, $db_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute the SQL delete statement
            $sql = "DELETE FROM maintenance WHERE id = :id";
            $statement = $connection->prepare($sql);
            $statement->bindValue(":id", $id_Maint);
            $statement->execute();

            // Update related table
            $sql2 = "UPDATE equipe SET maintenance_id = 0 WHERE maintenance_id = :id";
            $statement2 = $connection->prepare($sql2);
            $statement2->bindValue(":id", $id_Maint);
            $statement2->execute();
            $sql3 = "DELETE FROM user WHERE id=:id";
            $statement2 = $connection->prepare($sql3); // Use a different variable for the statement
            $statement2->bindValue(":id", $id_user);
            $statement2->execute();
            // Redirect after processing
            header("Location: ../../Administration-Maintenance.php");
            exit; // Exit to prevent further execution
        } catch (PDOException $e) {
            // Log or display error message
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Handle invalid input
        echo "Invalid input.";
    }
}
?>
