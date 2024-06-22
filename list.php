<?php
session_start();

function refreshPage()
{
  header("Refresh:0");
}

// Έλεγχος για έαν υπάρχει συνδεδεμένος χρήστης για απόρριψη πρόσβασης
if (!isset($_SESSION['name'])) {
  header("Location: sign_in.php");
  die();
}

//Σύνδεση σε βάση δεδομένων
$conn_to_db = mysqli_connect("localhost", "isper", "", "peristeris_ge");

if (!$conn_to_db) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  die();
}

//Επιλογή δεδομένων συνδεδεμένου χρήστη
$name = $_SESSION['name'];
$search_db = "SELECT * FROM user WHERE username='$name' ";
$data = mysqli_query($conn_to_db, $search_db);
if (mysqli_num_rows($data) > 0) {
  $data = mysqli_fetch_all($data, MYSQLI_ASSOC);
  $user_id = $data[0]["id_xristi"];
  //Επιλογή όλων των ομαδικών λιστών εργασιών του χρήστη
  $search_db = "SELECT * FROM user_omada WHERE id_xristi='$user_id'";
  $query = mysqli_query($conn_to_db, $search_db);
  $query = mysqli_fetch_all($query, MYSQLI_ASSOC);
  $teams = [];
  // Αποθήκευση σε πίνακα
  for ($i = 0; $i < count($query); $i++) {
    array_push($teams, $query[$i]['id_omada']);
  }
  //Επιλογή όλων των προσωπικών και ατομικών λιστών του χρήστη
  $search_db = "SELECT * FROM list_ergasies WHERE id_xristi='$user_id' 
                UNION SELECT * FROM list_ergasies WHERE id_omada IN ('" . implode("','", $teams) . "')
                ORDER BY FIELD(status,'Νέα','Σε εξέλιξη','Ολοκληρωμένη')";
  $table = mysqli_query($conn_to_db, $search_db);
  $user_lists = [];
  if (mysqli_num_rows($table) > 0) {
    $user_lists = mysqli_fetch_all($table, MYSQLI_ASSOC);
    //Επιλογή όλων των προσωπικών και ατομικών εργασιών του χρήστη
    $ergasies_id = [];
    for ($i = 0; $i < count($user_lists); $i++) {
      array_push($ergasies_id, $user_lists[$i]["list_ergasia_id"]);
    }
    $ergasies_id = join(',', $ergasies_id);
    $search_db = "SELECT * FROM ergasia WHERE list_ergasia_id IN ($ergasies_id) ";
    $table_erg = mysqli_query($conn_to_db, $search_db);
    $ergasies = mysqli_fetch_all($table_erg, MYSQLI_ASSOC);
  }
  //Αποθήκευση τύπου χρήστη (user ή admin)
  $user_type = $data[0]["type"];
}

//Επιλογή όλων των εγεγγραμένων χρηστών
$users = NULL;
if ($user_type == "admin") {
  $search_db = "SELECT * FROM user";
  $users = mysqli_query($conn_to_db, $search_db);
  if (mysqli_num_rows($users) > 0) {
    $users = mysqli_fetch_all($users, MYSQLI_ASSOC);
  }
}

