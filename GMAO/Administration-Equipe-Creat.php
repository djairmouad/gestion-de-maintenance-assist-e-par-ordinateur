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
                <li><a href="Administration-Equipe-Creat.php" class="active">Creat Team</a></li>
                <li><a href="Administration-Equipe.php" >List</a></li>
            </ul>
        </div>
    </div>
<div class="information active" id="information">
        <form action="" method="post">
        <div class="info" class="title">
        <h2>Create Equipe:</h2>
    </div>
    <div class="info more">
        <div class="info-2">
            <label for="type">Type:</label>
            <select id="type" name="type">
                <option value="">...</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Electric">Electric</option>
                <option value="Hydraulic">Hydraulic</option>
                <option value="Informatique">Informatique</option>
            </select>
        </div>
        <div class="info active" id="info">
            <div class="info-2">
                <label for="firstName">Name of Department boss:</label>
                <input type="text" name="firstName">
            </div>
            <div class="info-2">
                <label for="email">Gmail:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="info-2">
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>
            <div class="info-2">
                <label for="fixNumber">Fix-Number:</label>
                <input type="number" id="fixNumber" name="fixNumber">
            </div>
        </div>
    </div>
            <div class="info" style="flex-direction: row;">
                <input type="submit" value="Save" style="width: 28.5%;" name="save" formaction="./dataBase/save/saveEquipe.php">
            </div>
        </form>
        <div class="image">
            <img src="image/Agent-de-maintenance-4-07-500x0-c-default.png" alt="">
        </div>
    </div>
    </div>
    </div>
</body>
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

</html>