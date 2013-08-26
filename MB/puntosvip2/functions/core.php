<?php 
function titles($fichero){
    
    switch ($fichero){
        case 'beneficios_tarjeta.php':
            $src='img/beneficios_tarjeta.jpg';
            break;
        case 'preguntas_frecuentes.php':
            $src='img/preguntas--frecuentes.jpg';
            break;
        case 'informacion_tarjeta.php':
            $src='img/info_tarjeta_1.jpg';
            break;
        case 'catalogodetalle.php':
            $src='img/pronto.jpg';
            break;
        case 'afiliado.php' :
            $src='img/beneficios_tarjeta.jpg';
            break;
        case 'puntosvip.php' :
            $src='css/images/textodni.jpg';
            break;
        case 'login_empresa.php':
        case 'validar_vip.php':
            $src='img/consultaclientes.jpg';
            break;        
        case 'establecimientos_afiliados.php':
            $src='img/afiliados.jpg';
        default:
            $src='';
    }
    $img='<img src='.$src.' height="17">';
    return $img;
}


class detailPage{
    
    protected $_fichero;
    protected $_banner;
    protected $_text;
    protected $_logo;
    protected $_dcto;
    public function __construct($fichero) {
        $this->_fichero=$fichero;
        $options=$this->options();
        $this->_banner=$options['banner'];
        $this->_text=$options['text'];
        $this->_dcto=$options['dcto'];
        $this->_logo=$options['logo'];
    }
    
    public function getBanner()
    {
        return $this->_banner;
    }
    
    public function getText()
    {
        return $this->_text;
    }
    
    public function getDcto()
    {
        return $this->_dcto;
    }
    
    public function getLogo()
    {
        return $this->_logo;
    }
    
