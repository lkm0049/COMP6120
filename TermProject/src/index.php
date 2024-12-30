<?php
require 'db_config.php';
require 'getTable.php';
require 'getSQL.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>DB Query Form by Liam Maher</title>
    <link rel="stylesheet" href="layout.css">
    <script>
        // JavaScript function to clear the textarea
        function clearTextBox() {
            document.getElementById('sqlBox').value = '';
        }
    </script>
</head>
<body>
    <header>
        <h1>DB Query Form by Liam Maher</h1>
    </header>
    <main>
        <!-- SQL Query Section -->
        <section>
            <h2>Bookstore Database</h2>
            <form method="post" action="">
                <textarea id="sqlBox" name="sql" rows="5" cols="60" placeholder="Enter SQL query here..."><?php echo isset($_POST['sql']) ? htmlspecialchars_decode($_POST['sql']) : ''; ?></textarea><br>
                <button type="submit">Execute Query</button>
                <button type="button" onclick="clearTextBox()">Clear</button>
            </form>
        </section>
        <section>
            <!-- Display Error or Query Results -->
            <?php if (!empty($error_message)): ?>
                <div class="error">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="results">
                <?php echo $query_result; ?>
            </div>
        </section>
        <section>
            <h2>Tables in Database</h2>
            <?php displayTables(); ?>
        </section>
    </main>
</body>
</html>
