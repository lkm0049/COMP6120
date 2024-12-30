<?php
require 'db_config.php';

$error_message = ''; // Variable for error messages
$query_result = '';  // Variable for query results

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = stripslashes(trim($_POST['sql'])); // Get SQL input, had to modify this to work on auburn server


    // Check to make sure input isnt blank
    if (empty($sql)) {
        $error_message = 'Error: SQL query cannot be empty.';
    } 
     // Check for disallowed DROP statement
    elseif (stripos($sql, 'DROP') !== false) {
        $error_message = 'Error: DROP statements are not allowed.';
    } 
    else {
        try {
            // Execute the query
            $result = $conn->query($sql);

            if (!$result) {
                // Capture system error message for invalid SQL
                $error_message = "Error: Invalid Statement - System Error Message: " . htmlspecialchars($conn->error);
            } 
            elseif ($result instanceof mysqli_result) {
                // Format SELECT query results as a table
                $query_result .= "<table>";
                $query_result .= "<tr>";
                while ($field = $result->fetch_field()) {
                    $query_result .= "<th>" . htmlspecialchars($field->name) . "</th>";
                }
                $query_result .= "</tr>";
                while ($row = $result->fetch_assoc()) {
                    $query_result .= "<tr>";
                    foreach ($row as $cell) {
                        $query_result .= "<td>" . htmlspecialchars(isset($cell) ? $cell : '') . "</td>";
                    }
                    $query_result .= "</tr>";
                }
                $query_result .= "</table>";
                $query_result .= "<p>Number of rows retrieved: " . $result->num_rows . "</p>";
                $result->free();
            } 
            else {
                // Handle non-SELECT queries with success messages
                if (stripos($sql, 'INSERT') === 0) {
                    $query_result = '<div class="success">Row Inserted.</div>';
                } elseif (stripos($sql, 'UPDATE') === 0) {
                    $query_result = '<div class="success">' . $conn->affected_rows . ' Row(s) Updated.</div>';
                } elseif (stripos($sql, 'DELETE') === 0) {
                    $query_result = '<div class="success">' . $conn->affected_rows . ' Row(s) Deleted.</div>';
                } elseif (stripos($sql, 'CREATE') === 0) {
                    $query_result = '<div class="success">Table Created.</div>';
                } else {
                    $query_result = '<div class="success">Query executed successfully.</div>';
                }
            }
        } 
        catch (mysqli_sql_exception $e) {
            // Catch exceptions and display an error message
            $error_message = "Error: Invalid Statement - System Error Message: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>