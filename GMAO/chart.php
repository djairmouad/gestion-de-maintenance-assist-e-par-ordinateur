<?php
require("config.php");
session_start();
$id_user = $_SESSION["id"];
$connection = new PDO($dsn, $db_user, $db_password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $sql="SELECT * FROM administration WHERE user_id=:user_id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":user_id", $id_user, PDO::PARAM_INT);
    $statement->execute();
    $result_id = $statement->fetch(PDO::FETCH_ASSOC);
    
    $id=$result_id["id"];

    $sql1 = "SELECT (SELECT COUNT(id) FROM agent WHERE id_adminstration =:id) AS agentCount, (SELECT COUNT(id) FROM maintenance WHERE administration_id =:id) AS maintenanceCount, (SELECT COUNT(id) FROM production WHERE administration_id =:id) AS productionCount, (SELECT COUNT(id) FROM equipe WHERE maintenance_administration_id =:id) AS equipeCount, COUNT(DISTINCT CASE WHEN type = 'Mechanical' THEN id END) AS MechanicalCount, COUNT(DISTINCT CASE WHEN type = 'Informatique' THEN id END) AS InformatiqueCount, COUNT(DISTINCT CASE WHEN type = 'Hydraulic' THEN id END) AS HydraulicCount, COUNT(DISTINCT CASE WHEN type = 'Electric' THEN id END) AS ElectricCount FROM equipe WHERE maintenance_administration_id =:id";


    $statement = $connection->prepare($sql1);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    
    $sql2 = "SELECT
    (SELECT COUNT(*) FROM formulaire WHERE JSON_CONTAINS(type_probleme, '\"Mechanical\"') AND administration_id = :id) AS Mechanical,
    (SELECT COUNT(*) FROM formulaire WHERE JSON_CONTAINS(type_probleme, '\"Electric\"') AND administration_id = :id) AS Electric,
    (SELECT COUNT(*) FROM formulaire WHERE JSON_CONTAINS(type_probleme, '\"Hydraulic\"') AND administration_id = :id) AS Hydraulic,
    (SELECT COUNT(*) FROM formulaire WHERE JSON_CONTAINS(type_probleme, '\"Informatique\"') AND administration_id = :id) AS Informatique";

    $statement = $connection->prepare($sql2);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->execute();
    $resultProblem = $statement->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/adminstrationMaintenance.css">
    <title>Chart.js Pie Chart Example</title>
    <script src="https://kit.fontawesome.com/c30097efd5.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container" style="width: 100%; height: 97vh; display: flex; padding: 0; justify-content: space-between;">
    <div class="header" id="header">
        <div class="container">
            <div class="image">
                <img src="Image/b74c8225-fb57-4667-adec-539a1f5ebfe1-removebg-preview.png"/>
                <h3><a>G M A O</a></h3>
            </div>
            <div class="links">
                <ul class="link">
                    <li><a href="Administration.php">Administration</a></li>
                    <li><a href="Administration-Maintenance.php">Maintenance</a></li>
                    <li><a href="Administration-Equipe.php">Team</a></li>
                    <li><a href="Administration-Production.php">Production</a></li>
                    <li><a href="chart.php" class="active">Statistics</a></li>
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
    <div class="static">
    <div class="box-container">
    <div class="box"> 
					<div class="text"> 
						<h2 class="topic-heading"><?php echo $resultProblem["Informatique"]?></h2> 
						<h2 class="topic">Informatique Problem</h2> 
					</div> 
					<i class="fa-solid fa-computer"></i>
	</div> 
    <div class="box"> 
					<div class="text"> 
						<h2 class="topic-heading"><?php echo $resultProblem["Electric"]?></h2> 
						<h2 class="topic">Electric Problem</h2> 
					</div> 
					<i class="fa-solid fa-plug-circle-bolt"></i>
	</div>
    <div class="box"> 
					<div class="text"> 
						<h2 class="topic-heading"><?php echo $resultProblem["Mechanical"]?></h2> 
						<h2 class="topic">Mechanical Problem</h2> 
					</div> 
					<i class="fa-solid fa-gear"></i>
	</div>
    <div class="box"> 
					<div class="text"> 
						<h2 class="topic-heading"><?php echo $resultProblem["Hydraulic"]?></h2> 
						<h2 class="topic">Hydraulic Problem</h2> 
					</div> 
					<i class="fa-solid fa-hand-holding-droplet"></i>
	</div>
    </div>
    <div class="chart-container">
        <h3>Pie chart show us Number of Workers depending of Type: </h3>
        <canvas id="pieChart"></canvas>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Agent', 'Maintenance', 'Production', 'Teams', 'Informatique', 'Mechanical','Hydraulic', 'Electric'],
            datasets: [{
                label: '# of Items',
                data: [
                    <?php echo $result['agentCount']; ?>,
                    <?php echo $result['maintenanceCount']; ?>,
                    <?php echo $result['productionCount']; ?>,
                    <?php echo $result['equipeCount']; ?>,
                    <?php echo $result['InformatiqueCount']; ?>,
                    <?php echo $result['MechanicalCount']; ?>,
                    <?php echo $result['HydraulicCount']; ?>,
                    <?php echo $result['ElectricCount']; ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',   // Agent
                    'rgba(54, 162, 235, 0.2)',   // Maintenance
                    'rgba(255, 206, 86, 0.2)',   // Production
                    'rgba(75, 192, 192, 0.2)',  // Equipe
                    'rgba(255, 159, 64, 0.2)',  // Informatique
                    'rgba(153, 102, 255, 0.2)', // Mechanical
                    'rgba(255, 205, 86, 0.2)',  // Hydraulic
                    'rgba(54, 162, 235, 0.2)'   // Electric
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pie Chart'
                }
            }
        }
    });
</script>

</body>
</html>
