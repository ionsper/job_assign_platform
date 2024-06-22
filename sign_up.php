<?php

//Λήψη δεδομένων που εισήγαγε ο χρήστης
if (isset($_POST["Εγγραφή"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $password_ver = $_POST["password_ver"];

  //Σύνδεση σε βάση δεδομένων
  $conn_to_db = mysqli_connect("localhost", "isper", "", "peristeris_ge");

  if (!$conn_to_db) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

  //Αναζήτηση στη βάση δεδομένων για το έαν υφίσταται ήδη ο χρήστης
  $search_db = "SELECT username FROM user WHERE username='$username'";
  $result = mysqli_query($conn_to_db, $search_db);

  if (mysqli_num_rows($result) > 0) {
    echo "
    <script>
      alert('Ο χρήστης υπάρχει ήδη');
    </script>";
  } else {
    //Εγγραφή χρήστη στη βάση δεδομένων
    $insert_to_db = "INSERT INTO user (onoma, email, username, password, type) 
                VALUES ('$name','$email','$username','$password','user')";

    //Με την επιτυχή εγγραφή εμφάνιση μηνύματος και redirect στην είσοδο
    if (mysqli_query($conn_to_db, $insert_to_db)) {
      echo '<script>alert("Επιτυχής Εγγραφή, μπορείτε να συνδεθείτε.");
    window.location = "sign_in.php";</script>';
    } else {
      echo "Error:" . mysqli_error($conn_to_db);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Εγγραφή Χρήστη</title>
  <link rel="stylesheet" href="style.css" />
  <script type='text/javascript' src='validation.js'></script>
</head>

<body>

  <?php include "header.php"; ?>

  <main class="sign_up">
    <div class="box">
      <h1>Εγγραφή χρήστη</h1>
      <form name="signupform" class="sign_up_form" onsubmit="return signUpVal()" method="POST">
        <label for="name">Όνοματεπώνυμο:</label>
        <input type="text" id="name" name="name" required />
        <div class="error" id="name_error"></div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
        <div class="error" id="email_error"></div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />
        <div class="error" id="username_err"></div>
        <label for="password">Κωδικός Πρόσβασης:</label>
        <input type="password" id="password" name="password" required />
        <div class="error" id="password_err"></div>
        <label for="password_ver">Επιβεβαίωση κωδικού:</label>
        <input type="password" id="password_ver" name="password_ver" required />
        <div class="error" id="password_ver_err"></div>
        <input class="link" type="submit" value="Εγγραφή" name="Εγγραφή" />
      </form>
    </div>
  </main>

  <?php include "footer.php" ?>

</body>

</html>