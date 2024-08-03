<?php
require("config.php");
require("confirm_login.php");

if (isset($_POST["creatAccount"])) {
    try {
        // Get form data
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $email = $_POST["email"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $TypeCreation = $_POST["TypeCreation"];
        $FixNumber = $_POST["FixNumber"];
        $agent_autorisation = isset($_POST["agent_autorisation"]) ? $_POST["agent_autorisation"] : null;
        $CodeAdmin = $_POST["CodeAdmin"];

        // Connect to the database
        $connection = new PDO($dsn, $db_user, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verify if email exists
        if (verify($email, $connection)) {
            header("Location: ../../Creat.php");
            exit();
        } else {
            // Initialize the second SQL query variable
            $sql2 = "";

            // Insert user data into the appropriate table based on 'TypeCreation'
            if ($TypeCreation === "Agent technique") {
                // Select id of Administration using agent_autorisation
                $sqlSearch = "SELECT id FROM administration WHERE Number_Autorisation = :agent_autorisation";
                $statement = $connection->prepare($sqlSearch);
                $statement->bindParam(":agent_autorisation", $agent_autorisation);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    // Insert user data into the 'user' table
                    $sql1 = "INSERT INTO user (email, password, type) VALUES (:email, :password, :type)";
                    $statement = $connection->prepare($sql1);
                    $statement->bindParam(":email", $email);
                    $statement->bindParam(":password", $password);
                    $statement->bindParam(":type", $TypeCreation);
                    $statement->execute();
                    $user_id = $connection->lastInsertId();
                    $params = [
                        ":first_name" => $firstName,
                        ":last_name" => $lastName,
                        ":fix_number" => $FixNumber,
                        ":user_id" => $user_id,
                        ":id_administration" => $result['id']
                    ];

                    $sql2 = "INSERT INTO agent (first_name, last_name, fax_number, user_id, id_adminstration) VALUES (:first_name, :last_name, :fix_number, :user_id, :id_administration)";
                } else {
                    throw new Exception("No administration found with the provided authorization number.");
                }
            } else if ($CodeAdmin === "22000") {
                // Insert user data into the 'user' table
                $sql1 = "INSERT INTO user (email, password, type) VALUES (:email, :password, :type)";
                $statement = $connection->prepare($sql1);
                $statement->bindParam(":email", $email);
                $statement->bindParam(":password", $password);
                $statement->bindParam(":type", $TypeCreation);
                $statement->execute();
                $user_id = $connection->lastInsertId();
                $params = [
                    ":first_name" => $firstName,
                    ":last_name" => $lastName,
                    ":fix_number" => $FixNumber,
                    ":user_id" => $user_id
                ];

                $sql2 = "INSERT INTO administration (first_name, last_name, fax_number, user_id) VALUES (:first_name, :last_name, :fix_number, :user_id)";
            } else {
                throw new Exception("Invalid TypeCreation or CodeAdmin provided.");
            }

            // Execute the second SQL query
            if (!empty($sql2)) {
                $statement = $connection->prepare($sql2);
                foreach ($params as $key => &$val) {
                    $statement->bindParam($key, $val);
                }
                $statement->execute();

                // Redirect to the login page on success
                header("Location: ../../Login.php");
                exit();
            } else {
                throw new Exception("SQL query for inserting user details is not defined.");
            }
        }
    } catch (PDOException $error) {
        // Display error message
        echo "Database Error: " . $error->getMessage();
    } catch (Exception $error) {
        // Display error message for other exceptions
        echo "Error: " . $error->getMessage();
    }
}
?>
