<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kennisquiz</title>
    <link rel="stylesheet" href="projectquiz.css">
    <style>
        
        #login-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border: 2px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 300px;
        }

        #login-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        
        #quiz-container {
            display: block;
        }
    </style>
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
        <button id="login-popup-button">Inloggen</button>
    </div>

    
    <div id="login-overlay"></div>
    <div id="login-container">
        <form id="login-form">
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password"><br><br>
            <button type="button" id="login-button">Inloggen</button>
        </form>
    </div>

    <script src="Quizzz.js"></script>

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
