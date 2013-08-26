
<?php 

include("../negocio/cPublicidad.class.php"); 
$objeto = new  cPublicidad();	
$res = $objeto->buscar();   

$respuesta = "[";
foreach($res as $reg){

    $respuesta .= "{
      \"content\": \"<div class='slide_inner'><a class='photo_link' href='#'><img class='photo' src='admin/" . $reg["imagen"] . "' alt=''></a><a class='caption' href='#'>Sample Carousel Pic Goes Here And The Best Part is that...</a></div>\",
      \"content_button\": \"<div class='thumb'><img src='admin/" . $reg["imagen"] . "' alt=''></div><p>Agile Carousel Place Holder</p>\"
    },";
    
}
$respuesta = substr($respuesta, 0, -1);
$respuesta .= "]";

echo $respuesta;

//, {
//      "content": "<div class='slide_inner'><a class='photo_link' href='#'><img class='photo' src='img/foto1.jpg' alt='Paint'></a><a class='caption' href='#'>Sample Carousel Pic Goes Here And The Best Part is that...</a></div>",
//      "content_button": "<div class='thumb'><img src='img/foto1.jpg' alt='bike is nice'></div><p>Agile Carousel Place Holder</p>"
//}]

?>