<?php
require("config.php");
require("../../Email/SendMail.php");

// Validate and sanitize user inputs
$name_maintenance = filter_input(INPUT_POST, "name_maintenance", FILTER_SANITIZE_STRING);
$date_maintenance = filter_input(INPUT_POST, "date_maintenance", FILTER_SANITIZE_STRING);
$id_formulaire = filter_input(INPUT_POST, "id_formulaire", FILTER_VALIDATE_INT);

// Establish database connection
try {
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve production ID
    $sql1 = 'SELECT `production_id` FROM formulaire WHERE id = :id_formulaire';
    $statement = $connection->prepare($sql1);
    $statement->bindValue(":id_formulaire", $id_formulaire, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll();
    $id_production = $result[0]["production_id"];

    // Retrieve email associated with production ID
    $sql2 = "SELECT `email` FROM  user JOIN production  ON production.user_id = user.id WHERE production.id = :id_production;";
    $statement = $connection->prepare($sql2);
    $statement->bindValue(":id_production", $id_production, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll();
    $email = $result[0]["email"];

    // Update formulaire
    $sql3 = "UPDATE formulaire SET type_formulaire = :type_formulaire, 
            name_maintenance_director = :name_maintenance_director, 
            date_maintenance = :date_maintenance 
            WHERE id = :id_formulaire";

    $statement = $connection->prepare($sql3);
    $statement->bindValue(":type_formulaire", "Maintenance");
    $statement->bindValue(":name_maintenance_director", $name_maintenance);
    $statement->bindValue(":date_maintenance", $date_maintenance);
    $statement->bindValue(":id_formulaire", $id_formulaire, PDO::PARAM_INT);
    $statement->execute();

    // Send email notification
    SendMail($email, "Request for Intervention from maintenance: " . $name_maintenance);

    // Redirect after successful operation
    header("Location: ../../Maintenance.php");
    exit(); // Ensure script termination after redirection
} catch (PDOException $e) {
    // Handle database errors
    echo "Connection failed: " . $e->getMessage();
}
?>
