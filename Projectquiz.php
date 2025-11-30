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
            <p>Je bent niet ingelogdzonderunt de quiz spelen zonder in te loggen, maar je voortgang wordt niet opgeslagen.</p>
            <button onclick="startQuiz()">Speel Zonder Inloggen</button>
            <button onclick="goToLogin()">Login</button>
        <?php endif; ?>
    </div>

    <div id="quiz-container" style="display: none;">
        <div id="timer">10</div>
        <div id="question"></div>
        <div id="options">
            <button class="option" id="optionA"></button>
            <button class="option" id="optionB"></button>
            <button class="option" id="optionC"></button>
        </div>
        <div id="scoreboard">Score: <span id="score">0</span>/15</div>
        <button onclick="goBack()">Terug naar Start</button>
    </div>

    <script src="Quizzz.js"></script>

    <script>
        function startQuiz() {
            document.getElementById("welcome-container").style.display = "none";
            document.getElementById("quiz-container").style.display = "block";
        }

        function goToLogin() {
            window.location.href = "Loginquiz.html";
        }

        function logout() {
            fetch('logout.php')
                .then(() => window.location.reload());
        }

        function goBack() {
            document.getElementById("quiz-container").style.display = "none";
            document.getElementById("welcome-container").style.display = "block";
        }
    </script>

</body>
</html>
