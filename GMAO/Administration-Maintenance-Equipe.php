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

    $sql2 = "SELECT * FROM `maintenance` WHERE administration_id=:id";
    $statement = $connection->prepare($sql2);
    $statement->bindValue(":id", $id_administration);
    $statement->execute();
    $result = $statement->fetchAll();

    $sql3 = "SELECT * FROM equipe WHERE maintenance_administration_id=:id";
    $statement = $connection->prepare($sql3);
    $statement->bindValue(":id", $id_administration);
    $statement->execute();
    $result_equipe = $statement->fetchAll();
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
    <!-- Header -->
    <div class="conatiner"  style="width:100%;
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
    <!-- Secondary Header -->
    <div class="header-2" id="header">
        <div class="container">
            <ul class="link2">
                <li><a href="Administration-Maintenance-Creat.php" >Creat Maintenance</a></li>
                <li><a href="Administration-Maintenance.php" >List</a></li>
                <li><a href="Administration-Maintenance-Equipe.php" class="active">Teams-List</a></li>
            </ul>
        </div>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>First Name of Maintenance Director</th>
                <th>Last Name of Maintenance Director</th>
                <th> Name of Department boss of Mechanical</th>
                <th>Name of Department boss of Electric</th>
                <th>Name of Department boss of Hydraulic</th>
                <th>Name of Department boss of Informatique</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($result as $row): ?>
        <form action="./dataBase/save/modifyMaintenanceEquipe.php" method="post">
    <input type="hidden" name="id_maintenance" value="<?= $row["id"] ?>">
    <tr>
        <td><input type="text" class="name" name="FirstName" value="<?= $row["first_name"] ?? "" ?>"></td>
        <td><input type="text" class="name" name="LastName" value="<?= $row["last_name"] ?? "" ?>"></td>
        <td>
            <select name="mechanical">
                <option value="">...</option>
                <?php foreach ($result_equipe as $row_equipe): ?>
                    <?php if ($row_equipe["type"] === "Mechanical"): ?>
                        <?php if ($row_equipe["maintenance_id"] === 0): ?>
                            <option value="<?= $row_equipe["id"] ?>">
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php elseif ($row_equipe["maintenance_id"] === $row["id"]): ?>
                            <option value="<?= $row_equipe["id"] ?>" selected>
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select name="electric">
                <option value="">...</option>
                <?php foreach ($result_equipe as $row_equipe): ?>
                    <?php if ($row_equipe["type"] === "Electric"): ?>
                        <?php if ($row_equipe["maintenance_id"] === 0): ?>
                            <option value="<?= $row_equipe["id"] ?>">
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php elseif ($row_equipe["maintenance_id"] === $row["id"]): ?>
                            <option value="<?= $row_equipe["id"] ?>" selected>
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select name="hydraulic">
                <option value="">...</option>
                <?php foreach ($result_equipe as $row_equipe): ?>
                    <?php if ($row_equipe["type"] === "Hydraulic"): ?>
                        <?php if ($row_equipe["maintenance_id"] === 0): ?>
                            <option value="<?= $row_equipe["id"] ?>">
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php elseif ($row_equipe["maintenance_id"] === $row["id"]): ?>
                            <option value="<?= $row_equipe["id"] ?>" selected>
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select name="informatique">
                <option value="">...</option>
                <?php foreach ($result_equipe as $row_equipe): ?>
                    <?php if ($row_equipe["type"] === "Informatique"): ?>
                        <?php if ($row_equipe["maintenance_id"] === 0): ?>
                            <option value="<?= $row_equipe["id"] ?>">
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php elseif ($row_equipe["maintenance_id"] === $row["id"]): ?>
                            <option value="<?= $row_equipe["id"] ?>" selected>
                                <?= $row_equipe["name_boss"] ?> 
                            </option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </td>
        <input type="hidden" name="Number" value="<?= $row["id"] ?>">
        <td>
            <button type="submit" name="modify" style="color:#ffc720"><i class="fa-solid fa-pen" ></i></button>
        </td>
    </tr>
</form>

    <?php endforeach; ?>
</tbody>
    </table>
    </div>
    </div>

    <!-- Script -->
    <script>

    </script>

</body>
</html>
