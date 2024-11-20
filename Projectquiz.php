<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kennisquiz</title>
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
    <script src="quiz.js"></script>
</body>
</html>