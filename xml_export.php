<!DOCTYPE html>
<html lang="en">

<?php
session_start();

function refreshPage()
{
    header("Refresh:0");
}

if (!isset($_SESSION['name'])) {
    header("Location: sign_in.php");
    die();
}

if ($_SESSION["type"] != "admin") {
    echo '<script>alert("Απαγορεύεται η πρόσβαση");
  window.location = "index.php";</script>';
    die();
}
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Πλατφόρμα διαχείρισης εργασιών</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include "header.php"; ?>

    <main class="xml_export">

        <?php

        $conn_to_db = mysqli_connect("localhost", "isper", "", "peristeris_ge");
        if (!$conn_to_db) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        //Λήψη όλων των ομάδων απο την βάση δεδομένων
        $search_db = "SELECT * FROM omada";
        $teams = mysqli_query($conn_to_db, $search_db);
        if (mysqli_num_rows($teams) > 0) {
            $teams = mysqli_fetch_all($teams, MYSQLI_ASSOC);
        } else {
            $teams = NULL;
        }
        //Λήψη όλων των συσχετίσεων χρηστών με ομάδες απο την βάση δεδομένων
        $search_db = "SELECT * FROM user_omada";
        $user_omada = mysqli_query($conn_to_db, $search_db);
        if (mysqli_num_rows($user_omada) > 0) {
            $user_omada = mysqli_fetch_all($user_omada, MYSQLI_ASSOC);
        } else {
            $user_omada = NULL;
        }
        //Λήψη όλων των χρηστών απο την βάση δεδομένων
        $users = NULL;
        $search_db = "SELECT * FROM user";
        $users = mysqli_query($conn_to_db, $search_db);
        if (mysqli_num_rows($users) > 0) {
            $users = mysqli_fetch_all($users, MYSQLI_ASSOC);
        }
        //Λήψη όλων των ομαδικών λιστών απο την βάση δεδομένων
        $search_db = "SELECT * FROM list_ergasies WHERE category='Ομαδική'";
        $lists = mysqli_query($conn_to_db, $search_db);
        if (mysqli_num_rows($lists) > 0) {
            $lists = mysqli_fetch_all($lists, MYSQLI_ASSOC);
        } else {
            $lists = NULL;
        }
        //Λήψη όλων των εργασιών
        $search_db = "SELECT * FROM ergasia";
        $ergasies = mysqli_query($conn_to_db, $search_db);
        if (mysqli_num_rows($ergasies) > 0) {
            $ergasies = mysqli_fetch_all($ergasies, MYSQLI_ASSOC);
        } else {
            $ergasies = NULL;
        }


        //Δημιουργία DTD
        $build_xml = "
        <!DOCTYPE info[ 
        <!ELEMENT info (omades*)>
        <!ELEMENT omades (onoma_omadas, users*, lists*)>
        <!ELEMENT onoma_omadas (#PCDATA)> 
        <!ELEMENT users (onoma, email, username)> 
        <!ELEMENT onoma (#PCDATA)> 
        <!ELEMENT email (#PCDATA)> 
        <!ELEMENT username (#PCDATA)> 
        <!ELEMENT lists (titlos, category, status, ergasies*)> 
        <!ELEMENT titlos (#PCDATA)> 
        <!ELEMENT category (#PCDATA)> 
        <!ELEMENT status (#PCDATA)> 
        <!ELEMENT ergasies (ergasia*)> 
        <!ELEMENT ergasia (#PCDATA)> 
        ]>";

        //Δημιουργία ΧΜL
        $build_xml .= "<info>";

        for ($team = 0; $team < count($teams); $team++) {
            $build_xml .= "<omades>";
            $build_xml .= "<onoma_omadas>" . $teams[$team]['onoma_omadas'] . "</onoma_omadas>";
            for ($y = 0; $y < count($user_omada); $y++) {
                if ($teams[$team]['id_omada'] == $user_omada[$y]['id_omada']) {
                    for ($user = 0; $user < count($users); $user++) {
                        if ($user_omada[$y]['id_xristi'] == $users[$user]['id_xristi']) {
                            $build_xml .= "<users>";
                            $build_xml .= "<onoma>" . $users[$user]['onoma'] . "</onoma>";
                            $build_xml .= "<email>" . $users[$user]['email'] . "</email>";
                            $build_xml .= "<username>" . $users[$user]['username'] . "</username>";
                            $build_xml .= "</users>";
                        }
                    }
                }
            }
            for ($list = 0; $list < count($lists); $list++) {
                if ($teams[$team]['id_omada'] == $lists[$list]['id_omada']) {
                    $build_xml .= "<lists>";
                    $build_xml .= "<titlos>" . $lists[$list]['titlos'] . "</titlos>";
                    $build_xml .= "<category>" . $lists[$list]['category'] . "</category>";
                    $build_xml .= "<status>" . $lists[$list]['status'] . "</status>";
                    $build_xml .= "<ergasies>";
                    for ($ergasia = 0; $ergasia < count($ergasies); $ergasia++) {
                        if ($lists[$list]['list_ergasia_id'] == $ergasies[$ergasia]['list_ergasia_id']) {

                            $build_xml .= "<ergasia>" . $ergasies[$ergasia]['titlos'] . "</ergasia>";
                        }
                    }
                    $build_xml .= "</ergasies>";
                    $build_xml .= "</lists>";
                }
            }
            $build_xml .= "</omades>";
        }
        $build_xml .= "</info>";


        //Έλεγχος παραγόμενου XML με βάση το DTD
        $info = new DOMDocument();
        $info->loadXML($build_xml);
        if (!$info->validate()) {
            echo "Το αρχείο δεν είναι έγκυρο";
        }

        //Λήψη κανόνων εμφάνισης απο το xsl αρχείο
        $xsl = new DOMDocument;
        $xsl->load('xml_display.xsl');
        $proc = new XSLTProcessor();
        $proc->importStyleSheet($xsl);

        //Εμφάνιση xml αρχείου με τους κανόνες xsl
        echo $proc->transformToXML($info);

        //Αποθήκευση XML αρχείου 	 
        $info->save('arxeio.xml');
        echo "<a class='link' href='arxeio.xml' target='_blank'>Download Αρχείο XML</a>";
        echo "<br>";
        ?>

    </main>
    <?php include "footer.php" ?>

    <body>