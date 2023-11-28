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

// Assuming 'A', 'B', 'C1', 'C2', etc. are the TOA choices
$a = isset($_POST['A']) ? 1 : 0;
$b = isset($_POST['B']) ? 1 : 0;
$c1 = isset($_POST['C1']) ? 1 : 0;
$c2 = isset($_POST['C2']) ? 1 : 0;
$d = isset($_POST['D']) ? 1 : 0;
$e = isset($_POST['E']) ? 1 : 0;
$f = isset($_POST['F']) ? 1 : 0;
$g = isset($_POST['G']) ? 1 : 0;
$h = isset($_POST['H']) ? 1 : 0;
$h1 = isset($_POST['H1']) ? 1 : 0;
$h2 = isset($_POST['H2']) ? 1 : 0;
$h3 = isset($_POST['H3']) ? 1 : 0;
$h4 = isset($_POST['H4']) ? 1 : 0;
$h5 = isset($_POST['H5']) ? 1 : 0;

// SQL Update query
$sql = "UPDATE APPLICATION_DETAILS SET 
            A = ?, 
            B = ?, 
            C1 = ?,
            C2 = ?,
            D = ?,
            E = ?,
            F = ?,
            G = ?,
            H = ?,
            H1 = ?,
            H2 = ?,
            H3 = ?,
            H4 = ?,
            H5 = ?
        WHERE USERID = ?";

$params = [
    $a, 
    $b, 
    $c1, 
    $c2, 
    $d, 
    $e, 
    $f, 
    $g, 
    $h, 
    $h1, 
    $h2, 
    $h3, 
    $h4, 
    $h5, 
    $userid
];


    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "TOA Record updated successfully. <br>";
        echo "<a href='LTOreview.php?userid=" . urlencode($userid) . "'><button>Back to Update Form</button></a>";
    }
} else {
    echo "Invalid request";
}
?>
