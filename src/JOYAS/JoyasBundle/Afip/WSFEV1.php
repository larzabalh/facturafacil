<?php
namespace JOYAS\JoyasBundle\Afip;
use JOYAS\JoyasBundle\Afip\Exceptionhandler;
# Autor: Nicolas Corvalan Wechsler

class WSFEV1{
  const TA   = "/xmlgenerados/TA.xml";          # Archivo con el Token y Sign
  const PASSPHRASE = "";                        # The passphrase (if any) to sign
  const PROXY_ENABLE = false;
  const LOG_XMLS = false;

#TESTING
  const CERT = "/keys/cwcert.crt";        		  # The X.509 certificate in PEM format
  const PRIVATEKEY = "/keys/cwkey.key";           # La clave privada
  const WSDL = "/wsfev1test.wsdl";                # WSDL TESTING
  const WSFEURL = "https://wswhomo.afip.gov.ar/wsfev1/service.asmx"; // testing


/*
#PRODUCCION
  const PRIVATEKEY = "/keys/carabajalraul.key";         # La clave privada
  const CERT = "/keys/carabajraul.crt";        	  # The X.509 certificate in PEM format
  const WSDL = "/wsfev1prod.wsdl";                # WSDL PRODUCCION
  const WSFEURL = "https://servicios1.afip.gov.ar/wsfev1/service.asmx"; // PRODUCCION
*/



  /*
   * el path relativo, terminado en /
   */
  private $path = './';

  /*
   * manejo de errores
   */
  public $error = '';

  /**
   * Cliente SOAP
   */
  private $client;

  /**
   * objeto que va a contener el xml de TA
   */
  private $TA;

  /*
   * Constructor
   */
  public function __construct($path = './')
  {
    $this->path = dirname(__FILE__);

    // seteos en php
    ini_set("soap.wsdl_cache_enabled", "0");

    // validar archivos necesarios
    if (!file_exists($this->path.self::WSDL)) $this->error .= " Failed to open ".self::WSDL;

    if(!empty($this->error)) {
      throw new \Exception('WSFEv1 class. Faltan archivos para el funcionamiento de la clase');
    }

    $this->client = new \SoapClient($this->path.self::WSDL, array(
              'soap_version' => SOAP_1_2,
              'location'     => self::WSFEURL,
              'exceptions'   => 0,
              'trace'        => 1)
    );
  }

  /**
   * Chequea los errores en la operacion, si encuentra algun error falta lanza una exepcion
   * si encuentra un error no fatal, loguea lo que paso en $this->error
   */
  private function _checkErrors($results, $method)
  {
    if (self::LOG_XMLS) {
      file_put_contents("xmlgenerados/request-".$method.".xml",$this->client->__getLastRequest());
      file_put_contents("xmlgenerados/response-".$method.".xml",$this->client->__getLastResponse());
    }

    if (is_soap_fault($results)) {
      throw new \Exception('WSFE class. FaultString: ' . $results->faultcode.' '.$results->faultstring);
    }

    if ($method == 'FEDummy') {return;}

    $XXX=$method.'Result';
    if ($results->$XXX->RError->percode != 0) {
        $this->error = "Method=$method errcode=".$results->$XXX->RError->percode." errmsg=".$results->$XXX->RError->perrmsg;
    }

    return $results->$XXX->RError->percode != 0 ? true : false;
  }

  /**
   * Abre el archivo de TA xml,
   * si hay algun problema devuelve false
   */
  public function openTA()
  {
    $this->TA = simplexml_load_file($this->path.self::TA);

    return $this->TA == false ? false : true;
  }

  /**
   * Retorna la cantidad maxima de registros de detalle que
   * puede tener una invocacion al FEAutorizarRequest
   */
  public function recuperaQTY()
  {
    $results = $this->client->FERecuperaQTYRequest(
      array('argAuth'=>array('Token' => $this->TA->credentials->token,
                              'Sign' => $this->TA->credentials->sign,
                              'cuit' => self::CUIT)));

    $e = $this->_checkErrors($results, 'FERecuperaQTYRequest');

    return $e == false ? $results->FERecuperaQTYRequestResult->qty->value : false;
  }

