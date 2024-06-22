<?php
//Διακοπή session και redirect για είσοδο
session_start();
session_unset();
session_destroy();
header("Location: sign_in.php");
