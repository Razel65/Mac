let currentQuestionIndex = 0;
let score = 0;
let timer;
let timeLeft = 10;

const questions = [
    {
        question: "Wat is de hoofdstad van Nederland?",
        answers: ["Amsterdam", "Rotterdam", "Den Haag"],
        correct: 0
    },
    {
        question: "Hoeveel planeten zijn er in ons zonnestelsel?",
        answers: ["8", "4", "6"],
        correct: 0
    },
    {
        question: "Wat is de chemische formule voor deuterium?",
        answers: ["H³", "H¹0", "²H"],
        correct: 2
    },
    {
        question: "In welk jaar viel de Berlijnse Muur?",
        answers: ["1989", "1999", "1979"],
        correct: 0
    },
    {
        question: "Wat is het kleinste deeltje in een atoom?",
        answers: ["Proton", "Elektron", "Quark"],
        correct: 2
    },
    {
        question: "Hoe heet de stof die planten groen maakt?",
        answers: ["Chlorofyl", "Hemoglobine", "Celstof"],
        correct: 0
    },
    {
        question: "Wat is de grootste woestijn ter wereld?",
        answers: ["Sahara", "Kalahari", "Antarctische Woestijn"],
        correct: 2
    },
    {
        question: "Op welke planeet bevindt de Olympus Mons, de grootste vulkaan in het zonnestelsel, zich?",
        answers: ["Aarde", "Jupiter", "Mars"],
        correct: 2
    },
    {
        question: "Welke popster bracht het album Thriller uit?",
        answers: ["Madonna", "Michael Jackson", "Prince"],
        correct: 1
    },
    {
        question: "In welke sport worden termen zoals love, deuce en ace, gebruikt?",
        answers: ["Badminton", "Tennis", "Cricket"],
        correct: 1
    },
    {
        question: "Wie is de oprichter van Microsoft?",
        answers: ["Steve Jobs", "Mark Zuckerberg", "Bill Gates"],
        correct: 2
    },
    {
        question: "Wie schreef Romeo and Juliet?",
        answers: ["William Shakespeare", "Charles Dickens", "Jane Austen"],
        correct: 0
    },
    {
        question: "In welk jaar werd het boek 1984 van George Orwell gepubliceerd?",
        answers: ["1945", "1949", "1955"],
        correct: 0
    },
    {
        question: "Hoeveel sterren zitten er in de Europese vlag?",
        answers: ["12", "10", "14"],
        correct: 0
    },
    {
        question: "Welke componist schreef de Negende Symfonie?",
        answers: ["Mozart", "Bach", "Beethoven"],
        correct: 2
    }
];

function startQuiz() {
    loadQuestion();
}

function loadQuestion() {
    clearInterval(timer); 
    if (currentQuestionIndex < questions.length) {
        const question = questions[currentQuestionIndex];
        document.getElementById("question").innerText = question.question;
        const options = document.querySelectorAll(".option");
        options.forEach((option, index) => {
            option.innerText = question.answers[index];
        });
        
        enableOptions();
        startTimer();
    } else {
        endQuiz();
    }
}
function startTimer() {
    timeLeft = 10;
    document.getElementById("timer").innerText = timeLeft;
    timer = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timer);
            currentQuestionIndex++;
            loadQuestion();
        } else {
            timeLeft--;
            document.getElementById("timer").innerText = timeLeft;
        }
    }, 1000);
}


function disableOptions() {
    document.querySelectorAll(".option").forEach((button) => {
        button.disabled = true;
    });
}

function enableOptions() {
    document.querySelectorAll(".option").forEach((button) => {
        button.disabled = false;
    });
}


function checkAnswer(selectedIndex) {
    clearInterval(timer);
    const question = questions[currentQuestionIndex];
    if (selectedIndex === question.correct) {
        score++;
        document.getElementById("score").innerText = score;
    }
    currentQuestionIndex++;
    setTimeout(() => {
        loadQuestion();
    }, 1000); 
}

function endQuiz() {
    document.getElementById("quiz-container").style.display = "none";
    const result = document.createElement("div");
    result.id = "result";
    result.innerHTML = `<h2>Je score is: ${score}/${questions.length}</h2>`;
    document.body.appendChild(result);
}

document.getElementById("optionA").addEventListener("click", () => checkAnswer(0));
document.getElementById("optionB").addEventListener("click", () => checkAnswer(1));
document.getElementById("optionC").addEventListener("click", () => checkAnswer(2));

window.onload = () => {
    startQuiz(); 
};
