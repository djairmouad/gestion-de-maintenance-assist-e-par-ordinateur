<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FILE CSS -->
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/Creat.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <!-- Google Fonts -->
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
    <div class="container">
        <div class="all active">
            <div class="image">
                <img src="Image/b74c8225-fb57-4667-adec-539a1f5ebfe1.png" alt="" class="img1">
                <h2>Gestion de maintenance assistée par ordinateur</h2>
                <img src="Image/55f167b7-2b43-47ab-8e0b-b00bb734c5c4.png" alt="" class="img2">
            </div>
            <div class="creat">
                <form action="./dataBase/save/CreatSave.php" method="post">
                    <div class="info">
                        <h2>Create Account</h2>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="">First Name:</label>
                            <input type="text" name="firstName" class="name">
                        </div>
                        <div class="info-2">
                            <label for="">Last Name:</label>
                            <input type="text" name="lastName" class="name">
                        </div>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="">Email:</label>
                            <input type="email" name="email" id="">
                        </div>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="">Password:</label>
                            <input type="password" name="password" id="">
                        </div>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="">Fix-Number:</label>
                            <input type="number" name="FixNumber">
                        </div>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="">Type:</label>
                            <Select class="select" id="select" name="TypeCreation">
                                <option value="">....</option>
                                <option value="Administration">Administration</option>
                                <option value="Agent technique">Agent technique</option>
                            </Select>
                        </div>
                    </div>
                    <div class="info" id="Admin">
                        <div class="info-2">
                            <label for="">Code for Create Administration :</label>
                            <input type="number" name="CodeAdmin">
                        </div>
                    </div>
                    <div class="info" id="Agent">
                        <div class="info-2">
                            <label for="">Code for Create Agent technique:</label>
                            <input type="number" name="agent_autorisation">
                        </div>
                    </div>
                    <div class="info">
                        <input type="submit" value="Create Account" name="creatAccount" formaction="./dataBase/save/CreatSave.php">
                    </div>
                    <p>Already has Account? <a href="Login.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    // Selecting elements
    let select = document.getElementById("select");
    let admin = document.getElementById("Admin");
    let agent = document.getElementById("Agent");
    let cssclass = "active";

    // Initial hiding based on default selection
    if (select.value === "") {
        agent.classList.remove(cssclass);
    } else {
        admin.classList.remove(cssclass);
    }

    // Adding event listener for dropdown change
    select.addEventListener("change", function () {
        if (select.value === "Administration") {
            admin.classList.add(cssclass);
            agent.classList.remove(cssclass);
        } else {
            admin.classList.remove(cssclass);
            agent.classList.add(cssclass);
        }
    });

    const form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
        // Remove any existing error messages
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(function (errorMessage) {
            errorMessage.remove();
        });

        // Validation for First Name and Last Name
        const firstName = form.elements['firstName'].value;
        const lastName = form.elements['lastName'].value;
        const nameRegex = /^[a-zA-Z\s]*$/; // Only allow letters and spaces
        if (!nameRegex.test(firstName) || !nameRegex.test(lastName)) {
            event.preventDefault();
            displayErrorMessage(form.elements['firstName'], 'Name should contain only letters');
            return;
        }

        // Validation for Email
        const email = form.elements['email'].value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email format validation
        if (!emailRegex.test(email)) {
            event.preventDefault();
            displayErrorMessage(form.elements['email'], 'Please enter a valid email address.');
            return;
        }

        // Validation for Password
        const password = form.elements['password'].value;
        if (password.length < 8) {
            event.preventDefault();
            displayErrorMessage(form.elements['password'], 'Password should be at least 8 characters long.');
            return;
        }

        // Validation for Fix-Number
        const fixNumber = form.elements['FixNumber'].value;
        if (isNaN(fixNumber)) {
            event.preventDefault();
            displayErrorMessage(form.elements['FixNumber'], 'Fix-Number should be a number.');
            return;
        }
    });

    // Function to display error messages
    function displayErrorMessage(inputElement, message) {
        const errorMessage = document.createElement('span');
        errorMessage.classList.add('error-message');
        errorMessage.textContent = message;
        inputElement.parentNode.appendChild(errorMessage);
    }
});

    </script>
</body>
</html>
