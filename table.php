<?php
/**
 * Created by PhpStorm.
 * User: Raghav Thakur
 * Date: 2018-11-15
 * Time: 9:49 PM
 */

require "server.php";


function printTable($resultFromSQL, $namesOfColumnsArray)
{
    echo "In Table";
    echo "<table>";
    echo "<tr>";
    foreach ($namesOfColumnsArray as $name) {
        echo "<th>$name</th>";
    }
        echo "</tr>";


    while($row = OCI_Fetch_Array($resultFromSQL, OCI_BOTH)) {
        echo "<tr>";
        $string = "";
        for ($i = 0; $i < sizeof($row); $i++) {
            $string .= "<td>" . $row["$i"] . "</td>";
        }
        echo $string;
        echo "</tr>";
    }
    echo "</table>";
}