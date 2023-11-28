<?php

$lastnameERR = "";
$firstnameERR = "";
$streetERR = "";
$provinceERR = "";
$placeERR = "";
$contactERR = "";
$tinERR = "";
$nationalityERR = "";
$genderERR = "";
$checkboxERR = "";
$licenseERR = "";
$skillERR = "";
$educationERR = "";

if (empty($_POST['lastname'])) {
    $lastnameERR = "Lastname is required";
}
if (empty($_POST['firstname'])) {
    $firstnameERR = "Firstname is required";
}
if (empty($_POST['street'])) {
    $streetERR = "Address is required";
}
if (empty($_POST['province-dropdown'])) {
    $provinceERR = "Province is required";
}
if (empty($_POST['city-dropdown'])) {
    $placeERR = "City is required";
}
if (empty($_POST['Cont'])) {
    $contactERR = "Contact is required";
}
if (empty($_POST['Tin'])) {
    $tinERR = "Tin is required";
}
if (empty($_POST['Nationality'])) {
    $nationalityERR = "Nationality is required";
}
if (empty($_POST['gender'])) {
    $genderERR = "Gender is required";
}

if (!isset($_POST['app'])) {
    $checkboxERR = "At least one type of application must be selected";
}
if (isset($_POST['license'])) {
    $LICENSE = $_POST['license'];
} else {
    $licenseERR = "License type is required";
}

if (isset($_POST['skill'])) {
    $SKILL = $_POST['skill'];
} else {
    $skillERR = "Skill is required";
}


if (isset($_POST['ea'])) {
    $EDUC = $_POST['ea'];
} else {
    $educationERR = "Education is required";
}


