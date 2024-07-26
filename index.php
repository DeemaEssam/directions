<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Button Actions</title>

</head>
<body>
    <br><br><br><br><br>
    <div class="box">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
        <!-- <h1>
            <p style="font-size: 25px;">Directions</p>
        </h1> -->

        <div class="button-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <button type="submit" name="action" value="forward">Forward</button><br><br>
                <button type="submit" name="action" value="left">Left </button>
                <button type="submit" name="action" value="stop">STOP</button>
                <button type="submit" name="action" value="right">Right</button><br><br>
                <button type="submit" name="action" value="backward">Backward</button><br><br>
                <br>
            </form>
        </div>

        <?php
        // Assuming you have a MySQL database setup
        $servername = "";
        $username = "";
        $password = "";
        $dbname = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $message = "";

        // Process button actions
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['action'])) {
                $action = $_POST['action'];
                
                // Retrieve the current max count
                $sql_count = "SELECT MAX(id) as max_id FROM directions";
                $result = $conn->query($sql_count);
                $row = $result->fetch_assoc();
                $count = $row['max_id'] + 1;

                // Insert action into database
                $sql_insert = "INSERT INTO directions (directions, id) VALUES ('$action', $count)";
                
                if ($conn->query($sql_insert) === TRUE) {
                    $message = "New record created successfully";
                } else {
                    $message = "Error: " . $sql_insert . "<br>" . $conn->error;
                }
            } 
        }

        $conn->close();
        ?>
        <?php if ($message) { ?>
            <div class="message-box"><?php echo $message; ?></div>
        <?php } else { ?>
            <div class="message-box"></div>
        <?php } ?>

    </div>
</body>

<script>
    function lastVal()
    {
        window.location.href = 'last.php';
        return false;
    }
</script>
</html>

<!-- 
CREATE TABLE directions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    directions VARCHAR(255) NOT NULL
); -->
