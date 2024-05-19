<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email']) || time() > $_SESSION['timeout']) {
    // Redirect to login page if not logged in or session has timed out
    header("Location: login.php");
    exit;
}

// Establish a database connection (Replace with your actual database connection code)
$servername = "localhost";
$username = "avinash";
$password = "NarutoUzumaki!1";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user's email
$email = $_SESSION['email'];

// Fetch search history data from the "exoplanet" table
$sql = "SELECT * FROM exoplanet WHERE user_email = '$email'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search History</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('exoplanet7.jpg'); /* Replace with the actual image URL */
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .container {
            max-width: 1920px; /* Increased container width */
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            overflow-x: auto; /* Add horizontal scroll if needed */
        }

        h1 {
            text-align: center;
            font-family: 'Helvetica', sans-serif; /* Change to your preferred font */
            color: #ffcc00; /* Change to your preferred color */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px; /* Increased padding for better visibility */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: rgba(0, 0, 0, 0.9);
            color: #fff; /* White color for text */
            font-size: 16px; /* Increased font size */
        }

        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.7);
        }

        tr:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        p {
            text-align: center;
            color: #ffcc00;
        }

        .back-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #007BFF; /* Blue background color */
            color: #fff; /* White font color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search History</h1>
        <?php
        if ($result->num_rows > 0) {
            echo '<table border="1">
                    <tr>
                        <th>Name</th>
                        <th>RA</th>
                        <th>DEC</th>
                        <th>RA Error</th>
                        <th>DEC Error</th>
                        <th>Major Axis Error</th>
                        <th>Minor Axis Error</th>
                        <th>Angle Error</th>
                        <th>Quality</th>
                        <th>Wavelength</th>
                        <th>Bibcode</th>
                        <th>Script Number</th>
                    </tr>';
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['Name'] . '</td>
                        <td>' . $row['RA'] . '</td>
                        <td>' . $row['DEC'] . '</td>
                        <td>' . $row['RA Error'] . '</td>
                        <td>' . $row['DEC Error'] . '</td>
                        <td>' . $row['Major Axis Error'] . '</td>
                        <td>' . $row['Minor Axis Error'] . '</td>
                        <td>' . $row['Angle Error'] . '</td>
                        <td>' . $row['Quality'] . '</td>
                        <td>' . $row['Wavelength'] . '</td>
                        <td>' . $row['Bibcode'] . '</td>
                        <td>' . $row['Script Number'] . '</td>
                    </tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No search history found.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
    <a href="success.php" class="back-button">Go Back</a>
</body>
</html>
