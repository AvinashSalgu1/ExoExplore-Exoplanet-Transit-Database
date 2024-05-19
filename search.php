<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || time() > $_SESSION['timeout']) {
    // Redirect to login page if not logged in or session has timed out
    header("Location: login.php");
    exit;
}

// Retrieve user's profile information
$user_email = $_SESSION['email'];
// You can add further logic to retrieve and display user profile data here

// Reset session timeout to 5 minutes of inactivity
$_SESSION['timeout'] = time() + (5 * 60); // 5 minutes * 60 seconds
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('exoplanet4.png');
            background-size: cover;
            background-repeat: no-repeat;
            color: #fff;
            margin: 0;
            padding: 0;
            background-attachment: fixed; /* Make the background image fixed */
        }


        .container {
            width: 80%;
            margin: 20px auto;
        }

        h2 {
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .search-query {
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .search-query span {
            font-weight: bold;
            font-style: italic;
        }

        .iframe-container {
            margin-bottom: 50px;
        }

        .iframe-container iframe {
            width: 100%;
            height: 500px;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .goback-btn {
            background-color: #0080ff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .goback-btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: rgba(0, 0, 0, 0.9); 
            color: white;
        }

        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.7); 
        }

        tr:hover {
            background-color: rgba(0, 0, 0, 0.8); 
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if(isset($_GET['q'])) {
            // Retrieve the search query from the URL parameter
            $searchQuery = $_GET['q'];

            // Use $searchQuery variable to perform further actions, such as querying a database or displaying search results
            // For example:
            echo "<h2>Search Results</h2>";
            echo "<div class='search-query'>You searched for: <span>$searchQuery</span></div>";

            // Replace spaces with underscores in the search query
            $searchQueryForURL = str_replace(' ', '_', $searchQuery);

            // Construct the URL for the iframe based on the modified search query
            $iframeURL = "https://exoplanets.nasa.gov/eyes-on-exoplanets/#/planet/" . urlencode($searchQueryForURL) . "/";
            echo "<div class='iframe-container'>";
            echo "<iframe src='$iframeURL' frameborder='0' scrolling='no'></iframe>";
            echo "</div>";

            // Get the user input (planet name)
            $planet_name = $searchQuery; // Example, you can get this dynamically from user input

            // Replace spaces with "%20" in the planet name
            $search_query = str_replace(' ', '%20', $planet_name);

            // Construct the URL with the search query
            $url = 'http://localhost:8000/api/' . $search_query;

            // Initialize cURL session
            $curl = curl_init();

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL request 
            $response = curl_exec($curl);

            // Check for errors
            if (curl_errno($curl)) {
                echo 'Curl error: ' . curl_error($curl);
            }

            // Close cURL session
            curl_close($curl);

            // Decode JSON response
            $data = json_decode($response, true);

            // Display retrieved data in a table
            echo "<table>";
            echo "<tr><th>Parameter</th><th>Value</th></tr>";
            foreach($data as $key => $value) {
                // Check if $value is an array
                if(is_array($value)) {
                    // Convert array to string representation
                    $value = implode(', ', $value);
                }
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</table>";
        } else {
            // If no search query is provided, display a message or redirect the user
            echo "No search query provided. <br>";
        }
        ?>
    </div>
    <div class="button-container">
        <!-- Go back button -->
        <a href="success.php" class="goback-btn">Go Back</a>
    </div>
</body>
</html>

<?php
$hostname = "localhost";
$username = "avinash";
$password = "NarutoUzumaki!1";
$database = "login";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Decode JSON response
$data = json_decode($response, true);

// Extract values from $data
$parameter_values = array(
    'user_email' => $user_email,
    'Name' => $data['MAIN_ID'][0], // Change to match your JSON structure
    'RA' => $data['RA'][0], // Change to match your JSON structure
    'DEC' => $data['DEC'][0], // Change to match your JSON structure
    'RA_Error' => $data['COO_ERR_MAJA'][0], // Change to match your JSON structure
    'DEC_Error' => $data['COO_ERR_MINA'][0], // Change to match your JSON structure
    'Major_Axis_Error' => $data['COO_ERR_MAJA'][0], // Change to match your JSON structure
    'Minor_Axis_Error' => $data['COO_ERR_MINA'][0], // Change to match your JSON structure
    'Angle_Error' => $data['COO_ERR_ANGLE'][0], // Change to match your JSON structure
    'Quality' => $data['COO_QUAL'][0], // Change to match your JSON structure
    'Wavelength' => $data['COO_WAVELENGTH'][0], // Change to match your JSON structure
    'Bibcode' => $data['COO_BIBCODE'][0], // Change to match your JSON structure
    'Script_Number' => $data['SCRIPT_NUMBER_ID'][0] // Change to match your JSON structure
);

// Prepare the SQL statement
$sql = "INSERT INTO exoplanet (user_email, `Name`, RA, `DEC`, `RA Error`, `DEC Error`, `Major Axis Error`, `Minor Axis Error`, `Angle Error`, `Quality`, `Wavelength`, `Bibcode`, `Script Number`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt) {
    // Bind parameters using call_user_func_array
    $bindParams = array('sssssssssssss'); // Define types of parameters
    $bindParams = array_merge($bindParams, array_values($parameter_values)); // Merge with parameter values
    
    // Prepare references to the parameters
    $params = [];
    foreach ($bindParams as $key => $value) {
        $params[$key] = &$bindParams[$key]; // Pass each parameter by reference
    }
    
    // Bind parameters
    call_user_func_array(array($stmt, 'bind_param'), $params);
    
    // Execute the statement
    $stmt->execute();
    
    // Close the statement
    $stmt->close();
} else {
    // Handle the case where the statement preparation failed
    die("Error preparing statement: " . $conn->error);
}

// Close the connection
$conn->close();

