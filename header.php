<?php
// Ενεργοποίηση session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<header>
    <a class="logo" href="index.php">
        <img src="images/logo.png" alt="logo" />
        <p>Πλατφόρμα διαχείρισης εργασιών</p>
    </a>
    <nav class="menu">
        <ul>
            <a href="index.php">
                <li <?php
                    // Επιλογή χρώματος border για τρέχουσα σελίδα (κεντρική)
                    if (basename($_SERVER['PHP_SELF']) == "index.php") {
                        echo 'id="current_page"';
                    }
                    ?> class="link">Αρχική</li>
            </a>
            <?php
            // Έλεγχος για τύπο συνδεδεμένου χρήστη
            if (isset($_SESSION["name"]) && ($_SESSION["type"] == "user" || $_SESSION["type"] == "admin")) {
                echo '<a href="list.php">';
                if (basename($_SERVER['PHP_SELF']) == "list.php") {
                    // Επιλογή χρώματος border για τρέχουσα σελίδα (Λίστες)
                    echo '<li id="current_page" class="link">Λίστα εργασιών</li>';
                } else {
                    echo '<li class="link">Λίστα εργασιών</li>';
                }
                echo  '</a>';
            }
            // Έλεγχος για τύπο συνδεδεμένου χρήστη
            if (isset($_SESSION["name"]) && $_SESSION["type"] == "admin") {
                echo '<a href="teams.php">';
                // Επιλογή χρώματος border για τρέχουσα σελίδα (Ομάδες)
                if (basename($_SERVER['PHP_SELF']) == "teams.php") {
                    echo '<li id="current_page" class="link">Ομάδες</li>';
                } else {
                    echo '<li class="link">Ομάδες</li>';
                }
                echo '</a>';
            }
            // Εμφάνιση username και έξοδος 
            if (isset($_SESSION['name'])) {
                $user = $_SESSION['name'];
                echo '<a href="logout.php"> <li class="link">' . $user . ' - Έξοδος </li> </a>';
            } else {
                echo '<a href="sign_in.php">';
                if (basename($_SERVER['PHP_SELF']) == "sign_in.php" || basename($_SERVER['PHP_SELF']) == "sign_up.php") {
                    echo '<li id="current_page" class="link">Είσοδος/Εγγραφή</li>';
                } else {
                    echo '<li class="link">Είσοδος/Εγγραφή</li>';
                }
                echo '</a>';
            }
            ?>
        </ul>
    </nav>
</header>