<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Last Value</title>
</head>

<body>
    <br><br><br><br><br>
    <div class="box">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
            <div class="button-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <button type="submit" name="show_last_value">Show Last Value</button>
                </form>
            </div>

        <?php
        // Assuming you have a MySQL database setup
        $servername = "localhost";
        $username = "test";
        $password = "test";
        $dbname = "robot";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $message = "";

        // Process button actions
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['show_last_value'])) {
                // Fetch last value from database
                $sql_last = "SELECT directions FROM directions ORDER BY id DESC LIMIT 1";
                $result_last = $conn->query($sql_last);

                if ($result_last->num_rows > 0) {
                    $row = $result_last->fetch_assoc();
                    $message = "Last value entered: " . $row["directions"];
                } else {
                    $message = "No actions recorded yet.";
                }
            }
        }

        // Fetch all values from directions
        $sql_all = "SELECT id, directions FROM directions ORDER BY id DESC";
        $result_all = $conn->query($sql_all);
        ?>

        <?php if ($message) { ?>
            <div class="message-box"><?php echo $message; ?></div>
        <?php } else { ?>
            <div class="message-box"></div>
        <?php } ?>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Direction</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_all->num_rows > 0) {
                    while($row = $result_all->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["directions"] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
