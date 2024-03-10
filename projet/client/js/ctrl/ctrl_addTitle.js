/*
  But     : Title Ctrl
  Auteur  : Romain Benedetti
  Date    : 10.03.2024 / v1.0 
*/

$().ready(() => {
    httpServices.loadMusics(successCallback, errorCallback);
});


function successCallback(response) {
    const scrollContent = $('.scroll-content');

    // Parcoure les titres
    response.forEach(title => {
        // Créez la bordure pour ajouter le titre
        const titleLink = $('<a>').attr('href', '#').addClass('block max-w-48 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700');

        // Ajoute l'image
        const titleImage = $('<img>').addClass('mb-2 rounded-lg shadow-xl dark:shadow-gray-800').attr('src', title.Image).attr('alt', 'image description');

        // Ajoute le nom du titre
        const titleName = $('<h5>').addClass('text-1xl font-bold tracking-tight text-gray-900 dark:text-white').text(title.name);

        // Ajoute le nom de l'artiste
        const artistName = $('<p>').addClass('font-normal text-gray-700 dark:text-gray-400').text(title.username);

        //Combiner les 3 choses 
        titleLink.append(titleImage, titleName, artistName);
        scrollContent.append(titleLink);
    });
}

// Fonction pour gérer l'échec de la connexion
function errorCallback(error) {
    console.error('Error:', error);
}