<?php
// Check if form data is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to SQLite database
    $db = new SQLite3('/data/db.sqlite');

    // Get data from the form
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'] ?? null;
    $email = $_POST['email'] ?? null;
    $address = $_POST['address'] ?? null;

    // Insert data into the database
    $stmt = $db->prepare('INSERT INTO addresses_book (name, surname, phone, email, address) VALUES (:name, :surname, :phone, :email, :address)');
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':surname', $surname);
    $stmt->bindValue(':phone', $phone);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':address', $address);
    $result = $stmt->execute();

    if(!$result) {
        echo 'Invalid request. Record can not be written.';
    }

    // Close database connection
    $db->close();

    // Redirect back to the add record form page
}
header('Location: add_record_form.html');
exit;