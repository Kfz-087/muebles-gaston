<?php
function isLogin()
{
    return isset($_SESSION['user']);
}

function requireLogin()
{
    if (!isLogin()) {

        // Detectar si es request AJAX/fetch
        $isAjax = false;

        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            $isAjax = true;
        }

        if ($isAjax) {
            // Respuesta JSON limpia (no redireccionar)
            header('Content-Type: application/json');
            echo json_encode(["error" => "NO_AUTH"]);
            exit();
        }

        // Request normal → redirección
        header('Location: ' . '../index.php');
        exit();
    }
}


function isSuperAdmin()
{
    return isset($_SESSION['user']) && ($_SESSION['user']['rol'] == 0);
}

function isAdmin()
{
    return isset($_SESSION['user']) && ($_SESSION['user']['rol'] == 1);
}

function isInstructor()
{
    return isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] == 2;
}

function idAdminOrInstructor()
{
    if (isAdmin() || isSuperAdmin()) {
        header('Location: ' . '../admin');
        exit();
    } elseif (isInstructor()) {
        header('Location: ' . '../instructor');
        exit();
    }
}

function redirectIfLoggedIn()
{
    if (isset($_SESSION['user'])) {
        if (isAdmin() || isSuperAdmin()) {
            header('Location: ' . '../admin');
            exit();
        } else {
            header('Location: ' . '../instructor');
            exit();
        }
    }
}
?>