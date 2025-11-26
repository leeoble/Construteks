<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("No se recibió información");
}

$frase = trim($_POST["frase"] ?? "");

if(strpos($frase, "   ") !==false){
    echo "La frase tiene TRIPLE espacio.";
}elseif (strpos($frase, "  ") !==false){
    echo"La frase tiene DOBLE espacio. ";
}else{
    echo "La frase esta limpia";
}

<?php
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("die, die, die my darling.");
}

$frase = trim($_POST["frase"] ?? "");

$fraselimpia = preg_replace("/\s+/", " ", $frase);

echo "Original: $frase";
echo "Normalizada; $fraselimpia";



