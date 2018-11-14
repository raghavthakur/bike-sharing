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
            <a id="customerservice" href="../custrep/custrep-mainpage.html">&gt; Customer Serv. Rep.</a>
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
            <li class="submenu"><span>&gt; </span><a href="../custrep/custrep-mainpage.html">Customer Service</a></li>
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
                    <h3>RIDER - Start Ride</h3>

                    <form method="POST" action="new-oracle-test.php">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>Select the bike you would like to rent:</p>

                        <p>
                            <select name="bikeIdsAndLocations">
                                <option value="put the employee ID here">Show bike ID and latitude/longitude from the DB
                                    here
                                </option>
                                <option value="put the employee ID here">Show bike ID and latitude/longitude from the DB
                                    here
                                </option>
                                <option value="put the employee ID here">Show bike ID and latitude/longitude from the DB
                                    here
                                </option>
                                <option value="put the employee ID here">Show bike ID and latitude/longitude from the DB
                                    here
                                </option>
                            </select>
                        </p>

                        <input type="submit" value="Start Rental" name="startRental">


                        <p>
                            Note that a rider shouldn't be allowed to rent a bike if they currently have an active bike
                            rental. They must return the other bike first. We should show an error message if they try
                            to do this. <br> <br>
                            IMPORTANT: In our formal spec document, under Deliverable 11, we said that we would create
                            a VIEW for Riders for the Bike table. Riders are only allowed to see bike_ID, latitude,
                            and longitude. The VIEW would prevent them from seeing other things. On the other hand,
                            since it is not possible for a Rider to access that information using our input boxes above,
                            the VIEW is not really necessary, but I guess we have to do it because of the project
                            requirements.
                        </p>

                        <p>
                            Display a confirmation message here to indicate that the ride has started - or display an
                            error message otherwise.
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
