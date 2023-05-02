<!--
    Carter Glynn 8657212
    PROG 2607 - Network Enabled Hardware
    2023-02-05
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Prime Numbers</title>
</head>
<body>
    <form method="post">
        <input type="number" name="a">
        <input type="number" name="b">
        <input type="submit">
    </form>
    <?php
    function IsPrime($n) {
        for($x=2; $x<$n; $x++) {
            if($n %$x ==0) { return 0; }
        }
        return 1;
    }

    if($_SERVER['REQUEST_METHOD']=="POST") {    // stops error messages from happenning if the form hasn't been submitted yet

        $a = $_POST["a"];
        $b = $_POST["b"];

        if ($a < 1 || $b < 1) { // validates and exits for anything less than 1
            exit("One or more numbers are not positive");
        }

        echo "The prime numbers between " .$a. " and " .$b. " are: <br>
            <table border=1 cellpadding=5>
                <tr>";
                    for ($i = $a; $i < $b; $i++) {
                        if (IsPrime($i) && $i != 1) { echo "<td>".$i."</td>"; }
                    }
        echo "  </tr>
            </table>";
    }
    ?>
</body>
</html>