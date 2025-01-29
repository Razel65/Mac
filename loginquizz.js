const loginForm = document.getElementById('login-form');
const loginButton = document.getElementById('login-button');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const errorMessage = document.getElementById('error-message');


function validateLogin() {
  const username = usernameInput.value.trim();
  const password = passwordInput.value.trim();

  if (username === '' || password === '') {
    alert('Vul alle velden in!');
    return false;
  }

  return true;
}


function login(event) {
  event.preventDefault(); 
  if (validateLogin()) {
    const username = usernameInput.value.trim();
    const password = passwordInput.value.trim();

    
    fetch('php/Quizlogin.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username, password }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Netwerkfout of server niet bereikbaar');
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          
          sessionStorage.setItem('username', username);
          sessionStorage.setItem('score', data.score);

          
          window.location.href = 'Projectquiz.html';
        } else {
          showErrorMessage(data.message || 'Onjuiste gebruikersnaam of wachtwoord.');
        }
      })
      .catch((error) => {
        console.error('Fout tijdens inloggen:', error);
        showErrorMessage('Er is een fout opgetreden. Probeer het later opnieuw.');
      });
  }
}


function showErrorMessage(message) {
  errorMessage.style.display = 'block';
  errorMessage.textContent = message;
}


loginButton.addEventListener('click', login);
