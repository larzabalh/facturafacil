<?php
namespace JOYAS\JoyasBundle\Afip;
use JOYAS\JoyasBundle\Afip\Exceptionhandler;
# Autor: Nicolas Corvalan Wechsler

class WSAA {
  const TA   = "/xmlgenerados/TA.xml";      # Archivo con el Token y Sign
  const PASSPHRASE = "";         		    # The passphrase (if any) to sign
  const PROXY_ENABLE = false;

# TESTING
  const WSDL = "/wsaa.wsdl";              # The WSDL corresponding to WSAA PROD
  const URL = "https://wsaahomo.afip.gov.ar/ws/services/LoginCms"; // testing
  const CERT = "//keys//cwcert.crt";          # The X.509 certificate in PEM format
  const PRIVATEKEY = "//keys//cwkey.key";   # The private key correspoding to CERT (PEM)
/*

# PRODUCCION
  const WSDL = "/wsaaprod.wsdl";                      # The WSDL corresponding to WSAA PROD
  const URL = "https://wsaa.afip.gov.ar/ws/services/LoginCms"; // produccion  
  const CERT = "//keys//carabajraul.crt";           # The X.509 certificate in PEM format
  const PRIVATEKEY = "//keys//carabajalraul.key";         # La clave privada
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
     
  /*
   * servicio del cual queremos obtener la autorizacion
   */
  private $service; 
  
  
  /*
   * Constructor
   */
  public function __construct($path = './', $service = 'wsfe') 
  {
    $this->path = dirname(__FILE__);
    $this->service = $service;
    
    // seteos en php
    ini_set("soap.wsdl_cache_enabled", "0");    
    
    // validar archivos necesarios
    if (!file_exists(dirname(__FILE__).self::CERT)) $this->error .= " Failed to open ".self::CERT;
    if (!file_exists(dirname(__FILE__).self::PRIVATEKEY)) $this->error .= " Failed to open ".self::PRIVATEKEY;
    if (!file_exists(dirname(__FILE__).self::WSDL)) $this->error .= " Failed to open ".self::WSDL;
    
    if(!empty($this->error)) {
      throw new \Exception('WSAA class. Faltan archivos necesarios para el funcionamiento'. $this->error);
    }
    
    $this->client = new \SoapClient(dirname(__FILE__).self::WSDL, array(
			'soap_version'   => SOAP_1_2,
			'location'       => self::URL,
			'trace'          => 1,
			'exceptions'     => 0
            )
    );
  }
  
  /**
   * Crea el archivo xml de TRA
   */
  private function create_TRA()
  {
    $TRA = new \SimpleXMLElement(
      '<?xml version="1.0" encoding="UTF-8"?>' .
      '<loginTicketRequest version="1.0">'.
      '</loginTicketRequest>');
    $TRA->addChild('header');
    $TRA->header->addChild('uniqueId', date('U'));
    $TRA->header->addChild('generationTime', date('c',date('U')-120));
    $TRA->header->addChild('expirationTime', date('c',date('U')+120));
    $TRA->addChild('service', $this->service);
    $TRA->asXML(dirname(__FILE__).'/xmlgenerados/TRA.xml');
  }
  
  /*
   * This functions makes the PKCS#7 signature using TRA as input file, CERT and
   * PRIVATEKEY to sign. Generates an intermediate file and finally trims the 
   * MIME heading leaving the final CMS required by WSAA.
   * 
   * devuelve el CMS
   */
  private function sign_TRA()
  {

	$STATUS = openssl_pkcs7_sign(dirname(__FILE__)."/xmlgenerados/TRA.xml", dirname(__FILE__)."/xmlgenerados/TRA.tmp", "file://".dirname(__FILE__).self::CERT,
      array('file://'.dirname(__FILE__).self::PRIVATEKEY, self::PASSPHRASE),
      array(),
      !PKCS7_DETACHED
    );
    
    if (!$STATUS)
      throw new \Exception("ERROR generating PKCS#7 signature");
      
    $inf = fopen(dirname(__FILE__)."/xmlgenerados/TRA.tmp", "r");
    $i = 0;
    $CMS = "";
    while (!feof($inf)) { 
        $buffer = fgets($inf);
        if ( $i++ >= 4 ) $CMS .= $buffer;
    }
    
    fclose($inf);
    
    return $CMS;
  }
  
  /**
   * Conecta con el web service y obtiene el token y sign
   */
  private function call_WSAA($cms)
  {     
    $results = $this->client->loginCms(array('in0' => $cms));

    if (is_soap_fault($results)) 
      throw new \Exception("SOAP Fault: ".$results->faultcode.': '.$results->faultstring);

	$ta_xml = simplexml_load_string($results->loginCmsReturn);	
	$TOKEN = $ta_xml->credentials->token;
	$SIGN = $ta_xml->credentials->sign;	

    // para logueo
    file_put_contents(dirname(__FILE__)."/request-loginCms.xml", $this->client->__getLastRequest());
    file_put_contents(dirname(__FILE__)."/response-loginCms.xml", $this->client->__getLastResponse());
        
    return $results->loginCmsReturn;
  }
  
  /*
   * Convertir un XML a Array
   */
  private function xml2array($xml) {    
    $json = json_encode( simplexml_load_string($xml));
    return json_decode($json, TRUE);
  }    
  
  /**
   * funcion principal que llama a las demas para generar el archivo TA.xml
   * que contiene el token y sign
   */
  public function generar_TA()
  {
    $this->create_TRA();
    $TA = $this->call_WSAA( $this->sign_TRA() );

    if (!file_put_contents(dirname(__FILE__).self::TA, $TA))
      throw new \Exception("Error al generar al archivo TA.xml");
    
    $this->TA = $this->xml2Array($TA);
      
    return true;
  }
  
  /**
   * Obtener la fecha de expiracion del TA
   * si no existe el archivo, devuelve false
   */
  public function get_expiration() 
  {    
    if(empty($this->TA)) {             
      $TA_file = file(dirname(__FILE__).self::TA, FILE_IGNORE_NEW_LINES);
      
      if($TA_file) {
        $TA_xml = '';
        for($i=0; $i < sizeof($TA_file); $i++)
          $TA_xml.= $TA_file[$i];        
        $this->TA = $this->xml2Array($TA_xml);
        $r = $this->TA['header']['expirationTime'];
      } else {
        $r = false;
      }      
    } else {
      $r = $this->TA['header']['expirationTime'];
    }
     
    return $r;
  }
   
}

?>
