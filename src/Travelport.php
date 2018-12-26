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
    public function checkAirAvailability($routesArr)
    {
        $target_branch = $this->TARGETBRANCH;
		$credentials = $this->CREDENTIALS;
		$provider = $this->PROVIDER;
		
		$postdata = array();
        $postdata['routesArr'] 	 	= $routesArr;
		$postdata['target_branch'] 	= $target_branch;
		$postdata['credentials'] 	= $credentials;
		$postdata['provider'] 		= $provider;	
		
		$php_xml = '001-01_1P_AirAvailability_Rq.php';
		
		$result = $this->_apiCall('POST', $postdata, $php_xml);
		
        return $result;
    }
	
		
	/*
	 * Function to get price for selected air segments
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
    public function airPriceRequest($segment_data){
        $target_branch = $this->TARGETBRANCH;
		$credentials = $this->CREDENTIALS;
		$provider = $this->PROVIDER;
		
		$postdata = array();
		$postdata['target_branch'] 	= $target_branch;
		$postdata['credentials'] 	= $credentials;
		$postdata['provider'] 		= $provider;	
		$postdata['segment_data'] = $segment_data;
		$php_xml = '002-01_1P_AirPrice_Rq.php';
		
		$result = $this->_apiCall('POST', $postdata, $php_xml);
        return $result;
    }
	
	
	
	/*
	 * Function to get price for selected air segments
	 * Air Availability searches return available air segments only, and do not
	 * include fares or other pricing information. Because additional options are
	 * available beyond the segments returned in the initial response, a
	 * NextResultReference key is returned. This key can be used in a subsequent Air
	 * Availability request to return the additional segment options.
	 * 
	 * @Param string $origin, string $destination, string $deptime
	 *
	 * @return $this
	 */
    public function airBookingRequset($air_price_data){
        $target_branch = $this->TARGETBRANCH;
		$credentials = $this->CREDENTIALS;
		$provider = $this->PROVIDER;
		
		$postdata = array();
		$postdata['target_branch'] 	= $target_branch;
		$postdata['credentials'] 	= $credentials;
		$postdata['provider'] 		= $provider;	
		$postdata['air_price_data'] = $air_price_data;
		$php_xml = '003-01_1P_AirBook_Rq.php';
		
		$result = $this->_apiCall('POST', $postdata, $php_xml);
		
        return $result;
    }
	
	
	/*
	 * Function to get price for selected air segments
	 * Air Availability searches return available air segments only, and do not
	 * include fares or other pricing information. Because additional options are
	 * available beyond the segments returned in the initial response, a
	 * NextResultReference key is returned. This key can be used in a subsequent Air
	 * Availability request to return the additional segment options.
	 * 
	 * @Param string $origin, string $destination, string $deptime
	 *
	 * @return $this
	 */
    public function airTicketRequset($air_book_data){
        $target_branch = $this->TARGETBRANCH;
		$credentials = $this->CREDENTIALS;
		$provider = $this->PROVIDER;
		
		$postdata = array();
		$postdata['target_branch'] 	= $target_branch;
		$postdata['credentials'] 	= $credentials;
		$postdata['provider'] 		= $provider;	
		$postdata['air_book_data'] = $air_book_data;
		$php_xml = '004-01_1P_AirTicket_Rq.php';
		
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
		/*
		 * Variables that are required to be used in the lowfaresearch
		 * request XML. The XML would be included using the require_once function.
		 */
		$user 			= $this->USER;
		$target_branch 	= $var_arr['target_branch'];
		$trace_id 		= \Hash::make(uniqid($user));
		
		extract($var_arr);
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
		$response = array();

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
            $response = $this->curl_request($params);
        }else{
            $response = array();
        }
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
	
	
	/*
	 * Function to convert XML response to an array
	 * @Param string $xml (xml response)
	 *
	 * @return $response - it will return an array
	 */
	public function XML2ARR($xml){
		$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $xml);
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);
		$response = json_decode($json,true);
		
		if ( $this->multiKeyExists($response, "SOAPFault") ){
			$this->errorHandling($response);
		}
		return $response;
	}	

	
	/*
	 * Function is used for exception handling
	 * @Param string $response (xml response with fault)
	 *
	 */
	public function errorHandling($response){
		if( $response['SOAPBody']['SOAPFault']['faultcode'] == 'Server.ValidationException' ){
			throw new \RuntimeException($response['SOAPBody']['SOAPFault']['faultstring']);		
		}
		if( $response['SOAPBody']['SOAPFault']['faultcode'] == 'Server.Business' ){
			throw new \RuntimeException($response['SOAPBody']['SOAPFault']['faultstring']);		
		}
	}
	

	public function multiKeyExists($arr, $key) {

		// is in base array?
		if (array_key_exists($key, $arr)) {
			return true;
		}

		// check arrays contained in this array
		foreach ($arr as $element) {
			if (is_array($element)) {
				if ($this->multiKeyExists($element, $key)) {
					return true;
				}
			}

		}

		return false;
	}
	
	
	/*
	 * Function to get the flight stopover from response
	 * @Param string $stopover_array
	 *
	 * @return $response - return array according to stopoover 
	 */
	public function getFlightsStopover($stopover_array){
		$tmp = $stopover_array;
		$airFlightDetails = $tmp['SOAPBody']['airLowFareSearchRsp']['airFlightDetailsList']['airFlightDetails'];
		$airAirSegment = $tmp['SOAPBody']['airLowFareSearchRsp']['airAirSegmentList']['airAirSegment'];
		$airFareInfo = $tmp['SOAPBody']['airLowFareSearchRsp']['airFareInfoList']['airFareInfo'];
		$airAirPricingSolution = $tmp['SOAPBody']['airLowFareSearchRsp']['airAirPricingSolution'];

		//array as per stopovers
		$required_arr = array();

		$price_data_arr = array();
		
		$travel_time_arr = array();
		
		$segment_price_arr = array();
		
		$i = 0;
		foreach($airAirPricingSolution as $key => $val){
			$price_data_arr[$i]['price'] = 	$val['@attributes'];
			$price_data_arr[$i]['travelTime'] = $val['airJourney']['@attributes']['TravelTime'];

			$j = 0;
			foreach($val['airJourney']['airAirSegmentRef'] as $k => $v){

				if(!empty($val['airJourney']['airAirSegmentRef'][0])){ 
					//check if multidimension - if so, add the key(@attributes) in $v
					$price_data_arr[$i]['airAirSegmentRef'][$j]['key'] = $v['@attributes']['Key'];
					$price_data_arr[$i]['airAirSegmentRef'][$j]['price'] = $price_data_arr[$i]['price']['TotalPrice'];
					$price_data_arr[$i]['airAirSegmentRef'][$j]['travelTime'] = $this->lexical_to_human($price_data_arr[$i]['travelTime']);
				}else{
					$price_data_arr[$i]['airAirSegmentRef'][$j]['key'] = $v['Key'];
					$price_data_arr[$i]['airAirSegmentRef'][$j]['price'] = $price_data_arr[$i]['price']['TotalPrice'];
					$price_data_arr[$i]['airAirSegmentRef'][$j]['travelTime'] = $this->lexical_to_human($price_data_arr[$i]['travelTime']);
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
				
				$air_segment_arr = $airAirSegment_data_arr[$ve['key']];
				
				$ind_segment_price_arr = array(
											'segmentPrice' => $ve['price']
										);
									
									
				$time_duration_arr = array(
										'travelTime' => $ve['travelTime']
									);
				
				$required_arr[$x][] = array_merge($air_segment_arr, $time_duration_arr, $ind_segment_price_arr);
				
			}
			$x++;
		}
	
		//sort the array based on the number of stops - From nonstops, 1 stopover, 2 stopover...
		sort($required_arr);
	
		return $required_arr;
	}	
	
	
	
	/*
	 * Function to extract days, hours and minutes from the lexical representation
	 * provided by travelport API for journey duration
	 * @Param string $duration
	 *
	 * @return $output - human readable duration
	 */
	public function lexical_to_human($duration){

		$match = preg_match('/(-)?P([0-9]+Y)?([0-9]+M)?([0-9]+D)?T?([0-9]+H)?([0-9]+M)?([0-9]+S)?/', $duration, $regs);
		
		$output = false;
	
		if($match){
			//return just the days, hours and minute string
			$days = !empty(str_ireplace('D', '', $regs[4])) ? strtolower($regs[4]) : '';
			$hours = !empty($regs[5]) ? strtolower($regs[5]) : '0h';
			$mins = !empty($regs[6]) ? strtolower($regs[6]) : '0m';
			
			$output = !empty($days) ? $days.':' : '';
			$output .= $hours.':'.$mins;
		}
	
		return $output;
	
	}

	
	
	
	
	/*
	 * Function to covert a specific value of an array as an array.
	 * E.g.From array( 'specificKey' => 'value') to array('specificKey' => array('value'))
	 * Can work on multidimesional arrays
	 *
	 * Parameters: array $supplied_array, array $keys_arr
	 * Where $keys_arr are the keys whose value needs
	 * to be converted into an array (CASE SENSITIVE)
	 *
	 * With reference to the afoemetioned example: $keys_arr = array('specificKey');
	 *
	 * Return: desired array - by reference
	 * - B.Singh
	 */
	public function add_index( &$supplied_array, $keys_arr ){
		
		foreach( $supplied_array as $key => &$val ){
			
			if( in_array($key, $keys_arr, TRUE) && is_array($val) ){
				
				if(empty($val[0])){
					
					$val = array($val);
					
				}
				
			}elseif( !in_array($key, $keys_arr, TRUE) && is_array($val) ){
				
				$this->add_index($val, $keys_arr);
				
			}
		}
	}
   
}