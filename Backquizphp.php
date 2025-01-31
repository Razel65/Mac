<?php
session_start(); 

$conn = new mysqli('localhost', 'gebruikersnaam', 'wachtwoord', 'database');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connectie mislukt']));
}

$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? null;
$password = $input['password'] ?? null;
$score = $input['score'] ?? null;
$questionIndex = $input['questionIndex'] ?? null;
$action = $input['action'] ?? null;


if (!isset($_SESSION['username']) && !$username) {
    echo json_encode(['success' => false, 'error' => 'Niet ingelogd']);
    exit;
}

if ($action === 'login') {
    if (!$username || !$password) {
        echo json_encode(['success' => false, 'error' => 'Ongeldige invoer']);
        exit;
    }

    $passwordHash = hash('sha256', $password);

    $query = "SELECT * FROM gebruikers WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $passwordHash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo json_encode(['success' => true, 'redirect' => 'projectquiz.php']); 
    } else {
        echo json_encode(['success' => false, 'error' => 'Onjuiste inloggegevens']);
    }

    $stmt->close();
} elseif ($action === 'update' && isset($_SESSION['username'])) {
 
    $query = "UPDATE gebruikers SET score = ?, question_index = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $score, $questionIndex, $_SESSION['username']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Voortgang bijgewerkt']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Bijwerken voortgang mislukt']);
    }

    $stmt->close();
} elseif ($action === 'fetch' && isset($_SESSION['username'])) {
    $query = "SELECT score, question_index FROM gebruikers WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'score' => $user['score'],
            'questionIndex' => $user['question_index']
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Geen voortgang gevonden']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Ongeldige actie of geen sessie actief']);
}

$conn->close();
?>
