<?php

if (isset($_POST['createAccount']))
    $jsonUserData = $_POST['createAccount'];
else if (isset($_POST['uniqueUN']))
    $sUsername = $_POST['uniqueUN'];
else if (isset($_POST['login']))
    $jsonCredentials = $_POST['login'];

if ($jsonUserData)
    $sFeedback = createAccount ($jsonUserData);
else if ($sUsername)
    $sFeedback = uniqueUN ($sUsername);
else if ($jsonCredentials)
    $sFeedback = login ($jsonCredentials);

echo $sFeedback;

function createAccount ($jsonUserData) {
    $objUserData = json_decode($jsonUserData);
    $sSQL = "INSERT INTO Users (username, password) VALUES ('" . $objUserData->username . "', '" . $objUserData->password . "')";
    return QueryDB ($sSQL);
}

function uniqueUN ($sUsername) {
    $sSQL = "SELECT * FROM Users WHERE username='" . $sUsername . "'";
    $tResult = QueryDB ($sSQL);
    return $tResult->num_rows != 0 ? true : false;
}

function login ($jsonCredentials) {
    $objCredentials = json_decode($jsonCredentials);
    $sSQL = "SELECT * FROM Users WHERE username='" . $objCredentials->un . "' AND password='" . $objCredentials->pw . "'";
    $tResult = QueryDB ($sSQL);
    return 1 == $tResult->num_rows;
}

function QueryDB ($sSQL) {
    $dbhost = 'localhost';
    $dbuser = 'jake_contacts';
    $dbpass = 'Yv9zEtKfr5yMPgkvWa4v9N';
    $db = "Contacts";
    $dbconnect = new mysqli($dbhost, $dbuser, $dbpass, $db);
    $Result = $dbconnect->query($sSQL);
    $dbconnect->close();
    return $Result;
}

?>