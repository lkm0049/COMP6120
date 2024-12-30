<?php
function displayTables() {
    global $conn;

    // Get a list of all tables in the database
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        while ($row = $result->fetch_row()) {
            $table_name = $row[0];
            echo "<h3>Table: " . htmlspecialchars($table_name) . "</h3>";

            // Fetch and display table contents
            $table_result = $conn->query("SELECT * FROM $table_name");
            if ($table_result) {
                echo "<table>";
                echo "<tr>";
                while ($field = $table_result->fetch_field()) {
                    echo "<th>" . htmlspecialchars($field->name) . "</th>";
                }
                echo "</tr>";
                while ($data_row = $table_result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($data_row as $cell) {
                        echo "<td>" . htmlspecialchars(isset($cell) ? $cell : '') . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>Error fetching data from table $table_name: " . htmlspecialchars($conn->error) . "</p>";
            }
        }
    } else {
        echo "<div class='error'>Error fetching tables: " . htmlspecialchars($conn->error) . "</div>";
    }
}
?>
