<?php

function refreshPage()
{
  header("Refresh:0");
}

if (session_status() == PHP_SESSION_ACTIVE) {
  header("Location: index.php");
}

//Όταν πατηθεί το κουμπί Είσοδος
if (isset($_POST["Είσοδος"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  //Σύνδεση σε βάση δεδομένων
  $conn_to_db = mysqli_connect("localhost", "isper", "", "peristeris_ge");

  if (!$conn_to_db) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
  }

  // Αναζήτηση του χρήστη
  $search_db = "SELECT * FROM user WHERE username='$username'";

  $row = mysqli_query($conn_to_db, $search_db);
  // Σε περίπτωση ππου δεν βρεθεί το username στην βάση δεδομένων
  if (mysqli_num_rows($row) == 0) {
    echo "<script>alert('Δεν βρέθηκε χρήστης με αυτό το username')</script>";
    refreshPage();
  } else {
    $result = mysqli_fetch_all($row, MYSQLI_ASSOC);
    // Έλεγχος για το άνω έχει εισαχθεί το σωστό password
    if ($result["0"]["password"] == $password) {
      session_start();
      $_SESSION["name"] = $result["0"]["username"];
      $_SESSION["type"] = $result["0"]["type"];
      echo "
        <script>
          alert('Επιτυχής Είσοδος');
          window.location = 'index.php';
        </script>";
    } else {
      echo "
      <script>
        alert('Λάθος password');
        window.location = 'sign_in.php';
      </script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Είσοδος Χρήστη</title>
  <link rel="stylesheet" href="style.css" />
  <script type='text/javascript' src='validation.js'></script>
</head>

<body>

  <?php include "header.php"; ?>

  <main class="sign_in">
    <div class="box">
      <h1>Είσοδος χρήστη</h1>
      <form name="signinform" class="sign_in_form" onsubmit="return signInVal()" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />
        <div class="error" id="username_error"></div>
        <label for="password">Κωδικός Πρόσβασης:</label>
        <input type="password" id="password" name="password" required />
        <input class="link" type="submit" value="Είσοδος" name="Είσοδος" />
        <a class="link" href="sign_up.php">Εγγραφή νέου χρήστη</a>
      </form>
    </div>
  </main>

  <?php include "footer.php" ?>

</body>

</html>