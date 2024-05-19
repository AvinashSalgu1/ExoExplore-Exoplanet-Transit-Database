<?php
session_start();

// Define variables for username, first name, last name, email, and password
$username = $first = $last = $email = $password = "";
$signup_err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $first = isset($_POST["first"]) ? $_POST["first"] : "";
    $last = isset($_POST["last"]) ? $_POST["last"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // Database connection (replace with your credentials)
    $conn = new mysqli("localhost", "avinash", "NarutoUzumaki!1", "login");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if username or email already exists
    $check_query = "SELECT * FROM credentials WHERE username='$username' OR email='$email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $signup_err = "Username or email already exists.";
    } else {
        // Insert new user into the database using prepared statements
        $stmt = $conn->prepare("INSERT INTO credentials (username, first, last, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $first, $last, $email, $password_hash);
        
        // Hash the password before storing it
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit;
        } else {
            $signup_err = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExoExplore Signup</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #141414;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('exoplanet6.jpg');
            background-size: cover;
        }

        .container {
            width: 300px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 14px;
            color: #fff;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 40px);
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 5px;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #0080ff;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .login-link {
            margin-top: 10px;
            font-size: 14px;
            color: #fff;
        }

        .login-link a {
            color: #0080ff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>ExoExplore Signup</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>

            <label for="first">First Name:</label>
            <input type="text" name="first" value="<?php echo htmlspecialchars($first); ?>" required><br>

            <label for="last">Last Name:</label>
            <input type="text" name="last" value="<?php echo htmlspecialchars($last); ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Sign Up">
        </form>
        <?php if (!empty($signup_err)) { ?>
            <p class="error-message"><?php echo $signup_err; ?></p>
        <?php } ?>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>

</html>