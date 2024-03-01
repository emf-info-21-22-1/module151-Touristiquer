/*
  But     : login Ctrl
  Auteur  : Romain Benedetti
  Date    : 01.03.2024 / v1.0 
*/

$().ready(() => {
    httpServ = new servicesHttp();
    loginCtrl = new ctrl_login();
});

class ctrl_login {

    constructor() {
        // contrôle si l'utilisateur est connecté au lancement du site
        httpServ.checkIfConnected((res) => {
            if (res.isConnected) {
                this.showAllConnected();
            }
        });
    }



}