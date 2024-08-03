<?php
require("config.php");
require("../../Email/SendMail.php");
if (
    isset($_POST["id_production"]) &&
    isset($_POST["numero"]) &&
    isset($_POST["date"]) &&
    isset($_POST["ref"]) &&
    isset($_POST["danger-level"]) &&
    isset($_POST["equipment-type"]) &&
    isset($_POST["subsidiary"]) &&
    isset($_POST["line"]) &&
    isset($_POST["equipment"]) &&
    isset($_POST["name-Agent"]) &&
    isset($_POST["intervention-type"]) &&
    isset($_POST["id_mantineance"]) &&
    isset($_POST["id_adminstration"]) &&
    isset($_POST["id_Agent"])
) {
    // Example of splitting the value back into an array
$array=explode(",", $_POST['id_mantineance']) ;
    // Declare variables for each POST parameter
    $nameAgent = $_POST["name-Agent"];
    $productionId = $_POST["id_production"];
    $mantineanceId = $array[0];
    $idAgent = $_POST["id_Agent"];
    $id_adminstration = $_POST["id_adminstration"];
    $numero = $_POST["numero"];
    $date = $_POST["date"];
    $ref = $_POST["ref"];
    $interventionType = $_POST["intervention-type"];
    $preventiveType = $_POST["preventive-type"];
    $dangerLevel = $_POST["danger-level"];
    $equipmentType = $_POST["equipment-type"];
    $subsidiary = $_POST["subsidiary"];
    $line = $_POST["line"];
    $equipment = $_POST["equipment"];

    // Connect to the database
    $connection = new PDO($dsn, $db_user, $db_password);
    $sql = "INSERT INTO `formulaire`(`number_of_formulaire`, `name_agent`, `type_formulaire`, `date_agent`, `ref`, `type_intervention`, `type_preventive`, `levels_danger`, `type_probleme`, `subsidiary`, `line`, `equipment`, `maintenance_id`, `production_id`,`administration_id`, `agent_id`) 
            VALUES (:numero, :name_agent, 'Agent', :date_agent, :ref, :type_intervention, :type_preventive, :levels_danger, :type_probleme, :subsidiary, :line, :equipment, :maintenance_id, :production_id, :id_adminstration,:id_Agent)";

    // Prepare the SQL statement
    $statement = $connection->prepare($sql);

    // Bind parameters
    $statement->bindParam(':numero', $numero);
    $statement->bindParam(':name_agent', $nameAgent);
    $statement->bindParam(':date_agent', $date);
    $statement->bindParam(':ref', $ref);
    $statement->bindParam(':type_intervention', $interventionType);
    $statement->bindParam(':type_preventive', $preventiveType);
    $statement->bindParam(':levels_danger', $dangerLevel);
    $statement->bindParam(':type_probleme', $equipmentType);
    $statement->bindParam(':subsidiary', $subsidiary);
    $statement->bindParam(':line', $line);
    $statement->bindParam(':equipment', $equipment);
    $statement->bindParam(':production_id', $productionId);
    $statement->bindParam(':maintenance_id', $mantineanceId);
    $statement->bindParam(':id_Agent', $idAgent);
    $statement->bindParam(':id_adminstration', $id_adminstration);

    // Execute the statement
    $statement->execute();
    $email=$array[1];
    SendMail($email,"request for Intervention from Agent ".$nameAgent);
}

header("Location: ../../Agent.php");
?>
