const loginForm = document.getElementById('login-form');
const loginButton = document.getElementById('login-button');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const errorMessage = document.getElementById('error-message');

document.getElementById("login-button").addEventListener("click", async (event) => {
  event.preventDefault(); // Voorkomt dat de pagina herlaadt

  const username = usernameInput.value.trim();
  const password = passwordInput.value.trim();

  if (username === '' || password === '') {
    alert('Vul alle velden in!');
    return;
  }

  try {
    const response = await fetch("Backquizphp.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: "login", username, password }),
    });

    if (!response.ok) {
      throw new Error('Netwerkfout of server niet bereikbaar');
    }

    const result = await response.json();

    if (result.success) {
      window.location.href = "Projectquiz.php";
    } else {
      showErrorMessage(result.error || 'Onjuiste gebruikersnaam of wachtwoord.');
    }
  } catch (error) {
    console.error('Fout tijdens inloggen:', error);
    showErrorMessage('Er is een fout opgetreden. Probeer het later opnieuw.');
  }
});

function showErrorMessage(message) {
  errorMessage.style.display = 'block';
  errorMessage.textContent = message;
}
