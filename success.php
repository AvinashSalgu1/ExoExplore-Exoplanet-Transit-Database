<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || time() > $_SESSION['timeout']) {
    // Redirect to login page if not logged in or session has timed out
    header("Location: login.php");
    exit;
}

// Retrieve user's profile information
$email = $_SESSION['email'];
// You can add further logic to retrieve and display user profile data here

// Reset session timeout to 5 minutes of inactivity
$_SESSION['timeout'] = time() + (5 * 60); // 5 minutes * 60 seconds
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ExoExplore!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('exoplanet7.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .container {
            text-align: center;
            z-index: 1;
            position: relative;
            width: 95vw;
            margin: 0 auto;
            padding: 50px;
            max-width: 1200px; /* Added to limit the container width */
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input[type=text] {
            width: 60%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 16px;
            box-sizing: border-box;
            transition: width 0.4s ease-in-out;
        }

        .search-container input[type=text]:focus {
            width: 80%;
        }

        .search-container button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            background-color: #0080ff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        .dropdown {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #black;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.5);
            z-index: 1;
            right: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .iframe-container {
            margin: 0 auto; /* Center the iframe horizontally */
            width: 80%; /* Adjust the width of the iframe */
            max-width: 1200px; /* Added to limit the iframe width */
        }

        .background-gif {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to ExoExplore!</h1>
        <p>Thank you for logging in. Here's some information about exoplanets:</p>
        <p>An exoplanet or extrasolar planet is a planet outside the Solar System. As of January 2022, there are over 4,700 confirmed exoplanets discovered, with thousands more candidates awaiting confirmation.</p>
        <p>Exoplanets vary widely in size, composition, and orbital characteristics. They are detected using various methods, including the transit method, radial velocity method, and direct imaging.</p>
        <p>Scientists study exoplanets to learn more about planetary formation, habitability, and the diversity of planetary systems in the universe.</p>
        <div class="search-container">
            <form action="search.php" method="get">
                <input type="text" placeholder="Search.." name="q">
                <button type="submit">Search</button>
            </form>
        </div>
        <?php
// Check if user is logged in and display dropdown with user's first name
if (isset($_SESSION['first_name'])) {
    echo '<div class="dropdown">
            <span>' . $_SESSION['first_name'] . '</span>
            <div class="dropdown-content">
                <a href="settings.php">Settings</a>
                <a href="history.php">History</a> <!-- Added this line for the History option -->
                <a href="login.php">Logout</a>
            </div>
        </div>';
}
?>

    </div>
    <div class="iframe-container">
        <iframe src="https://exoplanets.nasa.gov/eyes-on-exoplanets/#" width="100%" height="500px" frameborder="0" scrolling="no"></iframe>
    </div>
</body>
</html>
