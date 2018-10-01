<?php
# Autor: Nicolas Corvalan Wechsler

require 'exceptionhandler.php';
require 'wsaa.class.php';
require 'wsfev1.class.php';

$wsaa = new WSAA('./'); 

// Si la fecha de expiracion es menor a hoy, obtengo un nuevo Ticket de Acceso.
if($wsaa->get_expiration() < date("Y-m-d h:m:i")) {
  if ($wsaa->generar_TA()) {
    echo 'Obtenido nuevo TA<br>';  
  } else {
    echo 'error al obtener el TA';
  }
} else {
  echo 'Fecha de vencimiento del TA '.$wsaa->get_expiration().'<br>';
};

$wsfe = new WSFEV1('./');
 
 
// Carga el archivo TA.xml
$wsfe->openTA();
  
// devuelve el cae
$ptovta = 4;
$tipocbte = 6; 

/*
- 01, 02, 03, 04, 05,34,39,60, 63 para los clase A
- 06, 07, 08, 09, 10, 35, 40,64, 61 para los clase B.
- 11, 12, 13, 15 para los clase C.
- 51, 52, 53, 54 para los clase M.
- 49 para los Bienes Usados
Consultar método FEParamGetTiposCbte.
*/
$tipofactura = 'B';

$nc='';

// Ultimo comprobante autorizado, a este le sumo uno para procesar el siguiente.
$cmp = $wsfe->FECompUltimoAutorizado($tipocbte, $ptovta);

//Armo array con valores hardcodeados de la factura.
$regfac['concepto'] = 1; 					# 1: productos, 2: servicios, 3: ambos
$regfac['tipodocumento'] = 80;				# 80: CUIT, 96: DNI, 99: Consumidor Final
$regfac['numerodocumento'] = 1111111111;	# 0 para Consumidor Final (<$1000)
$regfac['cuit'] = 1111111111;
$regfac['importetotal'] = 121.67;			# total del comprobante
$regfac['capitalafinanciar'] = 0;			# subtotal de conceptos no gravados
$regfac['importeneto'] = 100.55;			# subtotal neto sujeto a IVA
$regfac['importeiva'] = 21.12;
$regfac['imp_trib'] = 1.0;
$regfac['imp_op_ex'] = 0.0;
$regfac['nrofactura'] = $cmp->FECompUltimoAutorizadoResult->CbteNro + 1;
$regfac['fecha_venc_pago'] = date('Ymd');

// Armo con la factura los parametros de entrada para el pedido 
$params = $wsfe->armadoFacturaUnica(
						$tipofactura,
						$ptovta,    // el punto de venta
						$nc,
						$regfac     // los datos a facturar
				);

//Solicito el CAE
$cae = $wsfe->solicitarCAE($params);								

// Lo muestro
print_r($cae);

?>