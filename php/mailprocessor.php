<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Chat me dijo que escribiera esto");
}

$usuario = trim($_POST["usuario"] ?? "");
$edad = trim($_POST["edad"] ?? "");

if ($usuario === "" || $edad === "" || $edad <= 0 || !is_numeric($edad)) {
    die("algo salió mal");
}
if (strpos($usuario, "  ") !==false){
    die("el nombre no puede tener doble espacio");
}

if ($edad < 18) {
    die("Debes ser mayor de edad.");
}
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]{3,}$/", $usuario)){
    die("nombre no valido");
}
echo "Hola $usuario, tienes $edad años.";


<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header(Location: error.php?error=request);
}

$usuario = trim($_POST["usuario"] ?? "");
$edad = trim($_POST["edad"] ?? "");

if ($usuario === "" || $edad === "" || $edad <= 0 || !is_numeric($edad)) {
    header(Location: error.php?error=validacion);
    exit;
}
if (strpos($usuario, "  ") !==false){
    header(Location: contact.php?error=dobleespacio);
    exit;
}

if ($edad < 18) {
    header(Location: error.php?error=edad);
    exit;
}
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]{3,}$/", $usuario)){
    header("Location: error.php?error=nombre");
    exit;
}else{
    header(Location: exito.php?usuario=$usuario&edad=$edad);
    exit;
}

<?php
if(isset($_GET["request"])){
    echo "Error en el metodo."
}

if(isset($_GET["validacion"])){
    echo "Nomre o edad no validos";
}
if(isset($_GET["dobleespacio"])){
    echo "El nombre no puede contener doble espacio"; 
}
if(isset($_GET["edad"])){
    echo "Debes ser mayor de edad.";
}
if(isset($_GET["nombre"])){
    echo "Nombre no valido";
}


<?php
if(isset($_GET["request"])){
    echo "Error en el metodo."
}




    header("Location: error.php?error=nombre");
        header(Location: error.php?error=nombre);


// Mostrar mensaje bonito
echo "<h1 class="tittle">¡Formulario enviado con éxito!</h1>";
echo "<p class="subcopy">Gracias <strong>$usuario</strong>, hemos recibido tu información.</p>";
echo "<p class="subcopy">Tu edad registrada es: <strong>$edad</strong>.</p>";
echo "<p class="subcopy">Puedes volver al formulario cuando quieras.</p>";