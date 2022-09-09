<!DOCTYPE html>
<html>
 
<head>
    <title>Profile</title>
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
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $password=hash('md5',$password);
    $existence_name = "SELECT * FROM teacher WHERE email = '$email' AND password = '$password'";
    $result= $conn->query($existence_name);

    if ($result->num_rows > 0) {
        // output data of each row
        if($row = $result->fetch_assoc()) {
          echo "email: " . $row["email"]. " - username: " . $row["username"]. " gender: " . $row["gender"]. "<br>";
        }
    }
    else{
        echo "
        <script type=\"text/javascript\">
            alert(\"User doesn't exist\");
            window.location.href = \"index.php\";
        </script>
        ";
    }

    $conn->close();
    ?>
</body>
</html>