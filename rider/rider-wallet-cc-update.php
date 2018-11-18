<!doctype html>
<html lang="en">
<head>
    <title>Bike Sharing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../project.js" type="text/javascript" defer></script>
    <link rel="stylesheet" href="../project.css">
</head>
<div id="wrapper">

    <nav>
        <div id="mysidenav" class="sidenavigation">
            <a href="javascript:void(0)" id="closebutton" onclick="closeNav()">&times;</a>
            <a href="../index.html">Home</a>
            <a href="../login.html">Login</a>
            <a id="rider" class="active" href="rider-mainpage.html">&gt; Rider</a>
            <a id="customerservice" href="../custrep/custrep-mainpage.php">&gt; Customer Serv. Rep.</a>
            <a id="maintenance" href="../technician/technician-mainpage.html">&gt; Maintenance Tech.</a>
            <a href="../about.html">About</a>
            <a href="../faq.html">FAQ</a>
            <a href="../ourbikes.html">Our Bikes</a>
            <a href="../contact.html">Contact</a>
        </div>

        <ul id="desktopnavigation">
            <li><span class="dot"></span><a href="../index.html">Home</a></li>
            <li><span class="dot"></span><a href="../login.html">Login</a></li>
            <li class="submenu active"><span>&gt; </span><a class="active" href="rider-mainpage.html">Rider</a></li>
            <li class="submenu"><span>&gt; </span><a href="../custrep/custrep-mainpage.php">Customer Service</a></li>
            <li class="submenu"><span>&gt; </span><a href="../technician/technician-mainpage.html">Maintenance Tech.</a>
            </li>
            <li><span class="dot"></span><a href="../about.html">About</a></li>
            <li><span class="dot"></span><a href="../faq.html">FAQ</a></li>
            <li><span class="dot"></span><a href="../ourbikes.html">Our Bikes</a></li>
            <li><span class="dot"></span><a href="../contact.html">Contact</a></li>
        </ul>
    </nav>

    <div id="rightcol">

        <header>
            <div id="navicon">
                <img src="../images/navicon.png" alt="three horizontal bars" width="30" onclick="openNav()">
            </div>

            <h1>Bike Sharing</h1>
        </header>

        <div id="shadowbox">
            <main>
                <div>
                    <h3>RIDER - Update Credit Card on File</h3>

                    <form method="POST" action="new-oracle-test.php">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>
                            Update Your Credit Card Info:
                        </p>

                        <p>
                            Credit Card Number:
                            <input type="number" name="ccNumber" size="20">
                        </p>

                        <p>
                            Credit Card Expiry:
                            <select name="ccExpiryMonth" id="ccExpiryMonth">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>

                            <select name="ccExpiryYear" id="ccExpiryYear">
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                            </select>
                        </p>

                        <input type="submit" value="Update Credit Card" name="updateCreditCard">

                    </form>
                </div>
            </main>

            <footer>
                <p>
                    Copyright &copy; 2018 Bike Sharing <br>
                    <a href="mailto:email@domain.com">email@domain.com</a>
                </p>
            </footer>
        </div>
    </div>
</div>
</html>

<?php

require '../server.php';
include "../print-table.php";


// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('updateCreditCard', $_POST)) {
        //include '../debugger.php';
        // Updates tuple using data from user
        $tuple = array(
            ":bind1" => $_POST['rider_ID'],
            ":bind2" => $_POST['ccNumber'],
            ":bind3" => $_POST['ccExpiryMonth+ccExpiryYear']

        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("UPDATE RIDER SET CREDITCARDNO= :bind2, CREDITCARDEXP=:bind3 WHERE RIDER_ID = :bind1", $alltuples);
        printResult($result);
        OCICommit($db_conn);

    } else {
        $result = executePlainSQL("SELECT NAME, CREDITCARDNO, CREDITCARDEXP FROM RIDER WHERE RIDER_ID = :bind1");

        $riderTable = array("Name of Rider", "Credit Card Number", "Credit Card Expiry");
        printTable($result, $riderTable);
    }
    if ($_POST && $success) {
        echo "<h1 style='color: black'>Rider's credit card information has been updated</h1>";
        $result = executePlainSQL("SELECT NAME, CREDITCARDNO, CREDITCARDEXP FROM RIDER WHERE RIDER_ID = :bind1");

        $riderTable = array("Name of Rider", "Credit Card Number", "Credit Card Expiry");
        printTable($result, $riderTable);
    } else if (!$success){
        echo "<h1 style='color: red'>Error!</h1>";
    }

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>
