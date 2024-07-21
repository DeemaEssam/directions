***1_ create a database named Robot that contains the directions table***
```ruby
CREATE TABLE directions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    directions VARCHAR(255) NOT NULL
);
```

***2_ write PHP code handles form submissions ($_POST) to insert directions and fetch the last entered direction when requested.***

- Insert the values
```ruby
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

```

- retrive the last value

```ruby
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
```

***3_ designing the interface***

![image](https://github.com/user-attachments/assets/7de99101-0e95-4c04-a154-16c01ba55fc8)

***4_ Output***
![directions](https://github.com/user-attachments/assets/83c29fa4-3d77-454b-9fed-87ca39cfd8ac)


