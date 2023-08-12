<?php
session_start();


if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $servername = "localhost";
    $db_username = "root"; // Replace with your DB username
    $db_password = "";     // Replace with your DB password
    $dbname = "ddropbox";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: index.php"); // Redirect to index.html
        exit();
    } else {
        echo "Invalid username or password. Please try again.";
    }

    $conn->close();
}
?>


<!-- HTML code for the login form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view.css">
    <title>DropBox App - Login</title>
</head>
<body>
    <header>
        <h1 class="logo">DropBox App</h1>
        <button class="login-button">Login</button>
    </header>
    <main>
        <div class="login-container">
            <form action="" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <br>
                <button type="submit" class="login-submit">Login</button>
            </form>
        </div>
    </main>
    <footer>
        <p class="footer-text">DESIGNED BY ADEBOYE DANIEL_ICTG_TEST</p>
    </footer>
</body>
</html>
