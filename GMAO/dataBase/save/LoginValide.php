<?php
require("config.php");
session_start();

if(isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    try {
        $connection = new PDO($dsn, $db_user, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql1 = "SELECT * FROM user WHERE email = :email";
        $statement = $connection->prepare($sql1);
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result && password_verify($password, $result['password'])){
            $id = $result["id"];
            $email = $result["email"];
            $TypeCreation = $result["type"];
            
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;
            $_SESSION["type"] = $TypeCreation;

            switch($TypeCreation){
                case "Agent technique":
                    header("Location: ../../Agent.php");
                    break;
                case "Administration":
                    header("Location: ../../Administration.php");
                    break;
                case "Maintenance":
                    header("Location: ../../Maintenance.php");
                    break;
                case "Production":
                    header("Location: ../../Production.php");
                    break;
                case "Electric":
                    header("Location: ../../groupe/Electric.php");
                    break;
                case "Hydraulic":
                    header("Location: ../../groupe/Hydraulic.php");
                    break;
                case "Mechanical":
                    header("Location: ../../groupe/Mechanical.php");
                    break;
                case "Informatique":
                    header("Location: ../../groupe/Informatique.php");
                    break;
                default:
                    header("Location: ../../Login.php");
            }
        } else {
            header("Location: ../../Login.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
