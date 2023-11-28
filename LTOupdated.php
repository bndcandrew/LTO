<?php
session_start();

// Database connection
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the latest user ID
    $sqlGetLatestUserID = "SELECT TOP 1 USERID FROM USER_DATA ORDER BY USERID DESC";
    $stmtGetLatestUserID = sqlsrv_query($conn, $sqlGetLatestUserID);
    
    if ($stmtGetLatestUserID === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmtGetLatestUserID, SQLSRV_FETCH_ASSOC);
    $latestUserID = $row['USERID'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['editUserID'])) {
    $userid = $_SESSION['editUserID'];
    $lastname = $_POST['lastname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $middlename = $_POST['middlename'] ?? '';
    $street = $_POST['street'] ?? '';
    $province = $_POST['province-dropdown'] ?? '';
    $city = $_POST['city-dropdown'] ?? '';  
    $contact = $_POST['Cont'] ?? '';
    $tin = $_POST['Tin'] ?? '';
    $nationality = $_POST['Nationality'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $birthdate = $_POST['bday'] ?? '';
    $height = $_POST['height'] ?? '';
    $weight = $_POST['weight'] ?? '';

    // SQL Update query
    $sql = "UPDATE USER_DATA SET 
                LAST_NAME = ?, 
                FIRST_NAME = ?, 
                MIDDLE_NAME = ?, 
                STREET = ?,
                PROVINCE = ?, 
                CITY = ?, 
                CONTACT = ?, 
                TIN = ?, 
                NATIONALITY = ?, 
                GENDER = ?, 
                BIRTHDATE = ?, 
                HEIGHT = ?, 
                WEIGHT = ?
            WHERE USERID = ?";

    $params = [
        $lastname, 
        $firstname, 
        $middlename, 
        $street,
        $province, 
        $city,         
        $contact, 
        $tin, 
        $nationality, 
        $gender, 
        $birthdate, 
        $height, 
        $weight, 
        (INT)$userid
    ];

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Record updated successfully.";
        echo "<a href='LTOreview.php?userid=" . urlencode($userid) . "'><button>View My Updated Record</button></a>";

    }
} else {
    echo "Invalid request";
}
}
?>