<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;
use SoapClient;
use JavaScript;

class SoapController
{
  /**
   * @var SoapWrapper
   */
  protected $soapWrapper;

  /**
   * SoapController constructor.
   *
   * @param SoapWrapper $soapWrapper
   */
  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
  }

  /**
   * Use the SoapWrapper
   */
  public function show() 
  {
      
    //array con las coordenadas de cada ciudad
    $tiendascoordenadas = ['Madrid' => ['lat' => 40.547500610352, 'lng' => -3.6419999599457],
        'Lisboa' => ['lat' => 37.090198516846, 'lng' => -8.2508001327515],
        'Asturias' => ['lat' => 43.535701751709, 'lng' => -5.6614999771118]
    ];
    //array con las ips correspondientes a las ciudades
    $ips = ["82.159.37.190", "82.154.37.190", "188.171.37.190"];

    //recogemos una ip aleatoriamente
    $ip = $ips[rand(0, 2)];
     
      
    //declaramos en un array los parametros para la funcion GetLocationRawOutput
    $params = array('sIPAddress' => $ip);
    //preparamos el servicio
    $this->soapWrapper->add('Location', function ($service) {
      $service
        ->wsdl('http://www.ipswitch.com/netapps/geolocation/iplocate.asmx?wsdl')
        ->trace(true);
    });
    //hacemos la peticion y recogemos la respuesta
    $response = $this->soapWrapper->call('Location.GetLocationRawOutput', array($params));
    
    
    //recogemos la localizacion de la ip enviada
    $region = $response->GetLocationRawOutputResult->geolocation_data->region_name;
    $coordenadas_region = $tiendascoordenadas[$region];

    
    //retornamos la vista mapa junto con las coordenadas de localizacion para que las muestre en un mapa
    return view('mapa', compact('coordenadas_region'));
    
    exit;
  }
}