if (
    $lastnameERR == "" &&
    $firstnameERR == "" &&
    $streetERR == "" &&
    $provinceERR == "" &&
    $placeERR == "" &&
    $contactERR == "" &&
    $tinERR == "" &&
    $nationalityERR == "" &&
    $genderERR == "" &&
    $checkboxERR == "" &&
    $licenseERR == "" &&
    $skillERR == "" &&
    $educationERR == ""
) {
    $serverName = "DESKTOP-I0HTBLL\\SQLEXPRESS";
    $connectionOptions = [
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    ];
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo 'Connection Success' . "<br>";
    }

    // User Data
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $street = $_POST['street'];
    $province = $_POST['province-dropdown'];
    $city = $_POST['city-dropdown'];
    $Pcontact = $_POST['Cont'];
    $tin = $_POST['Tin'];
    $nationality = $_POST['Nationality'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['bday'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    // Application Details
    $a = isset($_POST['app']) && $_POST['app'] === 'A' ? 1 : 0;
    $b = isset($_POST['app']) && $_POST['app'] === 'B' ? 1 : 0;
    $c1 = isset($_POST['app']) && $_POST['app'] === 'C1' ? 1 : 0;
    $c2 = isset($_POST['app']) && $_POST['app'] === 'C2' ? 1 : 0;
    $d = isset($_POST['app']) && $_POST['app'] === 'D' ? 1 : 0;
    $e = isset($_POST['app']) && $_POST['app'] === 'E' ? 1 : 0;
    $f = isset($_POST['app']) && $_POST['app'] === 'F' ? 1 : 0;
    $g = isset($_POST['app']) && $_POST['app'] === 'G' ? 1 : 0;
    $h = isset($_POST['app']) && $_POST['app'] === 'H' ? 1 : 0;
    $h1 = isset($_POST['app']) && $_POST['app'] === 'H1' ? 1 : 0;
    $h2 = isset($_POST['app']) && $_POST['app'] === 'H2' ? 1 : 0;
    $h3 = isset($_POST['app']) && $_POST['app'] === 'H3' ? 1 : 0;
    $h4 = isset($_POST['app']) && $_POST['app'] === 'H4' ? 1 : 0;
    $h5 = isset($_POST['app']) && $_POST['app'] === 'H5' ? 1 : 0;
    $LICENSE = $_POST['license'];
    $SKILL = $_POST['skill'];
    $EDUC = $_POST['ea'];

    // User Bio
    $civilstatus = $_POST['cs'];
    $hair = $_POST['hair'];
    $eyes = $_POST['eyes'];
    $bloodtype = $_POST['blood'];
    $organdonor = $_POST['organdonor'];
    $built = $_POST['built'];
    $complexion = $_POST['complexion'];
    $birthplaceprovince = $_POST['province-dropdown2'];
    $birthplacecity = $_POST['city-dropdown2'];
    $fatherslastname = $_POST['lastnamefather'];
    $fathersfirstname = $_POST['firstnamefather'];
    $fathersmiddlename = $_POST['middlenamefather'];
    $motherslastname = $_POST['lastnamemother'];
    $mothersfirstname = $_POST['firstnamemother'];
    $mothersmiddlename = $_POST['middlenamemother'];
    $spouselastname = $_POST['lastnamespouse'];
    $spousefirstname = $_POST['firstnamespouse'];
    $spousemiddlename = $_POST['middlenamespouse'];


    //WORK
    $businessname = $_POST['businessname'];
    $businessnumber = $_POST['businessnumber'];
    $businessprovince = $_POST['province-dropdown3'];
    $businesscity = $_POST['city-dropdown3'];
    $prevlastname = isset($_POST['Lastnameprev']) ? $_POST['Lastnameprev'] : 'none';
    $prevfirstname = isset($_POST['Firstnameprev']) ? $_POST['Firstnameprev'] : 'none';
    $prevmiddlename = isset($_POST['Middlenameprev']) ? $_POST['Middlenameprev'] : 'none';
    $signature = $_POST['signaturecert'];
    $sourceQuery1 = "SELECT MAX(USERID) AS LatestUserID FROM USER_DATA"; 
    $sourceResult1 = sqlsrv_query($conn, $sourceQuery1);


    //USER ID
if ($sourceResult1 === false) {
    die(print_r(sqlsrv_errors(), true));
    }
    
    $row1 = sqlsrv_fetch_array($sourceResult1, SQLSRV_FETCH_ASSOC);
    $latestUserID = $row1['LatestUserID'];
       
    if ($latestUserID === null) {
        $userID = 100;
    } else {
            $userID = $latestUserID + 1;
    }

    // For applicationID
    $sourceQuery2 = "SELECT MAX(APPLICATIONID) AS LatestApplicationID FROM APPLICATION_DETAILS"; 
    $Resultappid = sqlsrv_query($conn, $sourceQuery2);
    
    if ($Resultappid === false) {
    die(print_r(sqlsrv_errors(), true));
    }
    
    $row2 = sqlsrv_fetch_array($Resultappid, SQLSRV_FETCH_ASSOC);
    $latestApplicationID = $row2['LatestApplicationID'];
       
    if ($latestApplicationID === null) {
        $applicationID = 300;
    } else {
        $applicationID = $latestApplicationID + 1;
        }

//USER DATA
$sql = "INSERT INTO USER_DATA(LAST_NAME, FIRST_NAME, MIDDLE_NAME, STREET, PROVINCE, CITY, CONTACT, TIN, NATIONALITY, GENDER, BIRTHDATE, HEIGHT, WEIGHT) VALUES ('$lastname', '$firstname', '$middlename', '$street', '$province', '$city', '$Pcontact', '$tin', '$nationality', '$gender', '$birthdate', '$height', '$weight')";
$results = sqlsrv_query($conn, $sql);


//APPLICATION DETAILS
$sql2 = "INSERT INTO APPLICATION_DETAILS (USERID, A, B, C1, C2, D, E, F, G, H, H1, H2, H3, H4, H5, LICENSE_TYPE, SKILL_ACQUIRED, EDUC) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$params = [
    $userID,
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
    $LICENSE,
    $SKILL,
    $EDUC
];

$stmt = sqlsrv_prepare($conn, $sql2, $params);
$results = sqlsrv_execute($stmt);


//User Bio
$sql3 = "INSERT INTO USER_BIO ( CIVIL_STATUS, HAIR, EYES, BLOOD_TYPE, ORGAN_DONOR, BUILT, COMPLEXION, USERID, APPLICATIONID, BIRTHPLACE_PROVINCE, BIRTHPLACE_CITY, FATHER_LASTNAME, FATHER_FIRSTNAME, FATHER_MIDDLENAME, MOTHER_LASTNAME, MOTHER_FIRSTNAME, MOTHER_MIDDLENAME, SPOUSE_LASTNAME, SPOUSE_FIRSTNAME, SPOUSE_MIDDLENAME) VALUES ('$civilstatus', '$hair', '$eyes', '$bloodtype', '$organdonor', '$built', '$complexion', '$userID', '$applicationID','$birthplaceprovince', '$birthplacecity', '$fatherslastname', '$fathersfirstname', '$fathersmiddlename', '$motherslastname', '$mothersfirstname', '$mothersmiddlename','$spouselastname','$spousefirstname', '$spousemiddlename')";
$results = sqlsrv_query($conn, $sql3);

//WORK_DATA
$sql4 = "INSERT INTO WORK(USERID,BUSINESS_NAME, BUSINESS_PROVINCE, BUSINESS_CITY, BUSINESS_NUMBER, PREVIOUS_LASTNAME, PREVIOUS_FIRSTNAME, PREVIOUS_MIDDLENAME, SIGNATURE) VALUES ('$userID','$businessname','$businessprovince','$businesscity', '$businessnumber','$prevlastname','$prevfirstname','$prevmiddlename', '$signature')";
$results = sqlsrv_query($conn, $sql4);

if ($results) {
    echo 'Registration Successful';
    header("Location: LTOreview.html");
    exit();
} else {
    echo 'Error';
    die(print_r(sqlsrv_errors(), true));
}
    
}  
    
echo $lastnameERR . "<br>";
echo $firstnameERR . "<br>";    
echo $streetERR . "<br>";
echo $provinceERR . "<br>";
echo $placeERR . "<br>";
echo $contactERR . "<br>";
echo $tinERR . "<br>";
echo $nationalityERR . "<br>";
echo $genderERR . "<br>";
echo $checkboxERR . "<br>";
echo $licenseERR . "<br>";
echo $skillERR . "<br>";
echo $educationERR . "<br>";

?>
