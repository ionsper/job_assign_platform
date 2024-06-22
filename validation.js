function signInVal() {
    let username = document.forms["signinform"]["username"].value;
    //Έλεγχος μήκους username για είσοδο
    if (username.length > 8) {
        document.getElementById('username_error').innerHTML="To username δεν μπορεί να υπερβαίνει τους 8 χαρακτήρες";
        return false;
      } else if (username.length < 4) {
        document.getElementById('username_error').innerHTML="To username δεν μπορεί να είναι μικρότερο από 4 χαρακτήρες";
        return false;
      }
    }

    function signUpVal() {
        let name = document.forms["signupform"]["name"].value;
        //Έλεγχος μήκους ονοματεπωνύμου για εγγραφή
        if (name.length > 30) {
            document.getElementById('name_error').innerHTML="To Ονοματεπώνυμο δεν μπορεί να υπερβαίνει τους 30 χαρακτήρες";
            return false;
          } else if (name.length < 10) {
            document.getElementById('name_error').innerHTML="To Ονοματεπώνυμο δεν μπορεί να είναι μικρότερο από 10 χαρακτήρες";
            return false;
          }
          //Έλεγχος μήκους email για εγγραφή
          let email = document.forms["signupform"]["email"].value;
          if (email.length > 30) {
            document.getElementById('email_error').innerHTML="To email δεν μπορεί να υπερβαίνει τους 30 χαρακτήρες";
            return false;
          } else if (email.length < 10) {
            document.getElementById('email_error').innerHTML="To email δεν μπορεί να είναι μικρότερο από 10 χαρακτήρες";
            return false;
          }
          //Έλεγχος μήκους username για εγγραφή
          let username = document.forms["signupform"]["username"].value;
          if (username.length > 8) {
              document.getElementById('username_err').innerHTML="To username δεν μπορεί να υπερβαίνει τους 8 χαρακτήρες";
              return false;
            } else if (username.length < 4) {
              document.getElementById('username_err').innerHTML="To username δεν μπορεί να είναι μικρότερο από 4 χαρακτήρες";
              return false;
            }
          //Έλεγχοι password
          let password = document.forms["signupform"]["password"].value;
          //Έλεγχος μήκους password για εγγραφή
          if (password.length > 20) {
              document.getElementById('password_err').innerHTML="To password δεν μπορεί να υπερβαίνει τους 20 χαρακτήρες";
              return false;
            } else if (password.length < 8) {
              document.getElementById('password_err').innerHTML="To password δεν μπορεί να είναι μικρότερο από 8 χαρακτήρες";
              return false;
            }
          //Έλεγχος εάν το password περιέχει αριθμό
          if (!/\d/.test(password)) {
            document.getElementById('password_err').innerHTML="To password πρέπει να περιέχει τουλάχιστον έναν αριθμό";
            return false;
          }
          //Έλεγχος εάν το password περιέχει κεφαλαίο γράμμα
          let check = false;
          for (let index = 0; index < password.length; index++) {
            if (password[index] == password[index].toUpperCase() && isNaN(password[index])) {
              check = true;
            }
          }
          if (!check) {
            document.getElementById('password_err').innerHTML="To password πρέπει να περιέχει τουλάχιστον ένα κεφαλαίο γράμμα";
            return false;
          }
          //Έλεγχος εάν το password είναι το ίδιο
          let passwordVer = document.forms["signupform"]["password_ver"].value;
          if (password != passwordVer) {
            document.getElementById('password_ver_err').innerHTML="To password δεν είναι το ίδιο";
            return false;
          }
        }

        function listNameVal(){
          let titlos = document.forms["list_name_form"]["titlos"].value;
          //Έλεγχος μήκους τίτλου λίστας
          if (titlos.length > 20) {
              document.getElementById('list_name_error').innerHTML="Επιτρέπονται μέχρι 20 χαρακτήρες";
              return false;
            } else if (titlos.length < 4) {
              document.getElementById('list_name_error').innerHTML="Ο τίτλος θα πρέπει να έιναι τουλάχιστον 4 χαρακτήρες";
              return false;
            }
        }

        function teamAddVal(){
          let team_name = document.forms["team_name_form"]["onoma"].value;
          //Έλεγχος μήκους τίτλου ομάδας
          if (team_name.length > 20) {
              document.getElementById('team_name_error').innerHTML="Επιτρέπονται μέχρι 20 χαρακτήρες";
              return false;
            } else if (team_name.length < 4) {
              document.getElementById('team_name_error').innerHTML="Ο τίτλος θα πρέπει να έιναι τουλάχιστον 4 χαρακτήρες";
              return false;
            }
        }