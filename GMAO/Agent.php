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
       //Name Agent
       $sql3 = "SELECT first_name, last_name,id,id_adminstration FROM agent WHERE user_id = :id";
       $statement = $connection->prepare($sql3);
       $statement->bindParam(':id', $id, PDO::PARAM_INT);
       $statement->execute();
       $resultName = $statement->fetch(PDO::FETCH_ASSOC);
       $FName = $resultName["first_name"];
       $LName = $resultName["last_name"];
       $idAgent= $resultName["id"];
       $id_adminstration= $resultName["id_adminstration"];
       
    //id Production
    $sql = "SELECT * FROM `production` WHERE administration_id =:administration_id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":administration_id",$id_adminstration);
    $statement->execute();
    $result = $statement->fetchAll();
    //id Mantineance
    $sql2 = "SELECT * FROM  user JOIN maintenance  ON maintenance.user_id = user.id WHERE maintenance.administration_id = :id;";
    $statement = $connection->prepare($sql2);
    $statement->bindValue(":id",$id_adminstration);
    $statement->execute();
    $resultMantineance = $statement->fetchAll();

}

$id_production = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_production"])) {
    $id_production = $_POST["id_production"];
    
    // Fetch the count of production records for the selected ID
    $connection = new PDO($dsn, $db_user, $db_password);
    $sqlCount = "SELECT COUNT(id) AS production_count FROM formulaire WHERE production_id= :id;";
    $statement = $connection->prepare($sqlCount);
    $statement->bindValue(":id", $id_production);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    echo $row["production_count"];
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--FILE CSS-->
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/agent.css">
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
    <title>Document</title>
