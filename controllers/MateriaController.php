<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Materia.php";

class MateriaController
{
    private $materiaModel;
    public function __construct()
    {
        global $conexion;
        $this->materiaModel = new Materia($conexion);
    }

    // Listado de materias
    public function index()
    {
        $busqueda = trim($_GET["busqueda"] ?? "");
        $materias = $this->materiaModel->getAll($busqueda);
        require __DIR__ . "/../views/materias/index.php";
    }

    // Formulario para crear
    public function create()
    {
        $estados = $this->materiaModel->getEstados();
        $nombre = "";
        $anio_carrera = "";
        $anio_cursada = "";
        $nota = "";
        $anio_aprobacion = "";
        $id_estado = "";
        $error = "";
        require __DIR__ . "/../views/materias/create.php";
    }

    // Guardar nueva materia
    public function store()
    {
        $nombre = trim($_POST["nombre"] ?? "");
        $anio_carrera = (int)($_POST["anio_carrera"] ?? 0);
        $anio_cursada = (int)($_POST["anio_cursada"] ?? 0);
        $nota = trim($_POST["nota"] ?? "");
        $anio_aprobacion = trim($_POST["anio_aprobacion"] ?? "");
        $id_estado = (int)($_POST["id_estado"] ?? 0);

        $error = "";

        // Validaciones generales
        if (
            $nombre === "" ||
            $anio_carrera <= 0 ||
            $anio_cursada <= 0 ||
            $id_estado <= 0
        ) {
            $error = "Todos los campos obligatorios deben completarse.";
        }

        // Estado Regular o Libre
        if ($error === "" && ($id_estado == 1 || $id_estado == 3)) {
            if ($nota !== "" || $anio_aprobacion !== "") {
                $error = "Una materia Regular o Libre no puede tener nota ni año de aprobación.";
            } else {
                $nota = "";
                $anio_aprobacion = "";
            }
        }

        // Estado Aprobada
        if ($error === "" && $id_estado == 2) {
            if ($nota === "" || $anio_aprobacion === "") {
                $error = "Una materia Aprobada debe tener nota y año de aprobación.";
            } else {
                $notaNumero = (float)$nota;
                if ($notaNumero < 0 || $notaNumero > 10) {
                    $error = "La nota debe estar entre 0 y 10.";
                } else {
                    $nota = $notaNumero;
                }
                if ($error === "") {
                    $anio_aprobacion = (int)$anio_aprobacion;
                    if ($anio_aprobacion <= 0) {
                        $error = "El año de aprobación no es válido.";

                    }
                }
            }
        }

        // Si hay error, mostrar nuevamente el formulario
        if ($error !== "") {
            $estados = $this->materiaModel->getEstados();
            require __DIR__ . "/../views/materias/create.php";
            return;
        }

        // Crear materia
        $this->materiaModel->create(
            $nombre,
            $anio_carrera,
            $nota,
            $anio_cursada,
            $anio_aprobacion,
            $id_estado
        );

        // Redirigir mostrando mensaje de éxito
        header("Location: index.php?action=index&mensaje=creada");
        exit;
    }

    // Formulario para editar
    public function edit()
    {
        $id = (int)($_GET["id"] ?? 0);
        if ($id <= 0) {
            die("ID inválido.");
        }
        $materia = $this->materiaModel->getById($id);
        if (!$materia) {
            die("Materia no encontrada.");
        }
        $estados = $this->materiaModel->getEstados();
        $error = "";
        require __DIR__ . "/../views/materias/edit.php";
    }

    // Actualizar materia
    public function update()
    {
        $id = (int)($_POST["id"] ?? 0);
        $nombre = trim($_POST["nombre"] ?? "");
        $anio_carrera = (int)($_POST["anio_carrera"] ?? 0);
        $anio_cursada = (int)($_POST["anio_cursada"] ?? 0);
        $nota = trim($_POST["nota"] ?? "");
        $anio_aprobacion = trim($_POST["anio_aprobacion"] ?? "");
        $id_estado = (int)($_POST["id_estado"] ?? 0);
        $error = "";

        // Validaciones generales
        if (
            $id <= 0 ||
            $nombre === "" ||
            $anio_carrera <= 0 ||
            $anio_cursada <= 0 ||
            $id_estado <= 0
        ) {
            $error = "Todos los campos obligatorios deben completarse.";
        }

        // Estado Regular o Libre
        if ($error === "" && ($id_estado == 1 || $id_estado == 3)) {
            if ($nota !== "" || $anio_aprobacion !== "") {
                $error = "Una materia Regular o Libre no puede tener nota ni año de aprobación.";
            } else {
                $nota = "";
                $anio_aprobacion = "";
            }
        }

        // Estado Aprobada
        if ($error === "" && $id_estado == 2) {
            if ($nota === "" || $anio_aprobacion === "") {
                $error = "Una materia Aprobada debe tener nota y año de aprobación.";
            } else {
                $notaNumero = (float)$nota;
                if ($notaNumero < 0 || $notaNumero > 10) {
                    $error = "La nota debe estar entre 0 y 10.";
                } else {
                    $nota = $notaNumero;

                }

                if ($error === "") {
                    $anio_aprobacion = (int)$anio_aprobacion;
                    if ($anio_aprobacion <= 0) {
                        $error = "El año de aprobación no es válido.";

                    }
                }
            }
        }

        // Si hay error, mostrar nuevamente el formulario
        if ($error !== "") {
            $materia = [
                "id" => $id,
                "nombre" => $nombre,
                "anio_carrera" => $anio_carrera,
                "anio_cursada" => $anio_cursada,
                "nota" => $nota !== "" ? $nota : null,
                "anio_aprobacion" => $anio_aprobacion !== ""
                    ? $anio_aprobacion
                    : null,
                "id_estado" => $id_estado
            ];
            $estados = $this->materiaModel->getEstados();
            require __DIR__ . "/../views/materias/edit.php";
            return;
        }

        // Actualizar materia
        $this->materiaModel->update(
            $id,
            $nombre,
            $anio_carrera,
            $nota,
            $anio_cursada,
            $anio_aprobacion,
            $id_estado
        );

        // Redirigir mostrando mensaje de éxito
        header("Location: index.php?action=index&mensaje=actualizada");
        exit;
    }

    // Borrado lógico
    public function delete()
    {
        $id = (int)($_GET["id"] ?? 0);
        if ($id > 0) {
            $this->materiaModel->delete($id);
        }

        // Redirigir mostrando mensaje de éxito
        header("Location: index.php?action=index&mensaje=eliminada");
        exit;
    }
}