//Αλλαγή κατάστασης
if (isset($_POST['status'])) {
  $new_status = $_POST['status'];
  $list_ergasia_id = $_POST['list_id'];
  $query = "UPDATE list_ergasies SET status='$new_status' 
            WHERE list_ergasia_id='$list_ergasia_id'";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}

//Διαγραφή Λίστας
if (isset($_POST["delete_list"])) {
  $list_ergasia_id = $_POST['list_id'];
  $query = "DELETE FROM list_ergasies WHERE list_ergasia_id='$list_ergasia_id'";
  mysqli_query($conn_to_db, $query);
?>
  <script>
    alert("Η λίστα διαγράφηκε");
  </script>;
<?php
  refreshPage();
}

//Διαγραφή εργασίας
if (isset($_POST["delete_ergasia"])) {
  $ergasia_id = $_POST['ergasia_id'];
  $query = "DELETE FROM ergasia WHERE ergasia_id='$ergasia_id'";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}

//Προσθήκη εργασίας
if (isset($_POST["add_ergasia"])) {
  $list_ergasia_id = $_POST['list_id'];
  $ergasia_titlos = $_POST['ergasia_titlos'];
  $query = "INSERT INTO ergasia (titlos, list_ergasia_id, id_xristi) 
            VALUES ('$ergasia_titlos', '$list_ergasia_id', '$user_id')";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}

//Προσθήκη λίστας εργασιών
if (isset($_POST["add_list"])) {
  $list_titlos = $_POST['titlos'];
  $list_category = $_POST['cat'];
  $list_status = "Νέα";
  $query = "INSERT INTO list_ergasies (titlos, category, status,  id_xristi) 
  VALUES ('$list_titlos', '$list_category', '$list_status', '$user_id')";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}

//Ανάθεση ατομικής λίστας σε χρήστη
if (isset($_POST["assign_xristi"])) {
  $xristis = $_POST['xristi'];
  $list_id = $_POST['list_id'];
  $query = "UPDATE list_ergasies SET id_xristi='$xristis' WHERE list_ergasia_id='$list_id'";
  mysqli_query($conn_to_db, $query);
  $query = "UPDATE ergasia SET id_xristi='$xristis' WHERE list_ergasia_id='$list_id'";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Λίστα εργασιών</title>
  <link rel="stylesheet" href="style.css" />
  <script type='text/javascript' src='validation.js'></script>
</head>

<body>

  <?php include "header.php"; ?>

  <main class="list">
    <div class="lists">

      <?php

      //Σε περίπτωση που δεν υπάρχουν λίστες
      if (count($user_lists) == 0) {
        echo "<h1 class='null_list'>Δεν υπάρχουν Λίστες εργασιών</h1>";
      }

      function run($list, $ergasies, $user_type, $users)
      {

        echo '      <div class="list_show">
<div class="list_header">
  <div class="head">
    <h1 class="title">' . $list["titlos"] .
          '
    </h1>
        <form method="POST">
          <input type="hidden" name="list_id" value="' . $list["list_ergasia_id"] . '" />';
        //Αφαίρεση δυνατότητας διαγραφής ομαδικών λιστών απο απλούς χρήστες
        if ($user_type != "user" || $list["category"] != "Ομαδική") {
          echo '<input id="delete" type="submit" name="delete_list" value placeholder="delete">';
        }

        echo '</form>
      </div>
      <div class="dropdown">
      <form method="post" class="dropdown_in">';

        //Εμφάνιση κατηγορίας λίστας
        switch ($list["category"]) {
          case 'Εργασία':
            echo '<label> Κατηγορία:</label>
            <select class="status" id="omad" name="category">
            <option value="Εργασία" selected>Ατομική λίστα εργασίας</option>
          </select> </form>';
            break;
          case 'Ομαδική':
            echo '<label> Κατηγορία:</label>
            <select class="status" id="omad" name="category">
              <option value="Ομαδική" selected>Ομαδική λίστα εργασίας</option>
            </select> </form>';
            break;
        }

        if (($list["category"] == "Ομαδική" && $user_type == "admin")
          || $list["category"] != "Ομαδική"
        ) {

          echo '<form method="post" class="dropdown_in">';
          //Εμφάνιση ως αρχική επιλογή την τρέχουσα κατάσταση
          switch ($list["status"]) {
            case 'Νέα':
              echo '<label> Κατάσταση:</label>
            <select class="status" name="status">
              <option value="Νέα" selected>Νέα</option>
              <option value="Σε εξέλιξη">Σε εξέλιξη</option>
              <option value="Ολοκληρωμένη">Ολοκληρωμένη</option>
            </select>';
              break;
            case 'Σε εξέλιξη':
              echo '<label> Κατάσταση:</label>
            <select class="status" name="status">
              <option value="Νέα">Νέα</option>
              <option value="Σε εξέλιξη" selected>Σε εξέλιξη</option>
              <option value="Ολοκληρωμένη">Ολοκληρωμένη</option>
            </select>';
              break;
            case 'Ολοκληρωμένη':
              echo '<label> Κατάσταση:</label>
            <select class="status" name="status">
              <option value="Νέα">Νέα</option>
              <option value="Σε εξέλιξη">Σε εξέλιξη</option>
              <option value="Ολοκληρωμένη" selected>Ολοκληρωμένη</option>
            </select>';
              break;
          }
          echo ' <input type="hidden" name="list_id" value="' . $list["list_ergasia_id"] . '" />
        <input type="submit" value="Αλλαγή"/>
        </form>';
        } else {
          echo '<form method="post" class="dropdown_in">';
          echo '<label> Κατάσταση:</label>
          <select class="status" id="omad" name="category">
            <option selected>' . $list["status"] . '</option>
          </select> </form>';
          echo '</form>';
        }
        echo '</div>';


        //Ο Admin μπορεί να αναθέσει εργασίες σε άλλους χρήστες
        if ($user_type == "admin" && $list["category"] == "Εργασία") {
          echo '<div class="dropdown"> <form method="post" class="dropdown_in">';
          echo '<label> Χρήστης:</label>
            <select class="status" name="xristi">
              <option value="" disabled selected>Επιλογή χρήστη</option>';
          //Loop επανάληψης για διαθέσιμους χρήστες
          for ($i = 0; $i < count($users); $i++) {
            echo '<option value=' . $users[$i]["id_xristi"] . '>' . $users[$i]["onoma"] . '</option>';
          }

          echo '</select> <input type="hidden" name="list_id" value="' . $list["list_ergasia_id"] . '" />
        <input type="submit" name="assign_xristi" value="Ανάθεση"/>
        </form>';
          echo '</div>';
        }

        echo '</div>';

        //Loop επανάληψης για εργασίες κάθε λίστας
        for ($i = 0; $i < count($ergasies); $i++) {
          if ($ergasies[$i]["list_ergasia_id"] == $list["list_ergasia_id"]) {
            echo  '<div class="ergasia">
          <p>Εργασία: ' . $ergasies[$i]["titlos"] . '</p>
          <form method="POST">
            <input type="hidden" name="ergasia_id" value="' . $ergasies[$i]["ergasia_id"] . '" />
            <input id="delete" type="submit" name="delete_ergasia" value placeholder="delete">
          </form>
        </div>';
          }
        }

        echo ' 
        <form class="ergasia" method="post">
          <input type="hidden" name="list_id" value="' . $list["list_ergasia_id"] . '" />
          <input id="add_erg_lab" type="text" name="ergasia_titlos" maxlength="20" placeholder="Προθήκη εργασίας" required />
          <input id="add_erg" type="submit" name="add_ergasia" value placeholder="add" />
        </form> 
        </div>';
      }

      //Loop επανάληψης για λίστες του χρήστη
      for ($i = 0; $i < count($user_lists); $i++) {
        run($user_lists[$i], $ergasies, $user_type, $users);
      }

      ?>

    </div>

    <!-- Φόρμα δημιουργίας νέας λίστας -->
    <div class="list_form">
      <form name="list_name_form" onsubmit="return listNameVal()" method="post">
        <div class="error" id="list_name_error"></div>
        <input type="text" name="titlos" placeholder="Τίτλος Λίστας" required />
        <?php
        if ($user_type == "admin") { //Ο Admin μπορεί να δημιουργήσει ατομική και ομαδική λίστα
          echo ' <select name="cat">
          <option value="Εργασία">Ατομική λίστα εργασίας</option>
          <option value="Ομαδική">Ομαδική λίστα εργασίας</option>
        </select>';
        } else { //Ο user μπορεί να δημιουργήσει μόνο ατομική λίστα
          echo ' <select name="cat">
          <option value="Εργασία">Ατομική λίστα εργασίας</option>
        </select>';
        }
        ?>

        <input class="link" type="submit" name="add_list" value="Δημιουργία λίστας" />
      </form>
    </div>
  </main>

  <?php include "footer.php" ?>

</body>

</html>