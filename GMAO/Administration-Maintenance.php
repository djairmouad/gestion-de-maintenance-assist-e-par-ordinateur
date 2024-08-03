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
    $sql1 = "SELECT id FROM administration WHERE user_id=:user_id";
    $statement = $connection->prepare($sql1);
    $statement->bindValue(":user_id", $id);
    $statement->execute();
    $id_administration = $statement->fetchColumn();
    $sql2 = "SELECT * FROM  user JOIN maintenance  ON maintenance.user_id = user.id WHERE maintenance.administration_id = :id;";
    $statement = $connection->prepare($sql2);
    $statement->bindValue(":id", $id_administration);
    $statement->execute();
    $result = $statement->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--FILE CSS-->
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/adminstrationMaintenance.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <!-- google icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&family=Inknut+Antiqua:wght@700&family=Open+Sans:wght@300&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/c30097efd5.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
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
                <li><a href="Administration-Maintenance.php" class="active">Maintenance</a></li>
                <li><a href="Administration-Equipe.php" >Team</a></li>
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
                <li><a href="Administration-Maintenance-Creat.php">Creat Maintenance</a></li>
                <li><a href="Administration-Maintenance.php"  class="active">List</a></li>
                <li><a href="Administration-Maintenance-Equipe.php" >Teams-List</a></li>
            </ul>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gmail</th>
                <th>Fix-Number</th>
                <th>Action</th>
            </tr>
        </thead>
    <tbody>
    <?php foreach ($result as $row) { ?>
        <form action="" method="post">
                <tr>
                    <td><input type="text" class="name" name="FirstName" value="<?php echo $row["first_name"] ?? ""; ?>"></td>
                    <td><input type="text" class="name" name="LastName" value="<?php echo $row["last_name"] ?? ""; ?>"></td>
                    <td><input type="email" name="email" id="" value="<?php echo $row["email"] ?? ""; ?>"></td>
                    <td><input type="text" name="FixNumber" id="FixNumber" value="<?php echo $row["fax_number"] ?? ""; ?>" /></td>
                    <input type="hidden" name="Number" value="<?php echo $row["id"]; ?>">
                    <input type="hidden" name="id_user" value="<?= $row["user_id"] ?>">
                    <td>
                        <button name="modify" formaction="./dataBase/save/modifyMaintenance.php"><i class="fa-solid fa-pen"></i></button>
                         <button name="delete" formaction="./dataBase/save/deleteMaintenance.php"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
         </form>
    <?php } ?>
    </tbody>
    </table>
    </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').addEventListener('submit', function(event) {
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
