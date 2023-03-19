<!--
    Carter Glynn 8657212
    PROG 2607 - Network Enabled Hardware
    2023-02-13
-->
<?php
    if($_SERVER['REQUEST_METHOD']=="POST") {    // stops error messages from happenning if the form hasn't been submitted yet

        $name = $_POST["name"];
        $email = $_POST["email"];
        $code = $_POST["code"];
        $message =$_POST["message"];

        echo "<style>
                .box {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                    width:100%;
                    height:100%;
                }
                table {
                    border-collapse: collapse;
                }
                tr:nth-child(even) {
                    background-color: lightgrey;
                }
            </style>
            <div class=\"box\">
                Client Info: <br>
                <table border=1 cellpadding=5>
                    <tr>
                        <td font-weight=\"bold\">Name</td>
                        <td>".$name."</td>
                    </tr>
                    <tr>
                        <td font-weight=\"bold\">Email</td>
                        <td>".$email."</td>
                    </tr>
                    <tr>
                        <td font-weight=\"bold\">Postal Code</td>
                        <td>".$code."</td>
                    </tr>";
                    if ($message != NULL) {
                        echo "<tr>
                                <td font-weight=\"bold\">Message</td>
                                <td>".$message."</td>
                            </tr>";
                    }
        echo    "</table>
            </div>";
    }
?>