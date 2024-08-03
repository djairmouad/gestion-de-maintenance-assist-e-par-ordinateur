<?php 
require("../config.php");
session_start();
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
$password = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
$id = isset($_SESSION["id"]) ? $_SESSION["id"] : "";
$TypeCreation = isset($_SESSION["type"]) ? $_SESSION["type"] : "";
$result = [];
if ($id !== ""){
    $connection = new PDO($dsn, $db_user, $db_password);
    $sql1="SELECT * FROM equipe WHERE user_id=:user_id";
    $statement = $connection->prepare($sql1);
    $statement->bindValue(":user_id",$id);
    $statement->execute();
    $resultEquipe = $statement->fetchAll();
    foreach($resultEquipe as $row){
        $name=$row["name_boss"];
    }
    // Modified SQL query to check if $TypeCreation is one of the values in formulaire.type_probleme
    $sql2 = "SELECT * FROM equipe 
    JOIN formulaire ON equipe.maintenance_id = formulaire.maintenance_id 
    WHERE equipe.user_id = :user_id 
    AND (formulaire.type_formulaire = 'Production' OR formulaire.type_formulaire = 'End') 
    AND formulaire.type_probleme LIKE :type_probleme 
    AND (formulaire.summary_Informatique IS NULL OR formulaire.summary_Informatique = '');";


    $statement = $connection->prepare($sql2);
    $statement->bindValue(":user_id",$id);
    // Using % as wildcard to search for $TypeCreation within the string
    $statement->bindValue(":type_probleme", '%' . $TypeCreation . '%');
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
     <link rel="stylesheet" href="../css/normalize.css">
     <link rel="stylesheet" href="../css/agent.css">
     <link rel="stylesheet" href="../css/all.min.css">

     <!-- google icons -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
            <div class="image"><img src="../Image/b74c8225-fb57-4667-adec-539a1f5ebfe1-removebg-preview.png"/><h3><a>G M A O</a></h3></div>
            <div class="links">
            <ul class="link">
                <li><a href="Mechanical.php" class="active">Request For Intervention</a></li>
            </ul>
            <ul class="link_2">
                <li><a href="profileEquipe.php">
                    <div class="profile">
                        <div class="icon" style="text-align: center;">
                        <img src="../Image/account_circle_FILL0_wght400_GRAD0_opsz24.png" alt="">
                       </div>
                       <p style="margin: 0;">Profile</p>
                    </div>
                </a></li>
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
    <h2>  Informatique:</h2>
    <table id="requests-table">
        <thead>
            <tr>
                <th>Number</th>
                <th>Type</th>
                <th>Time</th>
                <th>Action</th>
                <th>Send</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($result as $row):?>
            <tr>
                <td style="text-align: center;"><?php echo $row['number_of_formulaire']; ?></td>
                <td style="text-align: center;">
               <p style="padding: 5px; width: 85px; background-color: <?php echo ($row['type_intervention'] === 'curative') ? 'red' : (($row['type_intervention'] === 'systematic') ? 'orange' : 'green'); ?>; color: white;"><?php echo $row['type_intervention']; ?></p>
               <?php 
                  $type_probleme_array = explode(',', $row["type_probleme"]); // Assuming values are comma-separated

                 if (is_array($type_probleme_array) && count($type_probleme_array) >= 2) { ?>
                 <p style="padding: 5px; width: 85px; background-color: <?php echo 'red' ?>">Problem</p>
                  <?php } ?>      
            </td>


                <td style="text-align: center;"><?php echo $row['date_production']; ?></td>
                <td style="text-align: center;">
                    <button class="show-details-btn">Show Details</button> 
                </td>
                <td style="text-align: center;">
                <input type="submit" form="form_<?php echo $row['id']; ?>" value="Send" style="height: 35px">
                </td>
            </tr>
            <tr class="details-row">
                <td colspan="4">
                <div class="information active" id="information">
                <form action="../dataBase/save/FormulairEquipe.php" method="post" id="form_<?php echo $row['id']; ?>">
        <input type="hidden" name="id_formulaire" class="" value="<?php echo $row["id"]?>">
        <div class="box">
        <div class="info">
            <div class="info-2">
                <label for="Numero">Numero:</label>
                <input type="number" value="<?php echo $row["number_of_formulaire"]?>" disabled>
            </div>
        </div>
        <div class="info">
            <div class="info-2">
                <label for="">DATE/HOUR(Agent):</label>
                <input id="" type="datetime-local" value="<?php echo $row["date_agent"]?>" disabled>
            </div>
        </div>
        <div class="info">
            <div class="info-2">
                <label for="">REF:</label>
                <input id="" type="text" value="<?php echo $row["ref"]?>" disabled>
            </div>
        </div>
        <div class="info">
    <div class="info-2">
        <label for="type">Type of Intervention:</label>
        <select name="type-interv[]" id="select" disabled>
            <option value="">...</option>
            <option value="preventive" <?php echo ($row["type_intervention"] === "preventive") ? 'selected="selected"' : ''; ?>>Preventive</option>
            <option value="systematic" <?php echo ($row["type_intervention"] === "systematic") ? 'selected="selected"' : ''; ?>>Systematic</option>
            <option value="curative" <?php echo ($row["type_intervention"] === "curative") ? 'selected="selected"' : ''; ?>>Curative</option>
        </select>
    </div>
</div>

<?php if($row["type_intervention"] === "preventive"): ?>
    <div class="info prev active" id="info_prev">
        <div class="info-2">
            <label for="type">Type of Preventive:</label>
            <select name="type-preventive[]" id="" disabled>
                <option value="">...</option>
                <option value="Working hours" <?php echo ($row["type_preventive"] === "Working hours") ? 'selected="selected"' : ''; ?>>Working Hours</option>
                <option value="Date" <?php echo ($row["type_preventive"] === "Date") ? 'selected="selected"' : ''; ?>>Date</option>
                <option value="Production Quantity" <?php echo ($row["type_preventive"] === "Production Quantity") ? 'selected="selected"' : ''; ?>>Production Quantity</option>
            </select>
        </div>
    </div>
<?php elseif($row["type_intervention"] === "curative"): ?>
    <div class="info curative active" id="info_curative">
        <div class="info-2">
            <label for="type">Levels of Danger:</label>
            <select name="type-curative" id="" disabled>
                <option value="">...</option>
                <option value="Risk" <?php echo ($row["levels_danger"] === "Risk") ? 'selected="selected"' : ''; ?>>Risk</option>
                <option value="Hazard" <?php echo ($row["levels_danger"] === "Hazard") ? 'selected="selected"' : ''; ?>>Hazard</option>
                <option value="Peril" <?php echo ($row["levels_danger"] === "Peril") ? 'selected="selected"' : ''; ?>>Peril</option>
            </select>
        </div>
    </div>
<?php endif; ?>


        </div>
        <div class="box">
        <div class="info">
            <div class="info-2">
                <label for="type">Type:</label>
                <select id="type" name="Type[]" disabled>
                          <option value="">...</option>
                          <option value="Mechanical" <?php echo ($TypeCreation === "Mechanical") ? 'selected' : ''; ?>>Mechanical</option>
                          <option value="Electric" <?php echo ($TypeCreation === "Electric") ? 'selected' : ''; ?>>electric</option>
                          <option value="Hydraulic" <?php echo ($TypeCreation === "Hydraulic") ? 'selected' : ''; ?>>hydraulic</option>
                          <option value="Informatique" <?php echo ($TypeCreation === "Informatique") ? 'selected' : ''; ?>>Informatique</option>
                </select>
                </div>
        </div>
        <div class="info">
            <div class="info-2">
                <label for="type">Subsidiary:</label>
                <select name="type-subsidiary[]" id="" disabled>
                    <option value="">...</option>
                    <option value="subsidiary-A" <?php echo ($row["subsidiary"] === "subsidiary-A") ? 'selected' : ''; ?> >subsidiary-A</option>
                    <option value="subsidiary-B"  <?php echo ($row["subsidiary"] === "subsidiary-B") ? 'selected' : ''; ?>>subsidiary-B</option>
                    <option value="subsidiary-C"  <?php echo ($row["subsidiary"] === "subsidiary-C") ? 'selected' : ''; ?>>subsidiary-C</option>
                </select>
            </div>

        </div>
        <div class="info">
            <div class="info-2">
                <label for="type">Line:</label>
                <select name="line[]" id="" disabled>
                    <option value="">...</option>
                    <option value="line-1"  <?php echo ($row["line"] === "line-1") ? 'selected' : ''; ?>>line-1</option>
                    <option value="line-2" <?php echo ($row["line"] === "line-2") ? 'selected' : ''; ?>>line-2</option>
                    <option value="line-3" <?php echo ($row["line"] === "line-3") ? 'selected' : ''; ?>>line-3</option>
                </select>
            </div>
        </div>
        <div class="info">
            <div class="info-2">
                <label for="type">Equipment:</label>
                <select name="type-equipment[]" id="" disabled>
                 <option value="">...</option>
                 <option value="equipment-A"  <?php echo ($row["equipment"] === "equipment-A") ? 'selected' : ''; ?>>equipment-A</option>
                 <option value="equipment-B" <?php echo ($row["equipment"] === "equipment-B") ? 'selected' : ''; ?> >equipment-B</option>
                 <option value="equipment-C" <?php echo ($row["equipment"] === "equipment-C") ? 'selected' : ''; ?>>equipment-C</option>
                 <option value="equipment-D" <?php echo ($row["equipment"] === "equipment-D") ? 'selected' : ''; ?>>equipment-D</option>
                 <option value="equipment-E" <?php echo ($row["equipment"] === "equipment-E") ? 'selected' : ''; ?>>equipment-E</option>
                 <option value="equipment-F" <?php echo ($row["equipment"] === "equipment-F") ? 'selected' : ''; ?>>equipment-F</option>
               </select>
            </div>
        </div>
        </div>
        <div class="box">
            <div class="info">
                <div class="info-2">
                <label for=""> first Name of Maintenance Director:</label>
                <input type="text" name="name_maintenance" class="name" value="<?php echo $row["name_maintenance_director"]?>" disabled>
                </div>
               </div>
            <div class="info">
                <div class="info-2">
                    <label for="">DATE/HOUR(Maintenance):</label>
                    <input id="" name="date_maintenance" type="datetime-local" value="<?php echo $row["date_maintenance"]?>"disabled >
                </div>
            </div>
            <div class="info">
                <div class="info-2">
                <label for=""> first Name of Production Director:</label>
                <input type="text" name="name_production" class="name" value="<?php echo $row["name_production_director"] ?>" disabled>
                </div>
               </div>
            <div class="info">
                <div class="info-2">
                    <label for="">DATE/HOUR(Production):</label>
                    <input id="" name="date_production" type="datetime-local" value="<?php echo $row["date_production"]?>" disabled >
                </div>
            </div>
        </div>
        <div class="box">
            <div class="info">
                <div class="info-2">
                <label for=""> Name of Department boss:</label>
                <input type="text" class="name" name="name_Equipe" value="<?php echo $name?>" >
                </div>
               </div>
            <div class="info">
                <div class="info-2">
                    <label for="date">DATE/HOUR(Informatique):</label>
                    <input id="date" name="date_end" type="datetime-local">
                </div>
            </div>
        </div>
        <div class="box" style="height: 25%;width: 70%;">
            <label for=""> Brief About the Machine Probleme:</label>
            <textarea name="summary" id="" cols="50" rows="10"></textarea>
            <div class="box" style="width: 100%;display: flex;justify-content: end;align-items: center;gap: 20px;">
            <p>if there is error write it and enter this Button: </p>
            <input type="submit" value="Problem" style="background-color:red; color:white" formaction="../dataBase/save/FormulairProblem.php">
            </div>
        </div>
        </form>
                 </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>

  <!-- JavaScript code -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInputs = document.querySelectorAll("#date");
const time = new Date(); // Current date and time
const localTime = new Date(time.getTime() - (time.getTimezoneOffset() * 60000)); // Adjust for time zone offset
const formattedTime = localTime.toISOString().slice(0, 16); // Format: YYYY-MM-DDTHH:MM
dateInputs.forEach((item, index) => {
    item.value = formattedTime;
});


        const showButtons = document.querySelectorAll(".show-details-btn");
        const detailsRows = document.querySelectorAll(".details-row");

        showButtons.forEach(button => {
            button.addEventListener("click", function() {
                const detailsRow = this.closest("tr").nextElementSibling;
                detailsRow.classList.toggle("active");
            });

            // Set form action when 'Send' button is clicked
            button.addEventListener("click", function() {
                const form = this.closest("tr").querySelector("form");
                form.action = "dataBase/save/FormulairProduction.php";
            });
        });      
    });
</script>

</body>
</html>
