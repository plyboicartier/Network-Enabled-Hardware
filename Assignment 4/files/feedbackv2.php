<!--
    Carter Glynn 8657212
    PROG 2607 - Network Enabled Hardware
    2023-02-13
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - DCA</title>
	<link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="../styles.css">
  </head>
  
  <body>
		<nav>
            <ul class="lnav">
                <li class="lnav-item"><div class="nav-logo"><a href="../index.html"><img src="../images/DCA_logo.png" alt="logo"></a></div></li>
                <li class="lnav-item"><div class="nav-name"><a href="../index.html">DCA</a></div></li>
            </ul>
            <ul class="rnav">
                <li class="rnav-item"><a href="projects.html">PROJECTS</a></li>
                <li class="rnav-item"><a href="about.html">ABOUT</a></li>
                <li class="rnav-item"><a href="feedback.html">FEEDBACK (CSV)</a></li>
                <li class="rnav-item"><a href="feedbackv2.php">FEEDBACK (SSV)</a></li>
            </ul>
        </nav>
        <form method="post" novalidate>
            <div class="wrapper">
                <div class="container">
                    <div class="contact">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" autofocus="on" placeholder="Ex. John Appleseed">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" placeholder="Ex. johnnyapplez@conestogac.on.ca">
                        <label for="code">Postal Code:</label>
                        <input type="text" id="code" name="postal_code" placeholder="Ex. A1A1A1 (must follow the letter/number pattern)">
                    </div>
                    <div class="message">
                        <label for="msg">Message</label>
                        <textarea id="msg" name="message" placeholder="Leave comments here!"></textarea>
                    </div>
                </div>
                <div class="buttons">
                    <input type="submit">
                    <input type="reset" value="Clear">
                    <input type="button" onclick="window.location.href='table.php';" value="View Table" />
                </div>
            </div>
          </form>
        <footer>
            &copy; 2023 DCA, Inc. All rights reserved.
        </footer>
        <?php
        function ErrorCheck() {
            $check = true;
            if(empty($_POST['name'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Name field must not be empty.</div>";
                $check = false;
            }
            if(preg_match("/^[0-9]$/", $_POST['name'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Name field must not have numbers.</div>";
                $check = false;
            }
            if(empty($_POST['email'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Email field must not be empty.</div>";
                $check = false;
            }
            if(!preg_match("/^[a-zA-Z0-9._%+-]+@conestogac\.on\.ca$/", $_POST['email'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Email must be @conestogac.on.ca</div>";
                $check = false;
            }
            if(empty($_POST['postal_code'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Postal Code field must not be empty.</div>";
                $check = false;
            }
            if(!preg_match("/^[A-Za-z][0-9][A-Za-z][0-9][A-Za-z][0-9]$/", $_POST['postal_code'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Postal code must match format</div>";
                $check = false;
            } 
            if(strlen($_POST['message']) > 200) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Message length exceeds 200 characters</div>";
                $check = false;
            }
            return $check;
        }
        if($_SERVER['REQUEST_METHOD']=="POST") {    // stops error messages from happenning if the form hasn't been submitted yet
            $check = ErrorCheck();

            if ($check === false) {
                die;
            }
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);

            try
            {
            //open the database
            $db = new PDO('sqlite:feedback.db');
            $name = $_POST['name'];
            $email = $_POST['email'];
            $postal_code = $_POST['postal_code'];
            $message = $_POST['message'];

            $insert = $db->prepare('INSERT INTO feedback (name, email, postal_code, message) VALUES (?, ?, ?, ?)');
            $insert->execute([$name, $email, $postal_code, $message]);
            
            $db = NULL;
            }
            catch(PDOException $e)
            {
            print 'Exception : ' .$e->getMessage();
            }
        }
        ?>
  </body>
</html>