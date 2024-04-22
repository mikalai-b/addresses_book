<?php
// Connect to SQLite database
$db = new SQLite3('/data/db.sqlite');

// Query to select all records from addresses_book table
$query = 'SELECT * FROM addresses_book';
$result = $db->query($query);

// Check if there are any records
if ($result) {
    // Output records in a table format
    echo '<head><style>body {font-family: sans-serif;} table, th, td {border: 1px solid black; border-collapse: collapse;} th, td {padding: 1rem;}</style></head>';
    echo '<h2><a href="index.php">Address Book</a></h2>';
    echo '<table>';
    echo '<tr><th>Name</th><th>Surname</th><th>Phone</th><th>Email</th><th>Address</th><th colspan="2">Actions</th></tr>';
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['surname'] . '</td>';
        echo '<td>' . $row['phone'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td style="white-space: pre-line;">' . $row['address'] . '</td>';
        echo '<td><a href="update_record.php?id=' . $row['id'] . '">Update</a></td>';
        echo '<td><a href="delete_record.php?id=' . $row['id'] . '">Delete</a></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Invalid request. Records can not be read.';
}

// Close database connection
$db->close();

