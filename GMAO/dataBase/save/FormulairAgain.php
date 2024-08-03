<?php
require_once("config.php"); // Assuming "config.php" contains database connection details
require_once("../../Email/SendMail.php"); // Adjust the path if necessary

// Start the session
session_start();

// Check if the form fields are submitted and initialize variables safely
$name_equipe = isset($_POST["name_Equipe"]) ? $_POST["name_Equipe"] : '';
$equipment_type = isset($_POST["equipment-type"]) ? $_POST["equipment-type"] : array(); // Store as array
$id_formulaire = isset($_POST["id_formulaire"]) ? $_POST["id_formulaire"] : '';
$date_maintenance = isset($_POST["date_maintenance"]) ? $_POST["date_maintenance"] : '';

try {
    // Establish database connection
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data from the database based on the submitted form ID
    $sql1 = 'SELECT maintenance_id, type_probleme, name_maintenance_director FROM formulaire WHERE id = :id_formulaire';
    $statement = $connection->prepare($sql1);
    $statement->bindValue(":id_formulaire", $id_formulaire, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $id_maintenance = $row["maintenance_id"];
        $typeProblemDB = json_decode($row["type_probleme"], true); // Store as an array
        $name_maintenance = $row["name_maintenance_director"];
    } else {
        // Handle if the form ID is not found
        echo "Form ID not found.";
        exit();
    }

    // Retrieve email associated with maintenance ID and type of problem
    $email = []; // Initialize an array to store emails
    foreach ($typeProblemDB as $type) {
        $sql2 = "SELECT `email` 
        FROM `user` 
        JOIN `equipe` ON `equipe`.`user_id` = `user`.`id` 
        WHERE `equipe`.`maintenance_id` = :id_maintenance 
          AND `equipe`.`type` = :type";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":id_maintenance", $id_maintenance, PDO::PARAM_INT);
        $statement->bindValue(":type", $type, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $email[] = $row["email"]; // Append email to the array
        } else {
            // Handle if email is not found
            echo "Email not found for maintenance ID: $id_maintenance and type: $type";
            // You might want to handle this case differently depending on your requirements
        }
    }

    // Update formulaire table
    $sql3 = "UPDATE formulaire 
        SET type_formulaire = :type_formulaire, 
            type_probleme = :type_probleme,
            date_maintenance=:date_maintenance,
            summary_Mechanical = '',
            summary_Electric = '',
            summary_Hydraulic = '',
            summary_Informatique = ''
        WHERE id = :id_formulaire";

    $statement = $connection->prepare($sql3);
    $statement->bindValue(":type_formulaire", "Production");
    // Convert array to JSON string before binding
    $equipment_type_json = json_encode($equipment_type);
    $statement->bindValue(":type_probleme", $equipment_type_json);
    $statement->bindValue(":id_formulaire", $id_formulaire);
    $statement->bindValue(":date_maintenance", $date_maintenance);
    $statement->execute();

    // Send emails to the retrieved email addresses
    foreach ($email as $recipient) {
        SendMail($recipient, "Order for Intervention from Maintenance: " . $name_maintenance);
    }

    // Redirect the user to a specific page after completing the process
    
    header("Location: ../../Problem.php");
    exit(); // Ensure no code is executed after redirection
} catch (PDOException $e) {
    // Handle PDO errors
    echo "PDO Error: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    // Handle other exceptions
    echo "Error: " . $e->getMessage();
    exit();
}
?>
