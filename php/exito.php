<?php

// Recuperar y validar parámetros
$usuario = urldecode($_GET["usuario"] ?? "");
$edad    = $_GET["edad"] ?? "";

// Si falta algo, redirigir al error general
if ($usuario === "" || $edad === "") {
    header("Location: error.php?error=request");
    exit;
}

// Mostrar mensaje bonito
echo "<h1>¡Formulario enviado con éxito!</h1>";
echo "<p>Gracias <strong>$usuario</strong>, hemos recibido tu información.</p>";
echo "<p>Tu edad registrada es: <strong>$edad</strong>.</p>";
echo "<p>Puedes volver al formulario cuando quieras.</p>";
