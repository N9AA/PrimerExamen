<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Materia.php";

try {
    $materiaModel = new Materia($conexion);
    $resultado = $materiaModel->getAll();
    $materias = [];
    while ($materia = $resultado->fetch_assoc()) {
        $materias[] = [
            "id" => (int)$materia["id"],
            "nombre" => $materia["nombre"],
            "anio_carrera" => (int)$materia["anio_carrera"],
            "nota" => $materia["nota"] !== null
                ? (float)$materia["nota"]
                : null,
            "anio_cursada" => (int)$materia["anio_cursada"],
            "anio_aprobacion" => $materia["anio_aprobacion"] !== null
                ? (int)$materia["anio_aprobacion"]
                : null,
            "estado" => $materia["estado"]
        ];
    }

    echo json_encode(
        $materias,
        JSON_UNESCAPED_UNICODE
    );

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "No se pudieron obtener las materias."
    ], JSON_UNESCAPED_UNICODE);
}