  /*
   * Retorna el Ticket de Acceso.
   */
  public function getTA()
  {
	return $this->TA;
  }

  /*
   * Retorna el ultimo número de Request.
   */
  public function FECompUltimoAutorizado($tipo_cbte,$punto_vta, $cuit)
  {
	//Castea el cuit para ser aceptado en el Request (Pide LONG)
	$cuit = (float)$cuit;

    $results = $this->client->FECompUltimoAutorizado(
      array('Auth' =>  array('Token'    => $this->TA->credentials->token,
							'Sign'     => $this->TA->credentials->sign,
							'Cuit'     => $cuit),
             'PtoVta' => $punto_vta,
			 'CbteTipo' => $tipo_cbte));

    return $results;
  }

  /*
   * Retorna el ultimo comprobante autorizado para el tipo de comprobante /cuit / punto de venta ingresado.
   */
  public function recuperaLastCMP ($ptovta, $cuit)
  {
    $results = $this->client->FERecuperaLastCMPRequest(
      array('argAuth' =>  array('Token'    => $this->TA->credentials->token,
                                'Sign'     => $this->TA->credentials->sign,
                                'cuit'     => $cuit),
             'argTCMP' => array('PtoVta'   => $ptovta,
                                'TipoCbte' => $this->tipo_cbte)));

    $e = $this->_checkErrors($results, 'FERecuperaLastCMPRequest');

    return $e == false ? $results->FERecuperaLastCMPRequestResult->cbte_nro : false;
  }

  /**
   * Setea el tipo de comprobante
   * A = 1
   * B = 6
   */
  public function setTipoCbte($tipo)
  {
    switch($tipo) {
      case 'a': case 'A': case '1':
        $this->tipo_cbte = 1;
      break;

      case 'b': case 'B': case 'c': case 'C': case '6':
        $this->tipo_cbte = 6;
      break;

      default:
        return false;
    }
	return true;
   }

