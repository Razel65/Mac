<?php

$conn = new mysqli('localhost', 'gebruikersnaam', 'wachtwoord', 'database');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connectie mislukt']));
}


$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? null;
$password = $input['password'] ?? null;
$score = $input['score'] ?? null;


if (!$username || (!$password && $score === null)) {
    echo json_encode(['success' => false, 'error' => 'Ongeldige invoer']);
    exit;
}


if ($password) {

    $passwordHash = hash('sha256', $password);


    $query = "SELECT * FROM gebruikers WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $passwordHash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Onjuiste inloggegevens']);
    }
    $stmt->close();
}


if ($score !== null) {
    $query = "UPDATE gebruikers SET score = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $score, $username);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Score bijgewerkt']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Score update mislukt']);
    }
    $stmt->close();
}


$conn->close();
?>
