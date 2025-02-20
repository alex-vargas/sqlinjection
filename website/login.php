<?php
$host = 'my-sqli-db'; // Container name of MariaDB
$user = 'myuser';
$pass = 'mypassword';
$dbname = 'sqlinjectiondb';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to hold feedback message
$sql_query = ""; // Variable to hold the SQL query string

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL Injection vulnerable query
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $sql_query = $query; // Save the SQL query to be displayed
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $message = "Login successful! Welcome, " . htmlspecialchars($username);
    } else {
        $message = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Login</title>
    <style>
        /* CSS for centering the form */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .form-container {
            border: 1px solid #ccc;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message, .query {
            text-align: center;
            margin-bottom: 20px;
        }
        .message {
            color: #ff0000;
        }
        .query {
            font-family: monospace;
            color: #0000ff;
            white-space: pre-wrap; /* Preserve formatting */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <!-- Display the feedback message -->
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Display the SQL query -->
        <?php if ($sql_query): ?>
            <div class="query">SQL Query: <?php echo htmlspecialchars($sql_query); ?></div>
        <?php endif; ?>

        <form method="post">
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
