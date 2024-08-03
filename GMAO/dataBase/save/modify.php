<?php
require("config.php");
session_start();

// Check if user is authenticated
if (!isset($_SESSION["id"]) || !isset($_SESSION["type"])) {
    // Redirect user to login page or show appropriate error message
    header("Location: login.php");
    exit(); // Stop further execution
}

$id = $_SESSION["id"];
echo $id;
$TypeCreation = $_SESSION["type"];

if(isset($_POST["modify"])){
    $email = $_POST["email"];
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];    
    $FixNumber = $_POST["FixNumber"];
    try {
        $connection = new PDO($dsn, $db_user, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($TypeCreation === "Agent technique"){
            $sql1 = "UPDATE agent SET first_name=:first_name, last_name=:last_name, fax_number=:fix_number WHERE user_id=:id";
        } elseif($TypeCreation==="Administration") {
            $Number_autorisation = $_POST["Number_autorisation"];
            $sql1 = "UPDATE administration SET Number_Autorisation=:Number_Autorisation, first_name=:first_name, last_name=:last_name, fax_number=:fix_number WHERE user_id=:id";  
        }elseif($TypeCreation==="Maintenance"){
            $sql1="UPDATE maintenance SET first_name=:first_name, last_name=:last_name, fax_number=:fix_number WHERE user_id=:id ";
        }elseif($TypeCreation==="Production"){
            $sql1="UPDATE production SET first_name=:first_name, last_name=:last_name,  fax_number=:fix_number  WHERE user_id=:id ";
        }
        $statement = $connection->prepare($sql1);
        if($TypeCreation==="Administration"){
            $statement->bindValue(":Number_Autorisation", $Number_autorisation);
        }
        $statement->bindValue(":first_name", $firstName);
        $statement->bindValue(":last_name", $lastName);
        $statement->bindValue(":fix_number", $FixNumber);
        $statement->bindValue(":id", $id);
        $statement->execute();

        $sql2 = "UPDATE user SET email=:email WHERE id=:id";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":id", $id);
        $statement->execute();

        // Update session variables with new email and password
        $_SESSION["email"] = $email;

        // Redirect user after successful modification
        if($TypeCreation === "Administration"){
            header("Location: ../../Administration.php");
        } else { 
            header("Location: ../../profile.php");
        }
        exit(); // Stop further execution
    } catch(PDOException $error) {
        // Handle database errors
        echo "Error: " . $error->getMessage();
    }
}
?>
