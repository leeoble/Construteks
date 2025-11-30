<?php

/* -------------------------------------------------------
   1. Verificar método POST
------------------------------------------------------- */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html?msg=request");
    exit;
}

/* -------------------------------------------------------
   2. Recopilar datos
------------------------------------------------------- */
$tipo        = trim($_POST["tipo"] ?? "");
$dimensiones = trim($_POST["dimensiones"] ?? "");
$nota        = trim($_POST["nota"] ?? "");
$nombre      = trim($_POST["nombre"] ?? "");
$telefono    = trim($_POST["telefono"] ?? "");
$correo      = trim($_POST["correo"] ?? "");
$ciudad      = trim($_POST["ciudad"] ?? "");
$compania    = trim($_POST["compania"] ?? "");
$formTs      = isset($_POST["form_ts"]) ? (int) $_POST["form_ts"] : 0;

/* -------------------------------------------------------
   3. Validaciones (proyecto) y HP
------------------------------------------------------- */
if (!empty($compania)) {
    // El bot llenó el campo "compania" (humano nunca lo ve)
    // Fingimos éxito, pero NO enviamos correo.
    header("Location: index.html?msg=exito");
    exit;
}

// Si llega timestamp del cliente, validar envío mínimo en 3s
if ($formTs > 0) {
    $now = $_SERVER["REQUEST_TIME_FLOAT"] ?? microtime(true);
    $elapsed = $now - ($formTs / 1000);
    if ($elapsed < 3) {
        header("Location: index.html?msg=fast");
        exit;
    }
}

if ($tipo === "") {
    header("Location: index.html?msg=tipo");
    exit;
}

if ($dimensiones === "" || mb_strlen($dimensiones) < 5) {
    header("Location: index.html?msg=dimensiones");
    exit;
}

if ($nota === "" || mb_strlen($nota) < 10) {
    header("Location: index.html?msg=nota");
    exit;
}

/* -------------------------------------------------------
   3b. Validaciones (contacto)
------------------------------------------------------- */

// Nombre vacío
if ($nombre === "") {
    header("Location: index.html?msg=nombre");
    exit;
}

// Que el nombre no contenga caracteres raros (mínimo 3 letras)
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,}$/u", $nombre)) {
    header("Location: index.html?msg=nombreMatch");
    exit;
}
$nombreLimpio = preg_replace("/\s+/", " ", $nombre);

// Limpiar teléfono a solo dígitos
$telefonoSoloDigitos = preg_replace("/\D+/", "", $telefono);

// Teléfono vacío o demasiado corto
if ($telefonoSoloDigitos === "" || strlen($telefonoSoloDigitos) < 10) {
    header("Location: index.html?msg=telefono");
    exit;
}

// Correo vacío o inválido
if ($correo === "" || !preg_match("/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/", $correo)) {
    header("Location: index.html?msg=correo");
    exit;
}
/* -------------------------------------------------------
   3c. Maximos permitidos de mensaje
------------------------------------------------------- */
$dimensionesMax = mb_substr($dimensiones, 0, 70, 'UTF-8');
$notaMax        = mb_substr($nota, 0, 500, 'UTF-8');
$nombreMax      = mb_substr($nombreLimpio, 0, 100, 'UTF-8');
$ciudadMax      = mb_substr($ciudad, 0, 50, 'UTF-8');

$longCorreo      = mb_strlen($correo, 'UTF-8');
if ($longCorreo > 120 ){
    header("Location: index.html?msg=correoLargo");
    exit;
}
/* -------------------------------------------------------
   3d. Saneamiento
------------------------------------------------------- */
$tipoSafe        = htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8');
$dimensionesSafe = htmlspecialchars($dimensionesMax, ENT_QUOTES, 'UTF-8');
$notaSafe        = htmlspecialchars($notaMax, ENT_QUOTES, 'UTF-8');
$nombreSafe      = htmlspecialchars($nombreMax, ENT_QUOTES, 'UTF-8');
$telefonoSafe    = htmlspecialchars($telefonoSoloDigitos, ENT_QUOTES, 'UTF-8');
$correoSafe      = htmlspecialchars($correo, ENT_QUOTES, 'UTF-8');
$ciudadSafe      = htmlspecialchars($ciudadMax, ENT_QUOTES, 'UTF-8');

/* -------------------------------------------------------
   4. Construir mensaje email
------------------------------------------------------- */
$para   = "hola@construteks.com";
$asunto = "Nuevo proyecto enviado desde Construteks";

$mensaje  = "Nuevo proyecto enviado:\n\n";
$mensaje .= "=== DATOS DEL PROYECTO ===\n";
$mensaje .= "Tipo de proyecto: $tipoSafe\n";
$mensaje .= "Dimensiones clave: $dimensionesSafe\n";
$mensaje .= "Requerimiento especial:\n$notaSafe\n\n";

$mensaje .= "=== DATOS DE CONTACTO ===\n";
$mensaje .= "Nombre: $nombreSafe\n";
$mensaje .= "Telefono: $telefonoSafe\n";
$mensaje .= "Correo: $correoSafe\n";
if ($ciudad !== "") {
    $mensaje .= "Ciudad: $ciudadSafe\n";
}

/* -------------------------------------------------------
   5. Cabeceras
------------------------------------------------------- */
$headers  = "From: Formulario Construteks <hola@construteks.com>\r\n";
$headers .= "Reply-To: " . $correoSafe . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

/* -------------------------------------------------------
   6. Enviar correo
------------------------------------------------------- */
$enviado = mail($para, $asunto, $mensaje, $headers);

/* -------------------------------------------------------
   7. Respuesta final
------------------------------------------------------- */
if ($enviado) {
    header("Location: index.html?msg=exito");
    exit;
} else {
    header("Location: index.html?msg=mailFail");
    exit;
}
