# ExoExplore

ExoExplore is a comprehensive platform designed to explore and understand exoplanets. This project provides detailed information about exoplanets, their characteristics, and their significance in the study of the universe. It serves as a valuable resource for researchers, educators, and enthusiasts interested in exoplanetary systems.

## Features

- Access to a wealth of information about exoplanets
- Intuitive interface for discovering and learning about exoplanets
- Extensive database of exoplanetary systems
- Robust security measures to protect data integrity
- Support for collaboration among scientists, educators, and the general public

## Requirements

- PHP 7.4 or higher
- XAMPP (Apache and MySQL)
- FastAPI for deploying the API

## Installation

### Step 1: Install PHP

Ensure that PHP is installed on your system. You can download the latest version of PHP from the [official PHP website](https://www.php.net/downloads).

### Step 2: Install XAMPP

Download and install XAMPP from the [official XAMPP website](https://www.apachefriends.org/index.html). XAMPP includes Apache and MySQL, which are required for this project.

### Step 3: Set Up XAMPP

1. Start the Apache and MySQL services from the XAMPP control panel.
2. Open the XAMPP installation directory and navigate to the `htdocs` folder. This is where you will place your project files.

### Step 4: Clone the Repository

Clone the ExoExplore repository into the `htdocs` folder.

```bash
cd /path/to/your/xampp/htdocs
git clone https://github.com/yourusername/ExoExplore.git
```

### Step 5: Configure the Database

1. Open the `phpMyAdmin` interface by navigating to `http://localhost/phpmyadmin` in your web browser.
2. Create a new database for the project.
3. Import the provided SQL file (`database.sql`) into the newly created database.

### Step 6: Update Configuration Files

Update the database configuration in your project files as needed. Ensure that the database name, username, and password match your MySQL setup.

### Step 7: Install FastAPI

Ensure that Python is installed on your system. Install FastAPI and Uvicorn using pip.

```bash
pip install fastapi uvicorn
```

### Step 8: Deploy the API
Navigate to the directory containing the FastAPI application and run the following command to start the FastAPI server.

```bash
Copy code
uvicorn main:app --reload
Replace main:app with the appropriate path to your FastAPI application.
```

### Usage
Once everything is set up, you can access the ExoExplore platform by navigating to http://localhost/ExoExplore in your web browser. The FastAPI server will be running on http://localhost:8000 by default, and you can access the API endpoints from there.

### Contributing
We welcome contributions to ExoExplore! If you would like to contribute, please fork the repository and create a pull request with your changes.

### License
This project is licensed under the MIT License. See the LICENSE file for details.

### Acknowledgements
We would like to thank all the contributors and the open-source community for their support and contributions to this project.

