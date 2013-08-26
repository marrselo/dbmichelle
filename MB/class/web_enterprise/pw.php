<?
function generar_password () {
$i=0;
$password="";
// Aqui colocamos el largo del password
$pw_largo = 5;
// Colocamos el rango de caracteres ASCII para la creacion de el password
$desde_ascii = 50; // "2"
$hasta_ascii = 122; // "z"
// Aqui quitamos caracteres especiales
$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
while ($i < $pw_largo) {
mt_srand ((double)microtime() * 1000000);
// limites aleatorios con tabla ASCII
$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii);
if (!in_array ($numero_aleat, $no_usar)) {
$password = $password . chr($numero_aleat);
$i++;
}
}
return $password;

}
// Y aqui ejecutamos la funcion y la guardamos en $p_generado, luego simplemente la cargamos
$p_generado=generar_password();
$nuevo2=date("H");
$nuevo=date("d");
$pwn=$nuevo.$p_generado.$nuevo2;
$dia=date("d")."-".date("m")."-".date("y");
?>