/*
  But     : login Ctrl
  Auteur  : Romain Benedetti
  Date    : 01.03.2024 / v1.0 
*/

// Définir une variable pour suivre l'état de connexion
let loggedIn = false;

$().ready(() => {

    // Masquer ou afficher les liens au chargement de la page
    toggleLinksVisibility();

    // Appeler la fonction de connexion avec les valeurs des champs
    document.getElementById('submit-login').addEventListener('click', function (event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        // Récupérer les valeurs des champs username et password
        const username = document.getElementById('username-field').value;
        const password = document.getElementById('password-field').value;

        // Appeler la fonction de connexion avec les valeurs des champs
        httpServices.login(username, password, loginSuccess, loginError);

        // Masquer ou afficher les liens au chargement de la page
        toggleLinksVisibility();
    });

    document.getElementById('deconnect-user').addEventListener('click', function (event) {
        event.preventDefault();
        // Appel de la fonction de déconnexion avec les fonctions de rappel appropriées
        httpServices.disconnect(disconnectSuccess, disconnectError);
        loggedIn = false;
        toggleLinksVisibility();
    })
});

// Fonction pour gérer la réussite de la connexion
function loginSuccess(response) {
    // Traiter la réponse du serveur
    if (response.success) {
        // Connexion réussie, rediriger l'utilisateur ou effectuer d'autres actions
        loggedIn = true;
        console.log('Login successful');

        // Met à jour les informations utilisateur
        updateUserInfo(response.username, response.email);

    } else {
        // Afficher un message d'erreur à l'utilisateur
        console.error('Login failed:', response.message);
    }
}

// Fonction pour gérer l'échec de la connexion
function loginError(error) {
    console.error('Error:', error);
}

// Fonction pour masquer ou afficher les liens en fonction de l'état de connexion
function toggleLinksVisibility() {
    // Sélectionner les liens à masquer ou afficher
    const artistConnected = document.querySelector('#connected-link');
    const upload = document.querySelector('#upload-link');
    const profile = document.querySelector('#profile-link');
    const login = document.querySelector('#login-link');
    const register = document.querySelector('#register-link');

    if (loggedIn) {
        //afficher
        artistConnected.classList.remove('hidden');
        upload.classList.remove('hidden');
        profile.classList.remove('hidden');
        //Cacher
        login.classList.add('hidden');
        register.classList.add('hidden');
    } else {
        //Cacher
        artistConnected.classList.add('hidden');
        upload.classList.add('hidden');
        profile.classList.add('hidden');
        //afficher
        login.classList.remove('hidden');
        register.classList.remove('hidden');
    }
}

function logout() {
    httpServices.disconnect(disconnectSuccess, disconnectError);
    loggedIn = false;
}

function disconnectSuccess(response) {
    // Traiter la réponse du serveur
    if (response.success) {
        // Déconnexion réussie, mettre à jour l'état de connexion
        console.log('Logout successful');
    } else {
        // Afficher un message d'erreur à l'utilisateur
        console.error('Logout failed:', response.message);
    }
}

function disconnectError(error) {
    console.error('Error:', error);
}

// Fonction pour mettre à jour les informations utilisateur
function updateUserInfo(username, email) {
    // Sélectionne les éléments pour afficher le nom et l'email
    const usernameElement = document.querySelector('#username-display');
    const emailElement = document.querySelector('#email-display');

    // Met à jour les nouvelles informations
    usernameElement.textContent = username;
    emailElement.textContent = email;
}
