<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Button Actions</title>
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
        background-color: #ffe6f2; /* Light pink background */
    }
    h1 {
        margin-top: 20px;
        color: #ff1493; /* Deep pink */
    }
    .button-container {
        display: grid;
        grid-template-areas: 
            ". forward ."
            "left stop right"
            ". backward .";
        gap: 20px;
        justify-content: center;
        margin-top: 50px;
    }
    .message-box {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ff69b4;
        background-color: #ffe6e6;
        width: 300px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: #ff1493;
    }
    button {
        padding: 20px;
        font-size: 18px;
        cursor: pointer;
        border: none;
        background-color: #ff69b4;
        color: white;
        border-radius: 10px;
        transition: background-color 0.3s, transform 0.3s;
        box-shadow: 0 5px #cc3366;
    }
    button:active {
        transform: translateY(4px);
        box-shadow: 0 1px #cc3366;
    }
    button:hover {
        background-color: #ff1493;
    }
    button[name="forward"] {
        grid-area: forward;
    }
    button[name="backward"] {
        grid-area: backward;
    }
    button[name="left"] {
        grid-area: left;
    }
    button[name="right"] {
        grid-area: right;
    }
    button[name="stop"] {
        grid-area: stop;
        background-color: #ff1493;
    }
    button[name="stop"]:hover {
        background-color: #ff69b4;
    }
</style>
</head>
<body>
    <br><br><br><br><br>
    <h1>Directions</h1>

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
            $sql_last = "Retrive direction FROM directions ORDER BY id DESC LIMIT 1";
            $result_last = $conn->query($sql_last);
            
            if ($result_last->num_rows > 0) {
                $row = $result_last->fetch_assoc();
                $message = "Last value entered: " . $row["direction"];
            } else {
                $message = "No actions recorded yet.";
            }
        }
    }

    $conn->close();
    ?>

    <?php if ($message): ?>
        <div class="message-box"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="button-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <button type="submit" name="show_last_value">Show Last Value</button>
        </form>
    </div>
</body>
</html>
