<?php
require("../config.php");
session_start();
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
$password = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
$TypeCreation = isset($_SESSION["type"]) ? $_SESSION["type"] : "";
$result = [];

if ($id !== "") {
    $connection = new PDO($dsn, $db_user, $db_password);
    if ($TypeCreation === "Hydraulic" || $TypeCreation === "Electric" || $TypeCreation === "Informatique" || $TypeCreation === "Mechanical") {
        $sql="SELECT * FROM  user JOIN equipe  ON equipe.user_id=user.id WHERE user_id=:id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--FILE CSS-->
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/Profile.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- Google icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&family=Inknut+Antiqua:wght@700&family=Open+Sans:wght@300&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="header" id="header">
    <div class="container">
        <div class="image">
            <img src="../Image/b74c8225-fb57-4667-adec-539a1f5ebfe1-removebg-preview.png"/>
            <h3><a>G M A O</a></h3>
        </div>
        <div class="links">
            <ul class="link">
                <li><a href="<?php echo $TypeCreation ?>.php">Request For Intervention</a></li>
            </ul>
            <ul class="link_2">
                <li>
                    <a href="profileEquipe.php">
                        <div class="profile">
                            <div class="icon" style="text-align: center;">
                                <img src="../Image/account_circle_FILL0_wght400_GRAD0_opsz24.png" alt="">
                            </div>
                            <p style="margin: 0;">Profile</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="../Login.php">
                        <div class="logout">
                            <div class="icon" style="text-align: center;">
                                <img src="../Image/logout_FILL0_wght400_GRAD0_opsz24.png" alt="">
                            </div>
                            <p style="margin: 0;">Logout</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="information">
    <form id="profileForm" action="" method="post">
        <div class="info" class="title">
            <h2>Profile:</h2>
        </div>
        <?php foreach ($result as $row): ?>
            <input type="hidden" name="id_user" value="<?php echo $row["user_id"] ?>">
            <input type="hidden" name="id_equipe" value="<?php echo $row["id"] ?>">
            <div class="info">
                <div class="info-2">
                    <select id="type" name="type">
                        <option value="">...</option>
                        <option value="Mechanical" <?= ($row["type"] === "Mechanical") ? "selected" : "" ?>>Mechanical</option>
                        <option value="Electric" <?= ($row["type"] === "Electric") ? "selected" : "" ?>>Electric</option>
                        <option value="Hydraulic" <?= ($row["type"] === "Hydraulic") ? "selected" : "" ?>>Hydraulic</option>
                        <option value="Informatique" <?= ($row["type"] === "Informatique") ? "selected" : "" ?>>Informatique</option>
                    </select>
                </div>
            </div>
            <div class="info">
                <div class="info-2">
                    <label for="">Name Boss:</label>
                    <input type="text" name="FirstName" class="name" value="<?php echo $row["name_boss"] ?? "" ?>">
                </div>
            </div>
            <div class="info">
                <div class="info-2">
                    <label for="">Email:</label>
                    <input type="email" name="email" id="" value="<?php echo $row["email"] ?? "" ?>">
                </div>
            </div>
            <div class="info">
                <div class="info-2">
                    <label for="">Fix-Number:</label>
                    <input type="text" name="FixNumber" value="<?php echo $row["fax_number"] ?? "" ?>">
                </div>
            </div>
            <div class="info">
                <input type="submit" value="Save" name="modify" formaction="../dataBase/save/modifyOneofEquipe.php">
            </div>
        <?php endforeach; ?>
    </form>
    <div class="image">
        <img src="../Image/Agent-de-maintenance-4-07-500x0-c-default.png" alt="">
    </div>
</div>
<script>
    document.getElementById('profileForm').addEventListener('submit', function (event) {
        var type = document.querySelector('select[name="type"]').value;
        var firstName = document.querySelector('input[name="FirstName"]').value.trim();
        var email = document.querySelector('input[name="email"]').value.trim();
        var password = document.querySelector('input[name="password"]').value.trim();
        var fixNumber = document.querySelector('input[name="FixNumber"]').value.trim();
        var nameBoss = document.querySelector('input[name="FirstName"]').value.trim();

        // Regular expression for email validation
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        // Regular expression for checking if name has numbers
        var namePattern = /^[a-zA-Z\s]*$/;

        // Check if all fields are filled and meet validation criteria
        if (!type || !firstName || !email || !password || !fixNumber) {
            alert('Please fill in all fields.');
            event.preventDefault();
            return;
        }

        // Check if password has at least 8 characters
        if (password.length < 8) {
            alert('Password must be at least 8 characters long.');
            event.preventDefault();
            return;
        }

        // Check if email format is valid
        if (!email.match(emailPattern)) {
            alert('Please enter a valid email address.');
            event.preventDefault();
            return;
        }

        // Check if Name Boss contains numbers
        if (!nameBoss.match(namePattern)) {
            alert('Name Boss should not contain numbers.');
            event.preventDefault();
            return;
        }
    });
</script>
</body>
</html>
