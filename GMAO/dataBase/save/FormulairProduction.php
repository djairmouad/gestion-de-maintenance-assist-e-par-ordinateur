<?php
require("config.php");
require("../../Email/SendMail.php");

// Retrieve form data
$name_production = $_POST["name_production"] ?? '';
$date_production = $_POST["date_production"] ?? '';
$id_formulaire = $_POST["id_formulaire"] ?? '';

// Establish database connection
try {
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors gracefully
    echo "Connection failed: " . $e->getMessage();
    exit();
}

try {
    // Retrieve type of problem and maintenance ID associated with the form ID
    $sql1 = 'SELECT maintenance_id, type_probleme FROM formulaire WHERE id = :id_formulaire';
    $statement = $connection->prepare($sql1);
    $statement->bindValue(":id_formulaire", $id_formulaire, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $id_maintenance = $row["maintenance_id"];
        $typeProblem = $row["type_probleme"];
    } else {
        // Handle if the form ID is not found
        echo "Form ID not found.";
        exit();
    }

    // Retrieve email associated with maintenance ID and type of problem
    $sql2 = "SELECT `email` 
    FROM `user` 
    JOIN `equipe` ON `equipe`.`user_id` = `user`.`id` 
    WHERE `equipe`.`maintenance_id` = :id_maintenance 
      AND `equipe`.`type` = :type";
    $statement = $connection->prepare($sql2);
    $statement->bindValue(":id_maintenance", $id_maintenance, PDO::PARAM_INT);
    $statement->bindValue(":type", $typeProblem, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $email = $row["email"];
    } else {
        // Handle if email is not found
        echo "Email not found for maintenance ID: $id_maintenance and type: $typeProblem";
        exit();
    }

    // Update the form data
    $sql3 = "UPDATE formulaire SET type_formulaire = :type_formulaire, 
            name_production_director = :name_production_director, 
            date_production = :date_production 
            WHERE id = :id_formulaire";

    $statement = $connection->prepare($sql3);
    $statement->bindValue(":type_formulaire", "Production");
    $statement->bindValue(":name_production_director", $name_production);
    $statement->bindValue(":date_production", $date_production);
    $statement->bindValue(":id_formulaire", $id_formulaire);
    $statement->execute();

    // Send email notification
    SendMail($email, "Order for Intervention from Production: " . $name_production);

    // Redirect the user
    header("Location: ../../Production.php");
    exit(); // Ensure script execution stops after redirection
} catch (PDOException $e) {
    // Handle any database errors gracefully
    echo "Error: " . $e->getMessage();
    exit();
}
?>