	public function armadoFacturaUnica($tipofactura, $puntoventa, $nc = '', $renglon, $cuit) {
		$cuit = $cuit;
        switch ($tipofactura) {
            case 'A':
				if($nc==''){
					$CbteTipo = 1;
				}else{
					if($nc=='SI'){
						$CbteTipo = 3;
					}else{
						$CbteTipo = 2;
					}
				}
                break;
            case 'B':
				if($nc==''){
					$CbteTipo = 6;
				}else{
					if($nc=='SI'){
						$CbteTipo = 8;
					}else{
						$CbteTipo = 7;
					}
				}
				break;
        }

        $FeCabReq = array('CantReg' => 1, 'PtoVta' => $puntoventa, 'CbteTipo' => $CbteTipo);
		$tipodoc = $renglon['tipodocumento'];
        if ($tipodoc == 96) {
            $nrodoc = (float)$renglon['numerodocumento'];
        } elseif ($tipodoc == 80) {
            $nrodoc = (float)$renglon['cuit'];
        } else {
            $tipodoc = 99;
            if ($renglon['numerodocumento'] != 0) {
                $nrodoc = (float)$renglon['numerodocumento'];
                $tipodoc = 96;
            } elseif ($tipofactura == 'B' and $renglon['importetotal'] < 1000) {
                $nrodoc = 0;
            } elseif ($tipofactura == 'B' and $renglon['importetotal'] > 1000 and $renglon['cuit'] != '') {
                $nrodoc = (float)str_replace('-', '', $renglon['cuit']);
                $tipodoc = 80;
            } else {
                $nrodoc = str_replace('-', '', $renglon['cuit']);
                if ($tipofactura == 'A')
                    $tipodoc = 80;
            }
        }

		$neto = $renglon['importeneto'];

        if ($renglon['importeneto'] != '0') {
            $baseimp = $renglon['importeneto'];
        }

        // si el iva es 0 no informo nada
        if ($renglon['importeiva'] > 0) {
            $detalleiva = array(
                'AlicIva' => array(
                    'Id' => 5,
                    'BaseImp' => $baseimp,
                    'Importe' => $renglon['importeiva']
                )
            );
            $FECAEDetRequest = array
                (
                'Concepto' => $renglon['concepto'],
                'DocTipo' => $tipodoc,
                'DocNro' => $nrodoc,
                'CbteDesde' => $renglon['nrofactura'],
                'CbteHasta' => $renglon['nrofactura'],
                'CbteFch' => $renglon['fechaemision'],
                'ImpTotal' => round($renglon['importetotal'], 2),
                'ImpTotConc' => round($renglon['capitalafinanciar'], 2),
                'ImpNeto' => round($neto, 2),
                'ImpOpEx' => 0.00,
                'ImpTrib' => 0.00,
                'ImpIVA' => $renglon['importeiva'],
                'FchServDesde' => $renglon['fechadesde'],
                'FchServHasta' => $renglon['fechahasta'],
                'FchVtoPago' => $renglon['fechahasta'],
                'MonId' => "PES",
                'MonCotiz' => "1.00",
                'Iva' => $detalleiva
            );
        }else{
            $FECAEDetRequest = array
                (
                'Concepto' => $renglon['concepto'],
                'DocTipo' => $tipodoc,
                'DocNro' => $nrodoc,
                'CbteDesde' => $renglon['nrofactura'],
                'CbteHasta' => $renglon['nrofactura'],
                'CbteFch' => $renglon['fechaemision'],
                'ImpTotal' => round($renglon['importetotal'], 2),
                'ImpTotConc' => round($renglon['capitalafinanciar'], 2),
                'ImpNeto' => round($neto, 2),
                'ImpOpEx' => 0.00,
                'ImpTrib' => 0.00,
                'ImpIVA' => $renglon['importeiva'],
                'FchServDesde' => $renglon['fechadesde'],
                'FchServHasta' => $renglon['fechahasta'],
                'FchVtoPago' => $renglon['fechahasta'],
                'MonId' => "PES",
                'MonCotiz' => "1.00",
            );
        }
        $fedetreq = array('FECAEDetRequest' => $FECAEDetRequest);
        $params = array
            (
            'FeCabReq' => $FeCabReq,
            'FeDetReq' => $fedetreq
			);
        return $params;
    }

    public function llamarmetodo($metodo, $params) {
		$cuit = (float)self::CUIT;

		switch ($metodo) {
            case 'FEDummy':
                $resu = $this->client->FEDummy();
                break;
            case 'FECAESolicitar':
                $resu = $this->client->FECAESolicitar($params);
                break;
            case 'FECompUltimoAutorizado':
                $resu = $this->client->FECompUltimoAutorizado($params);
                break;
            case 'FEParamGetPtosVenta':
				$resu = $this->client->FEParamGetPtosVenta(
				  array('Auth' =>  array('Token'   => $this->TA->credentials->token,
										'Sign'     => $this->TA->credentials->sign,
										'Cuit'     => $cuit)));
                break;
            case 'FEParamGetTiposMonedas':
                $resu = $this->client->FEParamGetTiposMonedas($params);
                break;
            case 'FEParamGetTiposCbte':
                $resu = $this->client->FEParamGetTiposCbte($params);
                break;
            case 'FEParamGetTiposDoc':
				$params->Auth->Token = $this->TA->credentials->token;
				$params->Auth->Sign = $this->TA->credentials->sign;
				$params->Auth->Cuit = self::CUIT;
                $resu = $this->client->FEParamGetTiposDoc($params);
                break;

            default: echo "falta definir metodo";
                break;
        }
        return $resu;
    }

  public function solicitarCAE($params, $cuit)
  {
	$cuit = (float)$cuit;
    $results = $this->client->FECAESolicitar(
	    array('Auth'    =>  array('Token'   => $this->TA->credentials->token,
							'Sign'     => $this->TA->credentials->sign,
							'Cuit'     => $cuit),
            'FeCAEReq' 	=> $params
            )
	);
    return $results;
  }

}

?>
