<?php
require("config.php");
session_start();
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
$password = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
$TypeCreation = isset($_SESSION["type"]) ? $_SESSION["type"] : "";
$result = [];

// if ($id !== "") {
//     $connection = new PDO($dsn, $db_user, $db_password);
//     $sql1 = "SELECT id FROM administration WHERE user_id=:user_id";
//     $statement = $connection->prepare($sql1);
//     $statement->bindValue(":user_id", $id);
//     $statement->execute();
//     $id_administration = $statement->fetchColumn();

//     $sql2 = "SELECT * FROM `maintenance` WHERE administration_id=:id";
//     $statement = $connection->prepare($sql2);
//     $statement->bindValue(":id", $id_administration);
//     $statement->execute();
//     $result = $statement->fetchAll();

//     $sql3 = "SELECT * FROM equipe WHERE maintenance_administration_id=:id";
//     $statement = $connection->prepare($sql3);
//     $statement->bindValue(":id", $id_administration);
//     $statement->execute();
//     $result_equipe = $statement->fetchAll();
// }

if(isset($_POST["modify"])) {
    $id_maintenance = $_POST["id_maintenance"];

    try {
        $connection = new PDO($dsn, $db_user, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $connection->beginTransaction();

        // Remove maintenance_id from the previous values
        $sqlRemove = "UPDATE equipe SET maintenance_id = NULL WHERE maintenance_id = :maintenance_id";
        $statementRemove = $connection->prepare($sqlRemove);
        $statementRemove->bindValue(":maintenance_id", $id_maintenance);
        $statementRemove->execute();

        // Update maintenance_id for the new values
        $sqlUpdate = "UPDATE equipe SET maintenance_id = :maintenance_id WHERE id IN (:mechanical, :electric, :hydraulic, :informatique)";
        $statementUpdate = $connection->prepare($sqlUpdate);
        $statementUpdate->bindValue(":maintenance_id", $id_maintenance);
        $statementUpdate->bindValue(":mechanical", $_POST["mechanical"]);
        $statementUpdate->bindValue(":electric", $_POST["electric"]);
        $statementUpdate->bindValue(":hydraulic", $_POST["hydraulic"]);
        $statementUpdate->bindValue(":informatique", $_POST["informatique"]);
        $statementUpdate->execute();

        $connection->commit();

        // Redirect after successful modification
        header("Location: ../../Administration-Maintenance-Equipe.php");
        exit();
    } catch (PDOException $e) {
        if ($connection && $connection->inTransaction()) {
            $connection->rollBack();
        }
        echo "Error: " . $e->getMessage();
    }
}
?>
