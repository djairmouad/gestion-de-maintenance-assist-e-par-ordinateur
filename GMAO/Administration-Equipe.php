<?php
require("config.php");
session_start();

// Initialize variables
$email = $_SESSION["email"] ?? "";
$password = $_SESSION["password"] ?? "";
$id = $_SESSION["id"] ?? "";
$TypeCreation = $_SESSION["type"] ?? "";
$result = [];

try {
    // Database connection
    $connection = new PDO($dsn, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve administration ID if available
    if (!empty($id)) {
        $sql1 = "SELECT id FROM administration WHERE user_id = :user_id";
        $statement = $connection->prepare($sql1);
        $statement->bindValue(":user_id", $id);
        $statement->execute();
        $id_administration = $statement->fetchColumn();
    }

    // Fetch data from the database
    if (!empty($id_administration)) {
        $sql2="SELECT * FROM  user JOIN equipe  ON equipe.user_id=user.id WHERE maintenance_administration_id = :maintenance_administration_id";
        $statement = $connection->prepare($sql2);
        $statement->bindValue(":maintenance_administration_id", $id_administration);
        $statement->execute();
        $result = $statement->fetchAll();
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe Management</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/adminstrationMaintenance.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&family=Inknut+Antiqua:wght@700&family=Open+Sans:wght@300&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol:wght@400;500;700&display=swap" rel="stylesheet">
    <!--FontsAwsom-->
    <script src="https://kit.fontawesome.com/c30097efd5.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Header -->
    <div class="conatiner"  style="width: 100%;
    height: 97vh;
    display: flex;
    padding:0;
    justify-content: space-between;
    ">
    <div class="header" id="header">
        <div class="container">
            <div class="image"><img src="Image/b74c8225-fb57-4667-adec-539a1f5ebfe1-removebg-preview.png"/><h3><a>G M A O</a></h3></div>
            <div class="links">
            <ul class="link">
                <li><a href="Administration.php">Administration</a></li>
                <li><a href="Administration-Maintenance.php" >Maintenance</a></li>
                <li><a href="Administration-Equipe.php"class="active">Team</a></li>
                <li><a href="Administration-Production.php">Production</a></li>
                <li><a href="chart.php">statistics</a></li>
            </ul>
            <ul class="link_2">
                <li>
                    <a href="Login.php">
                        <div class="logout">
                            <div class="icon" style="text-align: center; font-size: 14px; margin-top: 9px;">
                                <img src="Image/logout_FILL0_wght400_GRAD0_opsz24.png" alt="">
                            </div>
                            <p style="margin: 0;" class="logout">Logout</p>
                        </div>
                    </a>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <div class="AllInformation">
    <div class="header-2" id="header">
        <div class="container">
            <ul class="link2">
                <li><a href="Administration-Equipe-Creat.php" >Create Team</a></li>
                <li><a href="Administration-Equipe.php" class="active" >List</a></li>
            </ul>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Name of Department boss</th>
                <th>Gmail</th>
                <th>Fix-Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) : ?>
                <form action="" method="post">
                <input type="hidden" name="id_equipe" value="<?= $row["id"] ?>">
                <input type="hidden" name="id_user" value="<?= $row["user_id"] ?>">
                <tr>
                    <td>
                        <select id="type" name="type">
                            <option value="">...</option>
                            <option value="Mechanical" <?= ($row["type"] === "Mechanical") ? "selected" : "" ?>>Mechanical</option>
                            <option value="Electric" <?= ($row["type"] === "Electric") ? "selected" : "" ?>>Electric</option>
                            <option value="Hydraulic" <?= ($row["type"] === "Hydraulic") ? "selected" : "" ?>>Hydraulic</option>
                            <option value="Informatique" <?= ($row["type"] === "Informatique") ? "selected" : "" ?>>Informatique</option>
                        </select>
                    </td>
                    <td><input type="text" name="firstName"  value="<?= $row["name_boss"] ?>"></td>
                    <td><input type="text" name="email" value="<?= $row["email"] ?>"></td>
                    <td><input type="number" name="fixNumber" value="<?= $row["fax_number"] ?>"></td>
                    <td >
                    <button name="modify" formaction="./dataBase/save/modifyEquipe.php"><i class="fa-solid fa-pen"></i></button>
                    <button name="delete"  formaction="./dataBase/save/deleteEquipe.php"><i class="fa-solid fa-trash"></i></button>
                </td> <!-- Adjust this column as needed -->
                </tr>
        
        </form>
        <?php 
        endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').addEventListener('submit', function(event) {
        var type = document.querySelector('select[name="type"]').value.trim();
        var firstName = document.querySelector('input[name="firstName"]').value.trim();
        var email = document.querySelector('input[name="email"]').value.trim();
        var password = document.querySelector('input[name="password"]').value.trim();
        var fixNumber = document.querySelector('input[name="fixNumber"]').value.trim();

        // Regular expressions for validation
        var nameRegex = /^[a-zA-Z]+$/; // Alphabetic characters only
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passwordRegex = /^.{8,}$/; // Minimum 8 characters
        var numberRegex = /^\d+$/; // Numbers only

        // Validation checks
        if (type === "") {
            alert('Please select a Type');
            event.preventDefault(); // Prevent form submission
        }

        if (!nameRegex.test(firstName)) {
            alert('Name should only contain alphabetic characters');
            event.preventDefault(); // Prevent form submission
        }

        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address');
            event.preventDefault(); // Prevent form submission
        }

        if (!passwordRegex.test(password)) {
            alert('Password should have a minimum length of 8 characters');
            event.preventDefault(); // Prevent form submission
        }

        if (!numberRegex.test(fixNumber)) {
            alert('Fix-Number should only contain numbers');
            event.preventDefault(); // Prevent form submission
        }
    });
});
</script>

</body>
</html>
