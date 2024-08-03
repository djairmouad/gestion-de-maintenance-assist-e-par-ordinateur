<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--FILE CSS-->
        <link rel="stylesheet" href="./css/normalize.css">
        <link rel="stylesheet" href="./css/administration.css">
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
            <ul class="link">
            <li><a href="Administration.php"  >Administration</a></li>
                <li><a href="Administration-Maintenance.php"  >Maintenance</a></li>
                <li><a href="Administration-Equipe.php" >Equipe</a></li>
                <li><a href="Administration-Production.php" >Production</a></li>
                <li><a href="Administration-Magasin.php" class="active">Magasin</a></li>
                <li><a href="Administration-achat.php">Purchase</a></li>
            </ul>
            <ul class="link_2">
                <li>
                    <a href="Login.php">
                <div class="logout">
                <div class="icon" style="text-align: center; font-size: 14px; margin-top: 9px;">
                <img src="Image/logout_FILL0_wght400_GRAD0_opsz24.png" alt="">
                </div>
                 <p style="margin: 0;">Logout</p>
                </div>
                 </a>
                </li>
            </ul>
            </div>
    </div>
    <div class="information">
        <form action="" method="post">
            <div class="info" class="title">
            <h2>Magasin</h2>
            </div>
           <div class="info">
            <div class="info-2">
            <label for=""> first Name of Magasin Director:</label>
            <input type="text" class="name">
            </div>
           </div>
           <div class="info">
            <div class="info-2">
                <label for="">Last Name  of Magasin  Director:</label>
                <input type="text" class="name">
                </div>
           </div>
           <div class="info">
            <div class="info-2">
                <label for="">Email:</label>
                <input type="email" name="" id="">
            </div>
           </div>
           <div class="info">
            <div class="info-2">
                <label for="">Password:</label>
                <input type="password" name="" id="">
            </div>
           </div>
           <div class="info">
            <div class="info-2">
            <label for="">Fix-Number:</label>
            <input type="number">
           </div>
           </div>
           <div class="info" style="flex-direction: row;">
            <input type="submit" value="Save" style="width: 28.5%;">
            <input type="submit" value="Modify" style="width: 28.5%;">
           </div>
         </form>
         <div class="image">
            <img src="image/Accord-17-500x0-c-default.png" alt="">
           </div>
    </div>
</body>
</html>