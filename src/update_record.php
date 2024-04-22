<?php
$db = new SQLite3('/data/db.sqlite');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID parameter is provided in the form
    if (isset($_POST['id']) && !empty($_POST['id'])) {

        // Get data from the form
        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'] ?? null;
        $email = $_POST['email'] ?? null;
        $address = $_POST['address'] ?? null;

        // Update data in the database
        $stmt = $db->prepare('UPDATE addresses_book SET name = :name, surname = :surname, phone = :phone, email = :email, address = :address WHERE id = :id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':surname', $surname);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':address', $address);
        $result = $stmt->execute();

        if(!$result) {
            echo 'Invalid request. Record can not be written.';
        }
        // Redirect back to the view records page
        header('Location: view_records.php');
        $db->close();

        exit;
    } else {
        echo 'Invalid request. Please provide record ID.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: sans-serif;
        }
        input, button, textarea {
            padding: 0.5rem 1rem;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
</head>
<body>
<h2><a href="index.php">Update Record</a></h2>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Getting Post ID from URL
    $id = $_GET['id'];

    // Retrieving record data from the database
    $stmt = $db->prepare('SELECT * FROM addresses_book WHERE id = :id');
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if(!$result) {
        echo 'Invalid request. Record can not be read.';
        $db->close();
        exit;
    }

    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Form for updating a record
        echo '<form action="update_record.php" method="POST">';
        echo '<div style="display: grid; grid-template-columns: auto 1fr; gap: 1rem; align-items: center; max-width: 600px;">';
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<label for="name">Name:</label> <input type="text" name="name" required value="' . $row['name'] . '">';
        echo '<label for="surname">Surname:</label> <input type="text" name="surname" required value="' . $row['surname'] . '">';
        echo '<label for="phone">Phone:<br /><small>Format: 123-456-789</small></label> <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" value="' . $row['phone'] . '">';
        echo '<label for="email">Email:</label> <input type="email" name="email" value="' . $row['email'] . '">';
        echo '<label for="address">Address:</label> <textarea name="address">' . $row['address'] . '</textarea>';
        echo '<button type="submit">Update</button>';
        echo '</div>';
        echo '</form>';
    } else {
        echo 'Record not found.';
    }
} else {
    echo 'Invalid request. Please provide record ID.';
}
// Closing a database connection
$db->close();
?>
</body>
</html>
