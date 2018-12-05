<?php

namespace Thedevlogs\Travelport;

use \Exception;

class Travelport
{
    const BASE_URI = 'https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService';

	//API Credentials
    public $TARGETBRANCH;
    public $CREDENTIALS;
    public $PROVIDER;
    public $DEBUG;
    public $USER;
    public $ORIG_CONFIG_ARR;

    public function __construct($config)
    {
		
		foreach($config as $key => $value){
            $this->{$key} = $value;
        }
		
		$this->ORIG_CONFIG_ARR = $config;
	
    }

	/*
	 * Function to be used in case one would like to
	 * set/change the API Credentials before making a call
	 * that is on the fly
	 *
	 * To use the original config credentials, it would be best to
	 * just call the $this->resetCredentials function
	 *
	 * @Param string $target_branch, string $credentials, string $provider
	 *
	 * @return $this
	 */
    public function setCredentials($target_branch, $credentials, $provider)
	{
		
        $this->TARGETBRANCH = $target_branch;
        $this->CREDENTIALS = $credentials;
        $this->PROVIDER = $provider;
        
		return $this;
    }

	/*
	 * Function to be used in case one would like to
	 * set/change the 'USER' in the API Credentials before making a call
	 * that is on the fly
	 *
	 * To use the original 'USER' from the config credentials, it would be best to
	 * just call the $this->resetUser function
	 *
	 * @Param string $user
	 *
	 * @return $this
	 */
    public function setUser($user)
	{
		
        $this->USER = $user;
		
		return $this;
    }
	
	
	/*
	 * Function to reset the API config from the
	 * config file in /config/travelport.php
	 *
	 * @return $this
	 */
    public function resetCredentials()
    {
        $orig_config = $this->ORIG_CONFIG_ARR;
		$this->TARGETBRANCH = $orig_config['TARGETBRANCH'];
        $this->CREDENTIALS = $orig_config['CREDENTIALS'];
        $this->PROVIDER = $orig_config['PROVIDER'];
        
		return $this;
    }
	
	/*
	 * Function to reset the API 'User' config from the
	 * config file in /config/travelport.php
	 *
	 * @return $this
	 */
    public function resetUser()
    {
        $orig_config = $this->ORIG_CONFIG_ARR;
		$this->USER = $orig_config['USER'];
        
		return $this;
    }
	
	
	/*
	 * Function to Search for available air segments
	 * Air Availability searches return available air segments only, and do not
	 * including fares or other pricing information. Because additional options are
	 * available beyond the segments returned in the initial response, a
	 * NextResultReference key is returned. This key can be used in a subsequent Air
	 * Availability request to return the additional segment options.
	 * 
	 * @Param string $origin, string $destination, string $deptime
	 *
	 * @return $this
	 */
    public function checkAirAvailability($origin, $destination, $dep_time)
    {
        $target_branch = $this->TARGETBRANCH;
		$credentials = $this->CREDENTIALS;
		$provider = $this->PROVIDER;
		
		$postdata = array();
        $postdata['origin'] 	 	= $origin;
        $postdata['destination'] 	= $destination;
        $postdata['dep_time'] 	 	= $dep_time;
		$postdata['target_branch'] 	= $target_branch;
		$postdata['credentials'] 	= $credentials;
		$postdata['provider'] 		= $provider;	
		
		$php_xml = '001-01_1P_AirAvailability_Rq.php';
		
		$result = $this->_apiCall('POST', $postdata, $php_xml);
		
        return $result;
    }

	/*
	 * Function to prepare the XML for curl request
	 * @Param string $path (of the variable XML string in PHP file), array $var_arr (all the values required within the XML string)
	 *
	 * @return $message - To be used in curl request
	 */
	protected function parseXMLInput($path, $var_arr){//parse the Search response to get values to use in detail request
	
	
		/* $var_arr = array(
							'target_branch' => $target_branch,
							'credentials'	=> $credentials,
							'provider' => $provider,
							'origin' => $postdata['origin'],
							'destination' => $postdata['destination'],
							'dep_time' => $postdata['deptime'],
							); */
	
	
		/*
		 * Variables that are required to be used in the lowfaresearch
		 * request XML. The XML would be included using the require_once function.
		 */
		$user 			= $this->USER;
		$target_branch 	= $var_arr['target_branch'];
		$trace_id 		= \Hash::make(uniqid($user));
		$origin 		= $var_arr['origin'];
		$destination 	= $var_arr['destination'];
		$dep_time 		= $var_arr['dep_time'];
		$provider 		= $var_arr['provider'];
		
		require_once($path);
		
		//$message defined in the 'required' file
		return $message;
		
	}
	