</head>
<body>
    <div class="header" id="header">
        <div class="container">
            <div class="image"><img src="Image/b74c8225-fb57-4667-adec-539a1f5ebfe1-removebg-preview.png"/><h3><a>G M A O</a></h3></div>
            <div class="links">
            <ul class="link">
                <li><a href="Agent.php" class="active">Request For Intervention</a></li>
            </ul>
            <ul class="link_2">
                <li><a href="profile.php">
                    <div class="profile">
                        <div class="icon" style="text-align: center;">
                            <img src="Image/account_circle_FILL0_wght400_GRAD0_opsz24.png" alt="">
                        </div>
                        <p style="margin: 0;">Profile</p>
                    </div>
                </a></li>
                <li>
                    <a href="Login.php">
                        <div class="logout">
                            <div class="icon" style="text-align: center;">
                                <img src="Image/logout_FILL0_wght400_GRAD0_opsz24.png" alt="">
                            </div>
                            <p style="margin: 0;">Logout</p>
                        </div>
                    </a>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <div class="information active">
        <div class="info" class="title">
            <h2>Request For Intervention:</h2>
        </div>
        <form action="" method="post">
            <input type="hidden" name="name-Agent" value="<?php echo $FName." ".$LName;?>">
            <input type="hidden" name="id_Agent" value="<?php echo $idAgen;?>">
            <input type="hidden" name="id_adminstration" value="<?php echo $id_adminstration;?>">
            
            <div class="box" style="width:50%">
                <div class="info">
                    <div class="info-2">
                        <label for="type">Maintenance:</label>
                        <select name="id_mantineance" id="mantineance-id">
                            <option value="">...</option>
                            <?php foreach ($resultMantineance as $row): ?>
                                <option value="<?= $row['id'] . ' ,' . $row['email'] ?>  "><?= $row["first_name"] . " " . $row["last_name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="type">Production:</label>
                        <select name="id_production" id="production-id">
                            <option value="">...</option>
                            <?php foreach ($result as $row): ?>
                                <option value="<?= $row["id"] ?>"><?= $row["first_name"] . " " . $row["last_name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="numero">Numero:</label>
                        <input type="number" id="selected-id-display" name="numero" >
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="date">DATE/HOUR(Agent):</label>
                        <input type="datetime-local" id="date" name="date">
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="ref">REF:</label>
                        <input type="number" id="ref" name="ref">
                    </div>
                </div>
                <div class="info ">
                    <div class="info-2">
                        <label for="intervention-type">Type of Intervention:</label>
                        <select name="intervention-type" id="intervention-type">
                            <option value="">...</option>
                            <option value="preventive">Preventive</option>
                            <option value="systematic">Systematic</option>
                            <option value="curative">Curative</option>
                        </select>
                    </div>
                </div>
                <div class="info prev " id="info_prev">
                    <div class="info-2">
                        <label for="preventive-type">Type of Preventive:</label>
                        <select name="preventive-type" id="preventive-type">
                            <option value="">...</option>
                            <option value="Working hours">Working Hours</option>
                            <option value="Date">Date</option>
                            <option value="Production Quantity">Production Quantity</option>
                        </select>
                    </div>
                </div>
                <div class="info curative " id="info_curative">
                    <div class="info-2">
                        <label for="danger-level">Levels of Danger:</label>
                        <select name="danger-level" id="danger-level">
                            <option value="">...</option>
                            <option value="Risk">Risk</option>
                            <option value="Hazard">Hazard</option>
                            <option value="Peril">Peril</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="box" style="width:50%">
                <div class="info">
                    <div class="info-2">
                        <label for="equipment-type">Type:</label>
                        <select name="equipment-type" id="equipment-type">
                            <option value="">...</option>
                            <option value="Mechanical">Mechanical</option>
                            <option value="Electric">electric</option>
                            <option value="Hydraulic">hydraulic</option>
                            <option value="Informatique">Informatique</option>
                        </select>
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="subsidiary">Subsidiary:</label>
                        <select name="subsidiary" id="subsidiary">
                            <option value="">...</option>
                            <option value="subsidiary-A">subsidiary-A</option>
                            <option value="subsidiary-B">subsidiary-B</option>
                            <option value="subsidiary-C">subsidiary-C</option>
                        </select>
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="line">Line:</label>
                        <select name="line" id="line">
                            <option value="">...</option>
                            <option value="line-1">line-1</option>
                            <option value="line-2">line-2</option>
                            <option value="line-3">line-3</option>
                        </select>
                    </div>
                </div>
                <div class="info">
                    <div class="info-2">
                        <label for="equipment">Equipment:</label>
                        <select name="equipment" id="equipment">
                            <option value="">...</option>
                            <option value="equipment-A">equipment-A</option>
                            <option value="equipment-B">equipment-B</option>
                            <option value="equipment-C">equipment-C</option>
                            <option value="equipment-D">equipment-D</option>
                            <option value="equipment-E">equipment-E</option>
                            <option value="equipment-F">equipment-F</option>
                        </select>
                    </div>
                </div>
                <div class="info">
                    <input type="submit" value="send" name="send" formaction="./dataBase/save/FormulairAgent.php">
                </div>
            </div>
        </form>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // Code for setting the current date and time
        const dateInput = document.getElementById("date");
const time = new Date();
const year = time.getFullYear();
const month = String(time.getMonth() + 1).padStart(2, '0'); // Months are zero indexed
const day = String(time.getDate()).padStart(2, '0');
const hours = String(time.getHours()).padStart(2, '0');
const minutes = String(time.getMinutes()).padStart(2, '0');
const formattedTime = `${year}-${month}-${day}T${hours}:${minutes}`;
dateInput.value = formattedTime;


        // Existing code for handling other functionalities...
        const select = document.getElementById("production-id");
        const selectedIdDisplay = document.getElementById("selected-id-display");

        select.addEventListener("change", function() {
            var id_production = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    selectedIdDisplay.value = Number(xhr.responseText)+1;
                }
            };
            xhr.send("id_production=" + id_production);
        });

        const selectType = document.getElementById("intervention-type");
        const prevInfo = document.getElementById("info_prev");
        const curativeInfo = document.getElementById("info_curative");

        selectType.addEventListener("change", function() {
            if (selectType.value === "" || selectType.value === "systematic") {
                prevInfo.classList.remove("active");
                curativeInfo.classList.remove("active");
            } else if (selectType.value === "preventive") {
                prevInfo.classList.add("active");
                curativeInfo.classList.remove("active");
            } else if (selectType.value === "curative") {
                prevInfo.classList.remove("active");
                curativeInfo.classList.add("active");
            }
        });
    });


</script>
</html>
