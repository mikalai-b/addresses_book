<?php
// Check if ID parameter is provided in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Connect to SQLite database
    $db = new SQLite3('/data/db.sqlite');

    // Prepare delete statement
    $stmt = $db->prepare('DELETE FROM addresses_book WHERE id = :id');
    $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);

    // Execute the delete statement
    $result = $stmt->execute();

    if(!$result) {
        echo 'Invalid request. Record can not be deleted.';
    }

    // Close database connection
    $db->close();

    // Redirect back to the view records page
    header('Location: view_records.php');
    exit;
} else {
    echo 'Invalid request. Please provide record ID.';
}