    public function options()
    {
        switch($this->_fichero)
        {
            case 'country_club':                
                $logo='img/1_03.jpg';
                $banner='img/1_07.jpg';
                $dcto='img/1_10_1.jpg';
                $text='*Los Eucaliptos 590 San Isidro, Lima 27, Perú *Descuento de Martes a Viernes de 5:30 a 8:30 pm. Previa Reserva al 611 9007. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI.
                    Descuento válido hasta el 24/04/14 ';
                break;
            case 'restaurant_rodrigo' :
                $logo='img/1_03_1.jpg';
                $banner='img/1_07_1.jpg';
                $dcto='img/1_10_2.jpg';     
                $text='Francisco de Paula Camino 231 Miraflores *No acumulable con otros descuentos y/o promociones. No aplica para fechas especiales: Día de la Madre, Día del Padre, Fiestas Patrias y Año Nuevo. Este descuento es exclusivo y válido con la presentación de la tarjeta 
VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'joyeria_murguia' :
                $logo='img/1_03_2.jpg';
                $banner='img/1_07_2.jpg';
                $dcto='img/1_10_3.jpg';
                $text='Av. Diagonal 344, Miraflores – Av. Pardo y Aliaga 572, San Isidro - Av. Primavera 517 Chacarilla del Estanque San Borja, Lima. *Los descuentos son: Baccarat 15%, LSA 20%, Lalique 15%, Daum 20%, Christofle 15%, St Dupont 15%, Rolex 5%, Riva 15%, Joyas 15% No acumulable con otros descuentos y/o promociones. No aplica mercadería en consignación. No aplicable en servicio técnico. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'karen_mitre' :
                $logo='img/KAREN-MITRE_03.jpg';
                $banner='img/KAREN-MITRE_07.jpg';
                $dcto='img/KAREN-MITRE_09.jpg';
                $text='*Av. Pardo y Aliaga 699 – A San Isidro, Lima – Perú / L- S de 10 am – 7 pm *Descuento sólo en carteras. No acumulable con otras promociones y/ o descuentos. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'sushito' :
                $logo='img/SUSHITO_03.jpg';
                $banner='img/SUSHITO_07.jpg';
                $dcto='img/SUSHITO_09.jpg';     
                $text='*C.C El Polo: Av. El Polo 740, Monterrico Santiago de Surco, Lima - Perú *Válido solo para consumos en el salón. No acumulable con otras promociones y/ o descuentos. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'fiamma' :
                $logo='img/FIAMMA_03.jpg';
                $banner='img/FIAMMA_07.jpg';
                $dcto='img/FIAMMA_09.jpg';
                $text='*C.C El Polo: Av. El Polo 759, Monterrico Santiago de Surco, Lima - Perú *Válido solo para consumos en el salón. No acumulable con otras promociones y/ o descuentos. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'marathon' :
                $logo='img/MARATHON_03.jpg';
                $banner='img/MARATHON_07.jpg';
                $dcto='img/MARATHON_09.jpg';
                $text='*Jockey Plaza. C.C San Miguel, C.C La Rambla – San Borja, C.C Real Plaza Primavera, C.C Megaplaza, C.C Mall Aventura Plaza Santa Anita, C. C Parque Lambramani – Arequipa, C.C El Quinde – Ica y Boulevard de Asia (sólo verano) *No acumulable con otras promociones y/ o descuentos. Descuento máximo de s/. 250 por compra. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'sport_life' :
                $logo='img/SPORT-LIFE_03.jpg';
                $banner='img/SPORT-LIFE_07.jpg';
                $dcto='img/SPORT-LIFE_09.jpg';
                $text='*Descuento válido sobre plan trimestral de tarifa regular. Tres meses igual a 90 días, los días de congelamiento de acuerdo a lo establecido en el contrato de membresía. Dos días libres válido solo para socios nuevos, días de uso consecutivos. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'westin' :
                $logo='img/1_34.jpg';
                $banner='img/westin-img.jpg';
                $dcto='img/westin-letter.jpg';
                $text='*Válido sobre tarifa BAR1 (pueden solicitarlas a reservars@libertador.com.pe). No incluye desayuno Previa reserva. Sujeto a disponibilidad. Aplican restricciones de fecha. No acumulale con otros promociones. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI Descuento válido hasta el 24/04/14 ';
                break;
            case 'green_house' :
                $logo='img/1_37.jpg';
                $banner='img/1_10.jpg';
                $dcto='img/1_14.jpg';
                $text='*Calle Los Copales 122, Urb. Los Sirius, La Molina (Alt. Cdra. 12 de Raúl Ferrero) en Molina Plaza – T: 365-9595 www.greenhouse.com.pe *No acumulable con otras promociones. No aplica para complementos (peluches, licores, chocolates). Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'dtinto' :
                $logo='img/DE-TINTO-Y-BIFE_03.jpg';
                $banner='img/DE-TINTO-Y-BIFE_07.jpg';
                $dcto='img/DE-TINTO-Y-BIFE_09.jpg';
                $text='*Solo válido en : Av. Costa Verde s/n Playa las Cascadas Boulevard Bordemar Barranco. *Descuento máximo de s/. 100. No acumulable con otras promociones y/ o descuentos. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'segundo_muelle' :
                $logo='img/SEGUNDO-MUELLE_03.jpg';
                $banner='img/SEGUNDO-MUELLE_07.jpg';
                $dcto='img/SEGUNDO-MUELLE_09.jpg';
                $text='*Solo válido en : Av. Costa Verde s/n Playa las Cascadas Boulevard Bordemar Barranco. *Descuento máximo de s/. 100. No acumulable con otras promociones y/ o descuentos. Chilcano de Cortesía. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI. Descuento válido hasta el 24/04/14 ';
                break;
            case 'amarige' :
                $logo='img/detalle/14/logo.jpg';
                $banner='img/detalle/14/img.jpg';
                $dcto='img/detalle/14/letter.jpg';
                $text='*Av. Primavera 609 Chacarilla, Lima T: 319 0090 – Av. Emilio Cavenecia 129 San Isidro, Lima T: 208 2720 , sólo pago en efectivo. No incluye paquetes, productos ni extensiones. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI Descuento válido hasta el 24/04/14 ';
                break;
            case 'bonbonniere' :
                $logo='img/1_03_3.jpg';
                $banner='img/1_07_3.jpg';
                $dcto='img/1_10_4.jpg';
                $text='*Boulevard del C.C. Jockey Plaza 2° piso, Surco, Lima - Calle Burgos 415 San Isidro, Lima C.C. Larcomar 242 Miraflores, Lima - Aeropuerto Internacional Jorge Chávez, Gate 21 - Salidas Internacionales. *Descuento máximo de S/.100. No acumulable con otras promociones y/o descuentos. Este descuento es exclusivo y válido con la presentación de la tarjeta VIP y DNI Descuento válido hasta el 24/04/14 ';
                break;  
            default :
                $logo='';$banner='';$dcto='';$text='';
        }        
        return $array=array('logo'=>$logo,'banner'=>$banner
                ,'dcto'=>$dcto,'text'=>$text);
    }
}