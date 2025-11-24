<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: error.php?error=request");
    exit;
}

$usuario = trim($_POST["usuario"] ?? "");
$edad    = trim($_POST["edad"] ?? "");

// Validación básica
if ($usuario === "" || $edad === "" || $edad <= 0 || !is_numeric($edad)) {
    header("Location: error.php?error=validacion");
    exit;
}

// Doble espacio en nombre
if (strpos($usuario, "  ") !== false) {
    header("Location: error.php?error=dobleespacio");
    exit;
}

// Mayor de edad
if ($edad < 18) {
    header("Location: error.php?error=edad");
    exit;
}

// Regex nombre válido
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]{3,}$/", $usuario)) {
    header("Location: error.php?error=nombre");
    exit;
}

// Si todo está bien, redirigir a éxito
$usuarioUrl = urlencode($usuario); // por seguridad en la URL
header("Location: exito.php?usuario=$usuarioUrl&edad=$edad");
exit;
