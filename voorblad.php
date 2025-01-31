<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij de Quiz</title>
    <link rel="stylesheet" href="projectquiz.css">
</head>
<body>

    <div id="welcome-container">
        <h1>Welkom bij de Quiz!</h1>
        <?php if ($isLoggedIn): ?>
            <p>Je bent ingelogd als: <strong><?php echo $_SESSION['username']; ?></strong></p>
            <button onclick="startQuiz()">Start de Quiz</button>
            <button onclick="logout()">Uitloggen</button>
        <?php else: ?>
            <p>Je bent niet ingelogd. Je kunt de quiz spelen zonder in te loggen, maar je voortgang wordt niet opgeslagen.</p>
            <button onclick="startQuiz()">Speel Zonder Inloggen</button>
            <button onclick="goToLogin()">Login</button>
        <?php endif; ?>
    </div>

    <script>
        function startQuiz() {
            window.location.href = "projectquiz.php";  
        }

        function goToLogin() {
            window.location.href = "loginquiz.html";
        }

        function logout() {
            fetch('logout.php')
                .then(() => window.location.href = "welkom.php");
        }
    </script>

</body>
</html>
