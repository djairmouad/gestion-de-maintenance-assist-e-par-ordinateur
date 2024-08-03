<?php
require("config.php");
require("../../Email/SendMail.php");

// Start the session
session_start();

// Check if the form fields are submitted and initialize variables safely
$name_equipe = isset($_POST["name_Equipe"]) ? $_POST["name_Equipe"] : '';
$date_end = isset($_POST["date_end"]) ? $_POST["date_end"] : '';
$id_formulaire = isset($_POST["id_formulaire"]) ? $_POST["id_formulaire"] : '';
$summary = isset($_POST["summary"]) ? $_POST["summary"] : '';
$TypeCreation = isset($_SESSION["type"]) ? $_SESSION["type"] : "";

// Establish database connection
try {
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
    exit(); // Stop further execution
}

// Prepare and execute the SQL query
try {
    if(!empty($summary)){
        $sql1 = 'SELECT `maintenance_id` FROM formulaire WHERE id = :id_formulaire';
        $statement = $connection->prepare($sql1);
        $statement->bindValue(":id_formulaire", $id_formulaire, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $id_maintenance = $result["maintenance_id"];

        // Retrieve email associated with maintenance ID
        $sql2 = "SELECT `email` FROM  user JOIN maintenance  ON maintenance.user_id = user.id WHERE maintenance.id = :id_maintenance;";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":id_maintenance", $id_maintenance, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $email = $result["email"];

        $sql3 = "UPDATE formulaire 
                SET type_formulaire = :type_formulaire, 
                    name_Equipe = :name_Equipe, 
                    date_end = :date_end,
                    summary_".$TypeCreation."=:summary
                WHERE id = :id_formulaire";

        $statement = $connection->prepare($sql3);
        $statement->bindValue(":type_formulaire", "Problem");
        $statement->bindValue(":name_Equipe", $name_equipe);
        $statement->bindValue(":date_end", $date_end);
        $statement->bindValue(":id_formulaire", $id_formulaire);
        $statement->bindValue(":summary", $summary);
        $statement->execute();
        $emailSubject = "Problem Request for Intervention from equipe: " .$TypeCreation.": ". $name_equipe;

        // Send email
        SendMail($email, $emailSubject);
    }
    // Redirect after successful update
    header("Location: ../../groupe/".$TypeCreation.".php");
    exit(); // Stop further execution
} catch (PDOException $e) {
    // Handle query errors
    echo "Query failed: " . $e->getMessage();
    exit(); // Stop further execution
}
?>
