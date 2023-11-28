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

// Check if a specific USERID is provided
if (isset($_GET['userid'])) {
    $userID = $_GET['userid'];

    $sqlRecord = "SELECT UA.USERID, UA.LAST_NAME, UA.FIRST_NAME, A.EMAIL, A.DATE_CREATED, UA.STREET, UA.PROVINCE, UA.CITY, AD.LICENSE_TYPE
                    FROM USER_DATA AS UA
                    INNER JOIN ACCOUNTS AS A ON UA.USERID = A.USERID
                    LEFT JOIN APPLICATION_DETAILS AS AD ON UA.USERID = AD.USERID
                    WHERE UA.USERID = ?";
    $paramsRecord = array($userID);

    $resultRecord = sqlsrv_query($conn, $sqlRecord, $paramsRecord);

    if ($resultRecord === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($resultRecord);
} else {
    $row = null; // No specific USERID provided
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 1200px;
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
        input[type="submit"],
        input[type="text"] {
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
        <h1>User Record</h1>
        
        <!-- Navigation Links -->
        <nav>
            <a href="LTOreportsALL.php">Reports</a>
            <a href="LTOreportsDATE.php">Filter by Date</a>
            <a href="LTOreportsPROVINCE.php">Filter by Province or City</a>
            <a href="LTOreportsLICENSE.php">Filter by License Type</a>
            <a href="LTOadmin_login.php" class="logout">Logout</a>
        </nav>
        <!-- End Navigation Links -->
    </header>

    <?php if ($row) : ?>
        <table border="1px" style="line-height: 20px;">
            <thead>
                <tr>
                    <th>USERID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Date of Registration</th>
                    <th>Street</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>License Type</th>
                </tr>
            </thead>
            <tr>
                <td><?= $row['USERID'] ?></td>
                <td><?= $row['LAST_NAME'] ?></td>
                <td><?= $row['FIRST_NAME'] ?></td>
                <td><?= $row['EMAIL'] ?></td>
                <td><?= $row['DATE_CREATED']->format('Y-m-d H:i:s') ?></td>
                <td><?= $row['STREET'] ?></td>
                <td><?= $row['PROVINCE'] ?></td>
                <td><?= $row['CITY'] ?></td>
                <td><?= $row['LICENSE_TYPE'] ?></td>
            </tr>
        </table>
    <?php else : ?>
        <p>No record found for the specified USERID.</p>
    <?php endif; ?>

    <br>
    <!-- Form to input USERID for viewing the record -->
    <form action="LTOreportsCOMPLETE.php" method="get">
        <label for="userid">Enter USERID:</label>
        <input type="text" name="userid" id="userid" required>
        <input type="submit" value="View Record">
    </form>
    <!-- End Form -->
</body>
</html>
