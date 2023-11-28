<?php
session_start();

// Database connection
$serverName = "DESKTOP-I0HTBLL\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if the form was submitted and the session user ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['editUserID'])) {
    $userid = $_SESSION['editUserID'];

    $LICENSE = $_POST['license'];
    

// SQL Update query
$sql = "UPDATE APPLICATION_DETAILS SET 
            LICENSE_TYPE = ?
        WHERE USERID = ?";

$params = [
    $LICENSE, 
    $userid
];


    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "License Record updated successfully. <br>";
        echo "<a href='LTOreview.php?userid=" . urlencode($userid) . "'><button>Back to Update Form</button></a>";
    }
} else {
    echo "Invalid request";
}
?>
