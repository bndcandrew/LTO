<?php
session_start();

// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['ADMIN']) || $_SESSION['ADMIN'] !== true) {
    header('Location: LTOadmin_login.php');
    exit();
}

$serverName = "DESKTOP-I0HTBLL\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if a specific province or city is provided
if (isset($_GET['province'])) {
    $selectedProvince = $_GET['province'];

    $sqlReports = "SELECT UA.USERID, UA.LAST_NAME, UA.FIRST_NAME, A.EMAIL, UA.STREET, UA.PROVINCE, UA.CITY
                    FROM USER_DATA AS UA
                    INNER JOIN ACCOUNTS AS A ON UA.USERID = A.USERID
                    WHERE UA.PROVINCE = ?";
    $paramsReports = array($selectedProvince);
} elseif (isset($_GET['city'])) {
    $selectedCity = $_GET['city'];

    $sqlReports = "SELECT UA.USERID, UA.LAST_NAME, UA.FIRST_NAME, A.EMAIL, UA.STREET, UA.PROVINCE, UA.CITY
                    FROM USER_DATA AS UA
                    INNER JOIN ACCOUNTS AS A ON UA.USERID = A.USERID
                    WHERE UA.CITY = ?";
    $paramsReports = array($selectedCity);
} else {
    $sqlReports = "SELECT UA.USERID, UA.LAST_NAME, UA.FIRST_NAME, A.EMAIL, UA.STREET, UA.PROVINCE, UA.CITY
                    FROM USER_DATA AS UA
                    INNER JOIN ACCOUNTS AS A ON UA.USERID = A.USERID";
    $paramsReports = array();
}

$resultsReports = sqlsrv_query($conn, $sqlReports, $paramsReports);

if ($resultsReports === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 800px;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            align-items: center;
        }
        label {
            margin-right: 10px;
        }
        input[type="text"],
        input[type="submit"] {
            padding: 6px;
            border-radius: 4px;
        }
        h1 {
            margin: 0; /* Remove default margin for h1 */
        }
        a {
            display: inline-block;
            margin-right: 10px;
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
        }
        a.logout {
            background-color: #d9534f; /* Change to the desired color */
        }
    </style>
</head>
<body>
    <header>
        <h1>Reports</h1>
        
        <!-- Navigation Links -->
        <nav>
            <a href="LTOreportsALL.php">Reports</a>
            <a href="LTOreportsDATE.php">Filter by Date</a>
            <a href="LTOreportsLICENSE.php">Filter by License Type</a>
            <a href="LTOreportsCOMPLETE.php">Complete Reports</a>
            <a href="LTOadmin_login.php" class="logout">Logout</a>
        </nav>
        <!-- End Navigation Links -->
    </header>

   

    <table border="1px" style="line-height: 20px;">
        <thead>
            <tr>
                <th>USERID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Street</th>
                <th>Province</th>
                <th>City</th>
            </tr>
        </thead>

        <?php
        while ($row = sqlsrv_fetch_array($resultsReports)) {
            $userid = $row['USERID'];
            $lastname = $row['LAST_NAME'];
            $firstname = $row['FIRST_NAME'];
            $email = $row['EMAIL'];
            $street = $row['STREET'];
            $province = $row['PROVINCE'];
            $city = $row['CITY'];

            echo '<tr>
                <td>' . $userid . '</td>
                <td>' . $lastname . '</td>
                <td>' . $firstname . '</td>
                <td>' . $email . '</td>
                <td>' . $street . '</td>
                <td>' . $province . '</td>
                <td>' . $city . '</td>
            </tr>';
        }
        ?>  
    </table>
    <br>
     <!-- Filter Form -->
     <form action="LTOreportsPROVINCE.php" method="get">
        <label for="province">Filter by Province:</label>
        <input type="text" name="province" id="province" placeholder="Enter Province">
        <input type="submit" value="Filter">
    </form>

    <form action="LTOreportsPROVINCE.php" method="get">
        <label for="city">Filter by City:</label>
        <input type="text" name="city" id="city" placeholder="Enter City">
        <input type="submit" value="Filter">
    </form>
    <!-- End Filter Form -->
</body>
</html>
