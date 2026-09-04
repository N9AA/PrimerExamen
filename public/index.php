<?php

require_once __DIR__ . "/../controllers/MateriaController.php";

$materiaController = new MateriaController();

$action = $_GET["action"] ?? "index";

switch ($action) {

    case "index":
        $materiaController->index();
        break;

    case "create":
        $materiaController->create();
        break;

    case "store":
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }

        $materiaController->store();
        break;

    case "edit":
        $materiaController->edit();
        break;

    case "update":
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            die("Método no permitido.");
        }

        $materiaController->update();
        break;

    case "delete":
        $materiaController->delete();
        break;

    default:
        die("Acción no encontrada.");
}