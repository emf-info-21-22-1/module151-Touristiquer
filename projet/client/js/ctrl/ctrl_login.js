/*
  But     : login Ctrl
  Auteur  : Romain Benedetti
  Date    : 01.03.2024 / v1.0 
*/

// Définir une variable pour suivre l'état de connexion
let loggedIn = false;


$().ready(() => {

    // Définir une variable pour suivre l'état de connexion
    let loggedIn = false;

    // Appeler la fonction pour masquer ou afficher les liens au chargement de la page
    toggleLinksVisibility();

    // Appeler la fonction de connexion avec les valeurs des champs
    document.getElementById('submit-login').addEventListener('click', function (event) {
        event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        // Récupérer les valeurs des champs username et password
        const username = document.getElementById('username-field').value;
        const password = document.getElementById('password-field').value;

        // Appeler la fonction de connexion avec les valeurs des champs
        httpServices.login(username, password, loginSuccess, loginError);
    });
});

// Fonction pour gérer la réussite de la connexion
function loginSuccess(response) {
    // Traiter la réponse du serveur
    if (response.success) {
        // Connexion réussie, rediriger l'utilisateur ou effectuer d'autres actions
        loggedIn = true;
        console.log('Login successful');
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

    if (loggedIn) {
        artistConnected.classList.remove('hidden');
    } else {
        artistConnected.classList.add('hidden');
    }
}
