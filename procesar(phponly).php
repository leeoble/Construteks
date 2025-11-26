<?php

// 1. Verificar que venga de POST
if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: error.php?error=request");
    exit;
}

// 2. Leer y limpiar los datos del formulario
$tipo           = trim($_POST["tipo"] ?? "");
$dimensiones    = trim($_POST["dimensiones"] ?? "");
$nota           = trim($_POST["nota"] ?? "");

// 3. Validaciones
$errores = [];

if ($tipo === ""){
    $errores[] = "El tipo de proyecto es obligatorio.";
}

if ($dimensiones === "" || mb_strlen($dimensiones) < 5){
    $errores[] = "Describe las dimensiones en al menos 5 caracteres.";
}

if ($nota === "" || mb_strlen($nota) < 10){
    $errores[] = "Cuéntanos un poco más del requerimiento especial (mínimo 10 caracteres).";
}

// 4. Mostrar errores
if(!empty($errores)){
    echo "<h1 class='form-error'>Hubo un problema con la información</h1>";
    echo "<ul>";
    foreach ($errores as $error){
        echo "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo "</ul>";
    echo "<p class='ff-normal fs-400 fw-400 text-dark2'>
            <a href='index.html'>Volver a la página principal</a>
          </p>";
    exit;
}

// 5. Envío de correo
$para       = "hola@construteks.com";
$asunto     = "Nuevo proyecto desde el sitio web";

$mensaje  = "Se ha recibido un nuevo proyecto:\r\n\r\n";
$mensaje .= "Tipo de proyecto: $tipo\r\n";
$mensaje .= "Dimensiones clave: $dimensiones\r\n";
$mensaje .= "Requerimiento especial:\r\n$nota\r\n\r\n";
$mensaje .= "Fecha: " . date("d-m-Y") . "\r\n";

$headers  = "From: Formulario Construteks <hola@construteks.com>\r\n";
$headers .= "Reply-To: hola@construteks.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$enviado = mail($para, $asunto, $mensaje, $headers);

// 6. Respuesta al usuario
if ($enviado){
    header("Location: exito.php");
    exit;
} else {
    echo "<h1>Error al enviar el proyecto</h1>";
    echo "<p>No fue posible enviar tu información, intenta más tarde.</p>";
    echo "<a href='index.html'>Volver</a>";
}
