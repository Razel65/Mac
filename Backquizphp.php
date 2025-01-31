<?php
session_start();
header('Content-Type: application/json');

// Database verbinding
$conn = new mysqli('localhost', 'gebruikersnaam', 'wachtwoord', 'database');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connectie mislukt']));
}

// JSON-input ophalen
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? null;
$password = $input['password'] ?? null;
$score = $input['score'] ?? null;
$questionIndex = $input['questionIndex'] ?? null;
$action = $input['action'] ?? null;

if (!$action) {
    echo json_encode(['success' => false, 'error' => 'Geen actie opgegeven']);
    exit;
}

// Registratie
if ($action === 'register') {
    if (!$username || !$password) {
        echo json_encode(['success' => false, 'error' => 'Vul alle velden in!']);
        exit;
    }

    // Controleer of gebruikersnaam al bestaat
    $stmt = $conn->prepare("SELECT id FROM gebruikers WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Gebruikersnaam bestaat al!']);
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Veilige hash
        $stmt = $conn->prepare("INSERT INTO gebruikers (username, password, score, question_index) VALUES (?, ?, 0, 0)");
        $stmt->bind_param('ss', $username, $passwordHash);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Registratie succesvol!']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Registratie mislukt!']);
        }
    }
    $stmt->close();
}

// Inloggen
elseif ($action === 'login') {
    if (!$username || !$password) {
        echo json_encode(['success' => false, 'error' => 'Ongeldige invoer']);
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM gebruikers WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            echo json_encode(['success' => true, 'redirect' => 'projectquiz.php']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Onjuist wachtwoord']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Gebruiker niet gevonden']);
    }

    $stmt->close();
}

// Voortgang bijwerken
elseif ($action === 'update') {
    if (!isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'Niet ingelogd']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE gebruikers SET score = ?, question_index = ? WHERE username = ?");
    $stmt->bind_param('iis', $score, $questionIndex, $_SESSION['username']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Voortgang bijgewerkt']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Bijwerken voortgang mislukt']);
    }

    $stmt->close();
}

// Voortgang ophalen
elseif ($action === 'fetch') {
    if (!isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'Niet ingelogd']);
        exit;
    }

    $stmt = $conn->prepare("SELECT score, question_index FROM gebruikers WHERE username = ?");
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
} 

// Ongeldige actie
else {
    echo json_encode(['success' => false, 'error' => 'Ongeldige actie']);
}

$conn->close();
?>
