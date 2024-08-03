<?php
require("config.php");
session_start();
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
$password = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
$TypeCreation = isset($_SESSION["type"]) ? $_SESSION["type"] : "";
$result = [];

if ($id !== "") {
    $connection = new PDO($dsn, $db_user, $db_password);
    if ($TypeCreation === "Agent technique") {
        $sql = "SELECT * FROM  user JOIN agent  ON agent.user_id=user.id WHERE user_id=:id";
    } elseif ($TypeCreation === "Maintenance") {
        $sql = "SELECT * FROM  user JOIN maintenance  ON maintenance.user_id=user.id WHERE user_id=:id";
    } elseif ($TypeCreation === "Production") {
        $sql = "SELECT * FROM  user JOIN production ON production.user_id=user.id WHERE user_id=:id";
    }
    $statement = $connection->prepare($sql);
    $statement->bindValue(":id", $id);
    $statement->execute();
    $result = $statement->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Your existing CSS links -->
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/Profile.css">
    <link rel="stylesheet" href="./css/all.min.css">
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
            <img src="Image/b74c8225-fb57-4667-adec-539a1f5ebfe1-removebg-preview.png"/>
            <h3><a>G M A O</a></h3>
        </div>
        <div class="links">
            <ul class="link">
                <li><a href="<?php echo $TypeCreation === "Agent technique" ? "Agent" : $TypeCreation; ?>.php">Request For Intervention</a></li>
            </ul>
            <ul class="link_2">
                <li>
                    <a href="profile.php">
                        <div class="profile">
                            <div class="icon" style="text-align: center;">
                                <img src="Image/account_circle_FILL0_wght400_GRAD0_opsz24.png" alt="">
                            </div>
                            <p style="margin: 0;">Profile</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="Login.php">
                        <div class="logout">
                            <div class="icon" style="text-align: center;">
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
<div class="information">
    <form action="" method="post" id="profileForm">
        <div class="info" class="title">
            <h2>Profile:</h2>
        </div>
        <?php foreach ($result as $row): ?>
            <div class="info">
                <div class="info-2">
                    <label for="">First Name:</label>
                    <input type="text" name="FirstName" class="name" value="<?php echo $row["first_name"] ?? "" ?>">
                </div>
            </div>
            <div class="info">
                <div class="info-2">
                    <label for="">Last Name:</label>
                    <input type="text" name="LastName" class="name" value="<?php echo $row["last_name"] ?? "" ?>">
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
                <input type="submit" value="Save" name="modify" formaction="dataBase/save/modify.php">
            </div>
        <?php endforeach; ?>
    </form>
    <div class="image">
        <img src="Image/Agent-de-maintenance-4-07-500x0-c-default.png" alt="">
    </div>
</div>

<!-- Add JavaScript for form validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('profileForm').addEventListener('submit', function(event) {
        var firstName = document.querySelector('input[name="FirstName"]').value.trim();
        var lastName = document.querySelector('input[name="LastName"]').value.trim();
        var email = document.querySelector('input[name="email"]').value.trim();
        var password = document.querySelector('input[name="password"]').value.trim();
        var fixNumber = document.querySelector('input[name="FixNumber"]').value.trim();

        // Regular expressions for validation
        var nameRegex = /^[a-zA-Z]+$/; // Alphabetic characters only
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passwordRegex = /^.{8,}$/; // Minimum 8 characters
        var numberRegex = /^\d+$/; // Numbers only

        // Validation checks
        if (!nameRegex.test(firstName)) {
            alert('First Name should only contain alphabetic characters');
            event.preventDefault(); // Prevent form submission
        }

        if (!nameRegex.test(lastName)) {
            alert('Last Name should only contain alphabetic characters');
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
