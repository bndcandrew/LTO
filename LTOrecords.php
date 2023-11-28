<?php
// Assuming you've started the session in your script
session_start();

// Retrieve the email from the URL parameters or session, whichever is appropriate
$enteredEmail = $_GET['email'] ?? $_SESSION['userEmail'] ?? null;

if ($enteredEmail === null) {
    // Handle the case where email is not provided
    echo "Email not provided.";
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

$sqlReport1 = "SELECT UA.*, A.email 
                FROM USER_DATA AS UA
                INNER JOIN ACCOUNTS AS A ON UA.USERID = A.USERID
                WHERE A.email = ?";
$paramsReport1 = array($enteredEmail);
$resultsReport = sqlsrv_query($conn, $sqlReport1, $paramsReport1);

if ($resultsReport === false) {
    die(print_r(sqlsrv_errors(), true));
}

$sqlReport2 = "SELECT COUNT(USERID) as totalcount FROM USER_DATA";
$resultsReport2 = sqlsrv_query($conn, $sqlReport2);
$totalcount = sqlsrv_fetch_array($resultsReport2);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 1450px;
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
        .edit-btn {
            background-color: #01438a; 
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>My Record</h1>
    <table border="1px" style="line-height: 20px;">
    <thead>
        <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Street</th>
            <th>Province</th>
            <th>City</th>
            <th>Contact</th>
            <th>TIN</th>
            <th>Nationality</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Height</th>
            <th>Weight</th>
        </tr>
    </thead>

    <?php
    while($rows = sqlsrv_fetch_array($resultsReport)){
        $fieldname1=$rows['LAST_NAME'];
        $fieldname2=$rows['FIRST_NAME'];
        $fieldname3=$rows['MIDDLE_NAME'];
        $fieldname4=$rows['STREET'];
        $fieldname5=$rows['PROVINCE'];
        $fieldname6=$rows['CITY'];
        $fieldname7=$rows['CONTACT'];
        $fieldname8=$rows['TIN'];
        $fieldname9=$rows['NATIONALITY'];
        $fieldname10=$rows['GENDER'];
        $fieldname11=$rows['BIRTHDATE']->format('Y-m-d');
        $fieldname12=$rows['HEIGHT'];
        $fieldname13=$rows['WEIGHT'];
        $userid = $rows['USERID'];
    echo '<tr>
    <td>' .$fieldname1.'</td>
    <td>' .$fieldname2.'</td>
    <td>' .$fieldname3.'</td>
    <td>' .$fieldname4.'</td>
    <td>' .$fieldname5.'</td>
    <td>' .$fieldname6.'</td>
    <td>' .$fieldname7.'</td>
    <td>' .$fieldname8.'</td>
    <td>' .$fieldname9.'</td>
    <td>' .$fieldname10.'</td>
    <td>' .$fieldname11.'</td>
    <td>' .$fieldname12.'</td>
    <td>' .$fieldname13.'</td>
    <td><a href="LTOupdateform.php?userid='.urlencode($rows['USERID']).'" class="edit-btn">Edit</a></td>
    </tr>';

    
}
?>  
    </table>
<br>

    <form action="LTOsuccess.php?email=<?php echo urlencode($enteredEmail); ?>" method="post">
        <input type="submit" value="Back">
    </form>



</body>
</html>