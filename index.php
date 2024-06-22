<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Πλατφόρμα διαχείρισης εργασιών</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <?php include "header.php"; ?>

  <main class="index">
    <div id="welcome">
      <h1>Καλωσορίσατε στην Πλατφόρμα Διαχείρισης Εργασιών</h1>
      <h2>
        Με την νέα πλατφόρμα μας μπορείτε να δημιουργήσετε, επεξεργαστείτε και
        να παρακολουθείσετε τις λίστες εργασιών σας ατομικά ή με την ομάδα
        σας!
      </h2>
    </div>
    <div id="main_images">
      <img src="images/platform.png" alt="platform" />
      <img src="images/team.png" alt="team" />
    </div>
    <div>
      <?php
      // Έλεγχος για έαν υπάρχει συνδεδεμένος χρήστης
      if (!isset($_SESSION['name'])) {
        echo '<a class="link" href="sign_in.php">Είσοδος</a>';
        echo '<a class="link" href="sign_up.php">Εγγραφή</a>';
      } elseif ($_SESSION["type"] == "admin") {
        echo '<a class="link" href="xml_export.php">XML export</a>';
      }
      ?>
    </div>
  </main>

  <?php include "footer.php" ?>

</body>

</html>