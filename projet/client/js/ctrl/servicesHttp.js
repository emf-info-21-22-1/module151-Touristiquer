//En test
const base_url = "http://localhost/srv"

// En prod
//const base_url = "https://benedettir.emf-informatique.ch/151/srv/";

const httpServices = {

    //Ajouter un utilisateur à la db, côté serveur hacher le mot de passe
    register(username, password){

        let data = {
            "action":"signUp",
            "username": username,
            "password": password
        }

        $.ajax({
            method: "POST",
            url: `${base_url}main.php`,
            dataType: "json",
            data: JSON.Stringify(data),
            xhrFields: {
                withCredentials: true
            },
            success: successCallback, // Pour toutes les réponses en code 200
            error: errorCallback // Pour toutes les réponses ayant un code autre que 200, ou mal formées
        });

    },

    login(username, password, successCallback, errorCallback) {

        let data = {
            "action":"signIn",
            "username": username,
            "password": password
        }

        $.ajax({
            method: "POST",
            url: `${base_url}main.php`,
            dataType: "json",
            data: JSON.Stringify(data),
            xhrFields: {
                withCredentials: true
            },
            success: successCallback, // Pour toutes les réponses en code 200
            error: errorCallback // Pour toutes les réponses ayant un code autre que 200, ou mal formées
        });

    },

    disconnect(successCallback, errorCallback) {

        let data = {
            "action":"disconnect"
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: `${base_url}main.php`,
            data: JSON.Stringify(data),
            xhrFields: {
                withCredentials: true
            },
            success: successCallback, // Pour toutes les réponses en code 200
            error: errorCallback // Pour toutes les réponses ayant un code autre que 200, ou mal formées
        });
    },

    loadMusics(pk_user, successCallback, errorCallback){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: `${base_url}main.php`,
            data: `action=listAllTitles&pk_user=${pk_user}`,
            xhrFields: {
                withCredentials: true
            },
            success: successCallback, // Pour toutes les réponses en code 200
            error: errorCallback // Pour toutes les réponses ayant un code autre que 200, ou mal formées
        });
    },

    //Fichier à mettre sur le serv
    uploadMusic(pk_user, titre, file, successCallback, errorCallback){

    }
}
