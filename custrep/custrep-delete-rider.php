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
            <a id="rider" href="../rider/rider-mainpage.html">&gt; Rider</a>
            <a id="customerservice" class="active" href="custrep-mainpage.html">&gt; Customer Serv. Rep.</a>
            <a id="maintenance" href="../technician/technician-mainpage.html">&gt; Maintenance Tech.</a>
            <a href="../about.html">About</a>
            <a href="../faq.html">FAQ</a>
            <a href="../ourbikes.html">Our Bikes</a>
            <a href="../contact.html">Contact</a>
        </div>

        <ul id="desktopnavigation">
            <li><span class="dot"></span><a href="../index.html">Home</a></li>
            <li><span class="dot"></span><a href="../login.html">Login</a></li>
            <li class="submenu"><span>&gt; </span><a href="../rider/rider-mainpage.html">Rider</a></li>
            <li class="submenu active"><span>&gt; </span><a class="active" href="custrep-mainpage.html">Customer
                Service</a></li>
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
                    <h3>CUSTOMER SERVICE REP. - Delete a Rider</h3>

                    <form method="POST" action="new-oracle-test.php">

                        <p>
                            Delete a rider from the system:
                        </p>

                        <p>
                            Enter rider ID: <input type="number" name="riderID" size="20">
                        </p>

                        <input type="submit" value="Delete Rider" name="deleteRider">

                        <p>
                            Display a short confirmation message here to say rider was deleted.
                        </p>


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

require 'server.php';

function printResult($result)
{ //prints results from a select statement
    echo "<br>Got data from table tab1:<br>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Phone</th><th>Address</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["NID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["ADDRESS"] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('reset', $_POST)) {
        // Drop old table...
        echo "<br> dropping table <br>";
        executePlainSQL("Drop table tab1");

        // Create new table...
        echo "<br> creating new table <br>";
        executePlainSQL("create table tab1 (nid number, name varchar2(30), phone number, address varchar2(100), primary key (nid))");
        OCICommit($db_conn);

    } else
        if (array_key_exists('addBike', $_POST)) {
            //Getting the values from user and insert data into the table
            $tuple = array(
                ":bind1" => random_int(0, 1000),
                ":bind2" => $_POST['datePurchased'],
                ":bind3" => $_POST['latitude'],
                ":bind4" => $_POST['longitude'],
                ":bind5" => 0
            );
            $alltuples = array(
                $tuple
            );
            executeBoundSQL("insert into bike values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
            OCICommit($db_conn);

        } else
            if (array_key_exists('updatesubmit', $_POST)) {
                // Update tuple using data from user
                $tuple = array(
                    ":bind1" => $_POST['oldName'],
                    ":bind2" => $_POST['newName'],
                    ":bind3" => $_POST['oldPhone'],
                    ":bind4" => $_POST['newPhone'],
                    ":bind5" => $_POST['oldAddress'],
                    ":bind6" => $_POST['newAddress']
                );
                $alltuples = array(
                    $tuple
                );
                executeBoundSQL("update tab1 set name=:bind2, phone=:bind4, address=:bind6 where name=:bind1 and phone=:bind3 and address=:bind5", $alltuples);
                OCICommit($db_conn);

            } else
                if (array_key_exists('deletesubmit', $_POST)) {
                    // Delete tuple using data from user
                    $tuple = array(
                        ":bind1" => $_POST['delNo']
                    );
                    $alltuples = array(
                        $tuple
                    );
                    executeBoundSQL("delete from tab1 where nid=:bind1", $alltuples);
                    OCICommit($db_conn);

                } else
                    if (array_key_exists('dostuff', $_POST)) {
                        // Insert data into table...
                        executePlainSQL("insert into tab1 values (10, 'Frank')");
                        // Inserting data into table using bound variables
                        $list1 = array(
                            ":bind1" => 6,
                            ":bind2" => "All"
                        );
                        $list2 = array(
                            ":bind1" => 7,
                            ":bind2" => "John"
                        );
                        $allrows = array(
                            $list1,
                            $list2
                        );
                        executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $allrows); //the function takes a list of lists
                        // Update data...
                        //executePlainSQL("update tab1 set nid=10 where nid=2");
                        // Delete data...
                        //executePlainSQL("delete from tab1 where nid=1");
                        OCICommit($db_conn);
                    }

    if ($_POST && $success) {
        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        header("location: main.php");
    } else {
        // Select data...
        $result = executePlainSQL("select * from tab1");
        printResult($result);
    }

    //Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database.
     You will need to replace "username" and "password" for this to
     to work.
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment
     statement */
/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode.
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode. */
/* OCI_Fetch_Array() Returns the next row from the result data as an
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an
     optinal second parameter which can be any combination of the
     following constants:

     OCI_BOTH - return an array with both associative and numeric
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default
     behavior.
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc()
     works).
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).
     OCI_RETURN_NULLS - create empty elements for the NULL fields.
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.
     Default mode is OCI_BOTH.  */
?>

