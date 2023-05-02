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
    <title>Matrix Multiplier</title>
</head>
<body>
    <form method="post">
        Matrix 1: <br>
        <input type="number" name="a00"><input type="number" name="a01"><br>
        <input type="number" name="a10"><input type="number" name="a11"><br>
        Matrix 2: <br>
        <input type="number" name="b00"><input type="number" name="b01"><br>
        <input type="number" name="b10"><input type="number" name="b11"><br>
        <input type="submit">
    </form>
    <?php
    function PrintMatrix($mat) {
        echo    "<br><table border=1 cellpadding=5>
                    <tr> 
                        <td>" , $mat[0][0] , "</td>
                        <td>" , $mat[0][1] , "</td>
                    </tr>
                    <tr> 
                        <td>" , $mat[1][0] , "</td>
                        <td>" , $mat[1][1] , "</td>
                    </tr>
                </table>";
    }

    if($_SERVER['REQUEST_METHOD']=="POST") {    // stops error messages from happenning if the form hasn't been submitted yet
        $matrix1 = [[]];
        $matrix2 = [[]];
        $res = [[]];

        // takes input from each matrix in a loop 
        for ($i = 0; $i < 2; $i++) 
        {
            for ($j = 0; $j < 2; $j++) 
            {
                $value = $_POST["a$i$j"];   // uses loop variables to recieve proper inputs
                if (empty($value)) { exit('<br>One or more values in Matrix 1 are invalid'); }
                $matrix1[$i][$j] = $value;
            
                $value = $_POST["b$i$j"];
                if (empty($value)) { exit('<br>One or more values in Matrix 2 are invalid'); }
                $matrix2[$i][$j] = $value;
            }
        }

        // calculates the resulting matrix
        for ($i = 0; $i < sizeof($matrix1); $i++)
        {
            for ($j = 0; $j < sizeof($matrix2); $j++)
            {
                $res[$i][$j] = 0; // populates result array with zeros to avoid "Undefined array key" error
                for ($k = 0; $k < 2; $k++)
                {
                    $res[$i][$j] += $matrix1[$i][$k] * $matrix2[$k][$j];
                }
            }
        }

        PrintMatrix($matrix1);
        echo "<br>x<br>";
        PrintMatrix($matrix2);
        echo "<br>=<br>";
        PrintMatrix($res);
    }
    ?>
</body>
</html>