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

//Σύνδεση σε βάση δεδομένων
$conn_to_db = mysqli_connect("localhost", "isper", "", "peristeris_ge");

if (!$conn_to_db) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  die();
}

//Λήψη όλων των χρηστών απο την βάση δεδομένων
$users = NULL;
$search_db = "SELECT * FROM user";
$users = mysqli_query($conn_to_db, $search_db);
if (mysqli_num_rows($users) > 0) {
  $users = mysqli_fetch_all($users, MYSQLI_ASSOC);
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

//Λήψη όλων των ομαδικών λιστών απο την βάση δεδομένων
$search_db = "SELECT * FROM list_ergasies WHERE category='Ομαδική'";
$lists = mysqli_query($conn_to_db, $search_db);
if (mysqli_num_rows($lists) > 0) {
  $lists = mysqli_fetch_all($lists, MYSQLI_ASSOC);
} else {
  $lists = NULL;
}

//Προσθήκη νέας ομάδας
if (isset($_POST["add_team"])) {
  $list_onoma = $_POST['onoma'];
  $query = "INSERT INTO omada (onoma_omadas) VALUES ('$list_onoma')";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}

//Προσθήκη νέου μέλους στην ομάδα
if (isset($_POST["add_melos"])) {
  $melos_id = $_POST['melos'];
  $team_id = $_POST['team_id'];
  $query = "SELECT * FROM user_omada WHERE id_xristi='$melos_id' AND id_omada='$team_id'";
  $query = mysqli_query($conn_to_db, $query);
  if (mysqli_num_rows($query) == 0) {
    $query = "INSERT INTO user_omada (id_xristi,id_omada) 
                  VALUES ('$melos_id', '$team_id')";
    mysqli_query($conn_to_db, $query);
  }
  refreshPage();
}

//Ανάθεση λίστας σε ομάδα
if (isset($_POST["assign_list"])) {
  $team_id = $_POST['team_id'];
  $list_id = $_POST['list'];
  $query = "UPDATE list_ergasies SET id_omada='$team_id' WHERE list_ergasia_id='$list_id'";
  mysqli_query($conn_to_db, $query);
  refreshPage();
}

function get_names($id_xristi, $conn_to_db)
{
  $user_by_team = NULL;
  $search_db = "SELECT * FROM user WHERE id_xristi='$id_xristi'";
  $user_by_team = mysqli_query($conn_to_db, $search_db);
  $user_by_team = mysqli_fetch_all($user_by_team, MYSQLI_ASSOC);
  return $user_by_team[0]['onoma'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ομάδες</title>
  <link rel="stylesheet" href="style.css" />
  <script type='text/javascript' src='validation.js'></script>
</head>

<body>

  <?php include "header.php"; ?>

  <main class="team">
    <div class="teams">

      <?php
      function run($teams, $team, $user_omada, $users, $lists, $conn_to_db)
      {
        echo "
      
      <div class='team_show'>
        <div class='team_head'>
          <h1 class='title'>" . $teams[$team]['onoma_omadas'] . "</h1>
        </div>
        <div class='team_sub_box'>
          <h2>Μέλη</h2>";

        if ($user_omada == NULL) {
          //Έλεγχος για ύπαρξη συσχετίσεων
        } else {
          for ($y = 0; $y < count($user_omada); $y++) {
            if ($teams[$team]['id_omada'] == $user_omada[$y]['id_omada']) {
              echo "<div class='team_sub_box_names'>";
              echo "<p>" . get_names($user_omada[$y]['id_xristi'], $conn_to_db) . "</p>";
              echo "</div>";
            }
          }
        }

        echo "
          <div>
            <form class='team_sub_box_form' method='post'>
              <select name='melos'>
                <option value='' disabled selected>Προσθήκη Μέλους</option>";
        //Εμφάνιση των χρηστών
        for ($i = 0; $i < count($users); $i++) {
          echo '<option value=' . $users[$i]["id_xristi"] . '>' . $users[$i]["onoma"] . '</option>';
        }

        echo "
              </select>
              <input type='hidden' name='team_id' value='" . $teams[$team]['id_omada'] . "' />
              <input id='add_erg' type='submit' name='add_melos' value placeholder='add' />
            </form>
          </div>
        </div>
        <div class='team_sub_box'>
          <h2>Λίστες εργασιών</h2>";

        if ($lists == NULL) {
          //Έλεγχος για ύπαρξη συσχετίσεων
        } else {
          for ($i = 0; $i < count($lists); $i++) {
            if ($teams[$team]['id_omada'] == $lists[$i]['id_omada']) {
              echo "<div class='team_sub_box_names'>";
              echo "<p>" . $lists[$i]['titlos'] . "</p>";
              echo "</div>";
            }
          }
        }


        echo "<div>
            <form class='team_sub_box_form' method='post'>
              <select name='list'>
                <option value='' disabled selected>Ανάθεση Ομαδικής Λίστας</option>";
        if ($lists == NULL) {
          //Έλεγχος για ύπαρξη συσχετίσεων
        } else {
          for ($i = 0; $i < count($lists); $i++) {
            if ($teams[$team]['id_omada'] != $lists[$i]['id_omada']) {
              echo "<option value=" . $lists[$i]['list_ergasia_id'] . ">" . $lists[$i]['titlos'] . "</option>";
            }
          }
        }
        echo " </select>
              <input type='hidden' name='team_id' value='" . $teams[$team]['id_omada'] . "' />
              <input id='add_erg' type='submit' name='assign_list' value placeholder='assign' />
            </form>
          </div>
        </div>
      </div>";
      }

      if ($teams == NULL) {
        echo "<h1 class='null_list'>Δεν υπάρχουν Ομάδες</h1>";
      } else {
        for ($i = 0; $i < count($teams); $i++) {
          run($teams, $i, $user_omada, $users, $lists, $conn_to_db);
        }
      }
      ?>
    </div>

    <div class="team_form">
      <form name="team_name_form" onsubmit="return teamAddVal()" method="post">
        <div class="error" id="team_name_error"></div>
        <input type="text" name="onoma" placeholder="Τίτλος νέας Ομάδας" required />
        <input class="link" type="submit" name="add_team" value="Δημιουργία Ομάδας" />
      </form>
    </div>

  </main>

  <?php include "footer.php" ?>

</body>

</html>