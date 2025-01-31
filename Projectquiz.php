<<?php
session_start();
$isLoggedIn = isset($_SESSION['username']); 
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
</head>
<body>
    <h1>Welkom bij de quiz!</h1>
    
    <?php if ($isLoggedIn): ?>
        <p>Ingelogd als: <?php echo $_SESSION['username']; ?></p>
        <button onclick="logout()">Uitloggen</button>
    <?php else: ?>
        <p>Je bent niet ingelogd. Je kunt de quiz spelen zonder in te loggen, maar je voortgang wordt niet opgeslagen.</p>
        <a href="loginquiz.html">Login</a>
    <?php endif; ?>

    <script>
        function logout() {
            fetch('logout.php')
                .then(() => window.location.reload()); 
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Pagina</title>
  <link rel="stylesheet" href="projectquiz.css">
</head>
<body>
  <div id="quiz-container">
    <div id="timer">10</div>
    <div id="question"></div>
    <div id="options">
        <button class="option" id="optionA"></button>
        <button class="option" id="optionB"></button>
        <button class="option" id="optionC"></button>
    </div>
    <div id="scoreboard">Score: <span id="score">0</span>/15</div>
  </div>

  <script src="Quizzz.js"></script>
</body>
</html>


    <script>
        const loginPopupButton = document.getElementById("login-popup-button");
        const loginContainer = document.getElementById("login-container");
        const loginOverlay = document.getElementById("login-overlay");

        
        loginPopupButton.addEventListener("click", () => {
            loginContainer.style.display = "block";
            loginOverlay.style.display = "block";
        });

        
        loginOverlay.addEventListener("click", () => {
            loginContainer.style.display = "none";
            loginOverlay.style.display = "none";
        });

        
        document.getElementById("login-button").addEventListener("click", () => {
            
            loginContainer.style.display = "none";
            loginOverlay.style.display = "none";
            alert("Je bent ingelogd! Quiz kan beginnen.");
           
        });
    </script>
</body>
</html>
