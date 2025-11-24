<?php

$error = $_GET["error"] ?? "";

if ($error === "request") {
    echo "Error en el método de envío.";
}

if ($error === "validacion") {
    echo "Nombre o edad no válidos.";
}

if ($error === "dobleespacio") {
    echo "El nombre no puede contener doble espacio.";
}

if ($error === "edad") {
    echo "Debes ser mayor de edad.";
}

if ($error === "nombre") {
    echo "Nombre no válido.";
}
