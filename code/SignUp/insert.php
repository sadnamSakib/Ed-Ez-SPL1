<!DOCTYPE html>
<html>
 
<head>
    <title>Insert Page page</title>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "UserManager";
    $password = "12345678";
    $dbname = "user";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $name =  $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $password=hash('md5',$password);
    $gender = $_REQUEST['gender'];
    $dob = $_REQUEST['dob'];
    $institutions = $_REQUEST['institution'];
    $confirm= $_REQUEST['cfpassword'];
    $sql = "INSERT INTO teacher VALUES ('$name', '$email','$password','$dob','$gender','$institutions')";
    $existence_name = "SELECT * FROM teacher WHERE email = '$email'";
    $result= $conn->query($existence_name);

    if ($result->num_rows > 0) {
        // output data of each row
        // while($row = $result->fetch_assoc()) {
        //   echo "id: " . $row["username"]. " - Name: " . $row["email"]. " " . $row["password"]. "<br>";
        // }
        echo "
        <script type=\"text/javascript\">
            alert(\"User already exists\");
            window.location.href = \"index.php\";
        </script>
        ";
        // $conn->close();
        // header("Location: index.php");
        // exit();
    }
    else if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo "<h3>data stored in a database successfully."
            . " Please browse your localhost php my admin"
            . " to view the updated data</h3>";

        echo nl2br("\n$name\n $password\n $confirm ");
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    ?>
</body>
</html>