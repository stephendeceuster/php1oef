<!-- 2.1 MySQL databanken gebruiken vanuit PHP -->

<h1>MySQLi Example</h1>
<?php
require_once("connection_data.php");


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//define and execute query
$sql = "select * from team";
$result = $conn->query($sql);

//show result (if there is any)
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["tea_id"] . "<br>";
        echo $row["tea_naam"] . "<br>";
        echo $row["tea_stadion"] . "<br>";
        echo "<br>";
    }
}
else {
    echo "No records found";
}

$conn->close();
?>

