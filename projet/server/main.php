<?php
include_once('wrk/WrkLogin.php');
include_once('wrk/WrkTitle.php');

$wrkTitle = new WrkTitre();
$wrkLogin = new WrkLogin();
$wrkLogin->startSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == "connect") {
        $ok = $wrkLogin->testlogin($_POST['username'], $_POST['password']);
        if ($ok != null) {
            echo '{"user":"' . $ok . '"}';
            http_response_code(200);
        } else {
            http_response_code(401);
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['get'] == "allTitles") {
        $retour = $wrkTitle->afficheallTitlesToJson();
        if ($retour != null) {
            echo $retour;
            http_response_code(200);
        } else {
        }
    }
    if ($_GET['get'] == 'searchTitle') {
        $retour = $wrkTitle->affichesearchTitleToJson($_GET['searchedString']);
        if ($retour != null) {
            echo $retour;
            http_response_code(200);
        } else {
        }
    }
    if ($_GET['get'] == 'deconect') {
        $ok = $wrkLogin->deconect();
        if ($ok) {
            echo ($ok);
            http_response_code(200);
        } else {
            http_response_code(401);
        }
    }
    if ($_GET['get'] == 'UserTitles') {
        $retour = $wrkTitle->afficheUserTitleToJson();
        if ($retour != null) {
            if ($retour == 'NOK') {
                http_response_code(403);
            } else {
                echo $retour;
                http_response_code(200);
            }
        }
    }
    if ($_GET['get'] == 'titlesUserNotHave') {
        $retour = $wrkTitle->titlesUserNotHaveToJson();
        if ($retour != null) {
            if ($retour == 'NOK') {
                http_response_code(403);
            } else {
                echo $retour;
                http_response_code(200);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $vars);
    if ($vars["delete"] == "delTitle") {
        $retour = $wrkTitle->delTitleToJson($vars['titleName']);
        if ($retour == 'NOK') {
            http_response_code(403);
        } else {
            if ($retour) {
                echo $retour;
                http_response_code(200);
            } else {
                http_response_code(500);
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $vars);
    if ($vars["put"] == "addTitleNameUserList") {
        $retour = $wrkTitle->addTitleUserListToJson($vars['titlesName']);
        if ($retour != null) {
            if ($retour == 'NOK') {
                http_response_code(403);
            } else {
                if ($retour) {
                    echo $retour;
                    http_response_code(200);
                } else {
                    http_response_code(500);
                }
            }
        }
    }
}