	/*
	 * Function to send curl request
	 * @Param string $method (POST | GET), array $postdata (all the values required within the XML string)
	 *
	 * @return $message - To be used in curl request
	 */
    private function _apiCall($method, $postdata = [], $xml, $extraData = []){

        $params = array();

        // POST REQUEST
        if(!empty($postdata))
        {
		
			$path = __DIR__ . DIRECTORY_SEPARATOR .'xml'. DIRECTORY_SEPARATOR .'php'. DIRECTORY_SEPARATOR .$xml;
			
			$var_arr = $postdata;
			
			$message = $this->parseXMLInput($path, $var_arr);
		
            $params['message'] = $message;
			
			$auth = base64_encode($var_arr['credentials']);
			
            $params['headers'] = [
                "Content-Type: text/xml;charset=UTF-8", 
				"Accept: gzip,deflate", 
				"Cache-Control: no-cache", 
				"Pragma: no-cache", 
				"SOAPAction: \"\"",
				"Authorization: Basic $auth", 
				"Content-length: ".strlen($message),
            ];

            $params['debug'] = $this->DEBUG;

            $response_xml = $this->curl_request($params);

			$response = $this->parseXMLOutput($response_xml);
			
			echo '<pre>';
			print_r($response);
			die(' 217');
			
        }else{
            //GET REQUEST
            
        }


    }

	
	/*
	 * Function to parse the XML output response provided by the travelport API
	 * @Param string $xml_response
	 *
	 * @return array $response
	 */
	protected function parseXMLOutput($xml_response){//parse the Search response to get values to use in detail request
		
		$response = array();
		
		$AirAvailabilitySearchRsp = $xml_response;
		
		$xml = simplexml_load_String($AirAvailabilitySearchRsp, null, null, 'SOAP', true);
		
		if(!$xml){
			throw new \Exception("Invalid XML response");
		}
		
		
		$Results = $xml->children('SOAP',true);
		
		foreach($Results->children('SOAP',true) as $fault){
		
			if(strcmp($fault->getName(),'Fault') == 0){
				throw new \Exception("Error occurred in request/response processing!");
			}
		}
		
		$count = 0;
		foreach($Results->children('air',true) as $nodes){
			foreach($nodes->children('air',true) as $hsr){
				if(strcmp($hsr->getName(),'AirSegmentList') == 0){
					foreach($hsr->children('air',true) as $hp){
						if(strcmp($hp->getName(),'AirSegment') == 0){
							$count = $count + 1;
							// file_put_contents($fileName,"\r\n"."Air Segment ".$count."\r\n"."\r\n", FILE_APPEND);
							foreach($hp->attributes() as $a => $b){
									
									$val = (array)$b;
								
									$response[$count][$a] = $val[0];
									//echo "$a"." : "."$b";
									// file_put_contents($fileName,$a." : ".$b."\r\n", FILE_APPEND);
							}												
						}					
					}
				}
				//break;
			}
		}
		
		
		
		
		//$message defined in the 'required' file
		return $response;
		
	}
	
	
	
	
	
	/*
	 * Function to execute CURL
	 *
	 * @param array, $params['header'], $params['message'], $params['debug']
	 *
	 * return CURL response
	 */
    private function curl_request($params)
    {
		$soap_do = curl_init (SELF::BASE_URI);
		$headers = $params['headers'];
		$message = $params['message'];
		$debug = $params['debug'];
		
		// echo $message;
		// die();
		
		
		//curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30); 
		//curl_setopt($soap_do, CURLOPT_TIMEOUT, 30); 
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST, true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true); // this will prevent the curl_exec to return result and will let us to capture output
		
		if(!empty($debug)){
			$log_path = storage_path('logs'. DIRECTORY_SEPARATOR .'travelport.log');
			
			$fp = fopen($log_path, 'a');
			
			curl_setopt($soap_do, CURLOPT_VERBOSE, 1);
			curl_setopt($soap_do, CURLOPT_STDERR, $fp);	
		}	
				
		$response = curl_exec($soap_do);
		
		if(!empty($debug)){
			$response_log = curl_getinfo($soap_do);
			
			if(is_array($response_log)){
				$response_log = json_encode($response_log);
			}	
			
			$response_log .= "\n\r";
			$response_log .= "\n\r";
			$response_log .= $response;
			
			$log_path = storage_path('logs'. DIRECTORY_SEPARATOR .'travelport.log');
			$fp = fopen($log_path, 'a');
			fwrite($fp,$response_log);
			fclose($fp);		
			
		}
		
		return $response;

    }
	
	
	/***This function is used for convert XML response to an array*****/
	public function XML2ARR($xml){
		$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $xml);
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);
		$responseArray = json_decode($json,true);
		return $responseArray;	
	}	


	/***This function is used to get the flight stopover from the response*****/
	public function getFlightsStopover($soaparr){
		$tmp = $soaparr;
		$airFlightDetails = $tmp['SOAPBody']['airLowFareSearchRsp']['airFlightDetailsList']['airFlightDetails'];
		$airAirSegment = $tmp['SOAPBody']['airLowFareSearchRsp']['airAirSegmentList']['airAirSegment'];
		$airFareInfo = $tmp['SOAPBody']['airLowFareSearchRsp']['airFareInfoList']['airFareInfo'];
		$airAirPricingSolution = $tmp['SOAPBody']['airLowFareSearchRsp']['airAirPricingSolution'];

		//array as per stopovers
		$required_arr = array();

		$price_data_arr = array();
		
		$i = 0;
		foreach($airAirPricingSolution as $key => $val){
			$price_data_arr[$i]['price'] = 	$val['@attributes'];
			$price_data_arr[$i]['travelTime'] = $val['airJourney']['@attributes']['TravelTime'];

			$j = 0;
			foreach($val['airJourney']['airAirSegmentRef'] as $k => $v){

				if(!empty($val['airJourney']['airAirSegmentRef'][0])){ 
					//check if multidimesion - if so, add the key(@attributes) in $v
					$price_data_arr[$i]['airAirSegmentRef'][$j] = $v['@attributes']['Key'];
				}else{
					$price_data_arr[$i]['airAirSegmentRef'][$j] = $v['Key'];
				}	
				$j++;
			}
			
			$i++;
		}	
		
		$airAirSegment_data_arr = array();
		
		foreach($airAirSegment as $key => $val){
			$airAirSegment_data_arr[$val['@attributes']['Key']]	= $val['@attributes'];
		}	
		
		$x = 0;
		foreach($price_data_arr as $key => $val){
			foreach($val['airAirSegmentRef'] as $ke => $ve){
				$required_arr[$x][] = $airAirSegment_data_arr[$ve];
			}
			$x++;
		}	
		
		return $required_arr;
	}	
	
	

   
}