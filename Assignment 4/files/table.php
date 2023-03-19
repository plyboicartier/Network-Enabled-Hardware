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
        <div class="box">
            <?php
            $db = new PDO('sqlite:feedback.db');
            $result = $db->query('SELECT * FROM feedback');
            echo "Table Info: <br>
                <table border=1 cellpadding=5>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Postal Code</td>
                    <td>Message</td>
                </tr>";
                foreach($result as $row)
                {
                    echo "<tr><td>".$row['name']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['postal_code']."</td>";
                    if ($row['message'] != NULL) {
                        echo "<td>".$row['message']."</td>";
                    } else { echo "<td>N/A</td>"; }
                    echo "</tr>";
                }
            echo "</table>";
            $db = NULL;
            ?>
        </div>
        <footer>
            &copy; 2023 DCA, Inc. All rights reserved.
        </footer>
    </body>
</html>