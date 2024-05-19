<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: success.php");
    exit;
}

// Database connection
$conn = new mysqli("localhost", "avinash", "NarutoUzumaki!1", "login");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user's profile information
$email = $_SESSION['email'];
$sql = "SELECT * FROM credentials WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $first = $row['first'];
    $last = $row['last'];
    $email = $row['email'];
    $password = $row['password']; // Retrieve hashed password from database
} else {
    echo "User not found.";
}

// Check if the form is submitted for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $new_password = $_POST['new_password'];

    // Update profile information in the database
    $update_sql = "UPDATE credentials SET username='$username', first='$first', last='$last'";
    if (!empty($new_password)) {
        // If a new password is provided, hash it and update the password field
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql .= ", password='$hashed_password'";
    }
    $update_sql .= " WHERE email='$email'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Profile updated successfully";
        // You can redirect the user to another page or display a success message here
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('exoplanet3.jpg'); /* Replace 'exoplanet3.jpg' with the path to your background image */
            background-size: cover;
            background-position: center;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }

        h1 {
            color: #0080ff;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            color: #333; /* Dark gray */
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0080ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .goback-btn {
            background-color: #ccc;
            color: #333;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .goback-btn:hover {
            background-color: #999;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #0080ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Settings</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br>
            <label for="first">First Name:</label>
            <input type="text" id="first" name="first" value="<?php echo $first; ?>"><br>
            <label for="last">Last Name:</label>
            <input type="text" id="last" name="last" value="<?php echo $last; ?>"><br>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password"><br>
            <input type="submit" value="Save Changes">
            <a href="success.php"><button type="button" class="goback-btn">Go Back</button></a>
        </form>
        <p><a href="help.php">Help and Support</a></p>
    </div>
</body>

</html>
