<?php
session_start();
$email="";
$password = "";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from form
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Database connection (replace with your credentials)
    $conn = new mysqli("localhost", "avinash", "NarutoUzumaki!1", "login");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check user credentials
    $stmt = $conn->prepare("SELECT * FROM credentials WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION["email"] = $email;
            $_SESSION["first_name"] = $row['first']; // Retrieve first name from database
            // Set session timeout to 5 minutes of inactivity
            $_SESSION['timeout'] = time() + (5 * 60); // 5 minutes * 60 seconds
            // Redirect to success page
            header("Location: success.php");
            exit;
        } else {
            // Display error message if login fails
            $login_err = "Invalid email or password.";
        }
    } else {
        // Display error message if login fails
        $login_err = "Invalid email or password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExoExplore Login</title>
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
            background-image: url('exo.jpg');
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
        }

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

        .signup-link {
            margin-top: 10px;
            font-size: 14px;
        }

        .signup-link a {
            color: #0080ff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>ExoExplore Login</h2>
        <?php if (!empty($login_err)) { ?>
            <p class="error-message"><?php echo $login_err; ?></p>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" required><br>

            <input type="submit" value="Login">
        </form>
        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>

</html>
