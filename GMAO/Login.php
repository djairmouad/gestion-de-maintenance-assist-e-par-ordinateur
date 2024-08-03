<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--FILE CSS-->
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/Login.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <title>Login</title>
    <style>
        .error {
            font-size: 12px;
    color: red;
    margin-top: 2px;
    width: 100%;
        }
    </style>
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
                <form id="loginForm" action="dataBase/save/LoginValide.php" method="post">
                    <div class="info">
                        <h2>LOGIN</h2>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email">
                            <p id="emailError" class="error"></p>
                        </div>
                    </div>
                    <div class="info">
                        <div class="info-2">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password">
                            <p id="passwordError" class="error"></p>
                        </div>
                    </div>
                    <div class="info">
                        <input type="checkbox" id="remember-me">
                        <label for="remember-me">Remember me</label>
                    </div>
                    <div class="info">
                        <input type="submit" value="LOGIN" name="login">
                    </div>
                    <p>Don't have an account? <a href="Creat.php">Create</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    function validateEmail(email) {
        // Simple email validation regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePassword(password) {
        // Check if password length is at least 8 characters
        return password.length >= 8;
    }

    loginForm.addEventListener('submit', function(event) {
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        let hasError = false;

        if (!validateEmail(email)) {
            emailError.textContent = 'Email format is incorrect';
            hasError = true;
        } else {
            emailError.textContent = '';
        }

        if (!validatePassword(password)) {
            passwordError.textContent = 'Password should be at least 8 characters';
            hasError = true;
        } else {
            passwordError.textContent = '';
        }

        // Additional error text for Gmail or Password problems
        const additionalErrorText = ''; // Add your additional error text here
        if (additionalErrorText) {
            if (emailError.textContent) {
                emailError.textContent += ' ' + additionalErrorText;
            } else {
                emailError.textContent = additionalErrorText;
            }
            hasError = true;
        }

        if (hasError) {
            event.preventDefault(); // Prevent form submission only if there are errors
        }
    });
</script>



</body>
</html>
