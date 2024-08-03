
<?php
function verify($email, $connection) {
    // Prepare the SQL query
    $sql1 = "SELECT * FROM user WHERE email = :email";
    $statement = $connection->prepare($sql1);
    
    // Bind the email parameter
    $statement->bindValue(":email", $email);
    
    // Execute the query
    $statement->execute();

    // Fetch the user data
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if a user record was found
    if ($user !== false) {
        return true;
    } else {
        return false;
    }
}

