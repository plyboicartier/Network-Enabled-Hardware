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
                <li class="rnav-item"><a href="feedback.html">FEEDBACK</a></li>
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
                        <input type="text" id="code" name="code" placeholder="Ex. A1A1A1 (must follow the letter/number pattern)">
                    </div>
                    <div class="message">
                        <label for="msg">Message</label>
                        <textarea id="msg" name="message" placeholder="Leave comments here!"></textarea>
                    </div>
                </div>
                <div class="buttons">
                    <input type="submit">
                    <input type="reset" value="Clear">
                </div>
            </div>
          </form>
        <footer>
            &copy; 2023 DCA, Inc. All rights reserved.
        </footer>
        <?php
        if($_SERVER['REQUEST_METHOD']=="POST") {    // stops error messages from happenning if the form hasn't been submitted yet

            if(empty($_POST['name'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Name field must not be empty.</div>";
            }
            if(empty($_POST['email'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Email field must not be empty.</div>";
            }
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@conestogac\.on\.ca$/", $_POST['email'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Email must be @conestogac.on.ca</div>";
            }
            if(empty($_POST['code'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Postal Code field must not be empty.</div>";
            }
            if (!preg_match("/^[A-Za-z][0-9][A-Za-z][0-9][A-Za-z][0-9]$/", $_POST['code'])) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Postal code must match format</div>";
            } 
            if (strlen($_POST['message']) > 200) {
                echo "<div style=\"background-color: red;text-align:center; margin-top:1rem\">Message length exceeds 200 characters</div>";
            }
        }
        ?>
  </body>
</html>