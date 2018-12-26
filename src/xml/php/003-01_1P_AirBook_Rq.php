<?php
$air_res 			= $air_price_data['SOAPBody']['airAirPriceRsp'];

$air_segment 		= $air_res['airAirItinerary']['airAirSegment'];

$air_pricing_sol 	= $air_res['airAirPriceResult']['airAirPricingSolution']['@attributes'];

$air_pricing_info 	= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['@attributes'];

$air_fare_info 		= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airFareInfo'];
$air_booking_info 	= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airBookingInfo'];
$air_fare_calc 		= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airFareCalc'];
$air_passenger_type = $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airPassengerType'];

$air_baggage_info 	= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airBaggageAllowances']['airBaggageAllowanceInfo'];

$air_carry_info 	= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airBaggageAllowances']['airCarryOnAllowanceInfo'];

$air_tax_info 	= $air_res['airAirPriceResult']['airAirPricingSolution']['airAirPricingInfo']['airTaxInfo'];




$message='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Header />
    <soapenv:Body>
        <univ:AirCreateReservationReq xmlns:univ="http://www.travelport.com/schema/universal_v29_0" AuthorizedBy="'.$user.'" RetainReservation="Both" TargetBranch="'.$target_branch.'" TraceId="'.$trace_id.'">
            <com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v29_0" OriginApplication="UAPI" />
            <com:BookingTraveler xmlns:com="http://www.travelport.com/schema/common_v29_0" DOB="1985-01-05" Gender="M" Key="gr8AVWMCT064r57Jt0+8bA==" TravelerType="ADT">
                <com:BookingTravelerName First="Stephen" Last="Jones" Prefix="Mr" />
                <com:DeliveryInfo>
                    <com:ShippingAddress>
                        <com:AddressName>Home</com:AddressName>
                        <com:Street>123 Dalton Drive</com:Street>
                        <com:City>Calgary</com:City>
                        <com:State>AB</com:State>
                        <com:PostalCode>T2P1K6</com:PostalCode>
                        <com:Country>CA</com:Country>
                    </com:ShippingAddress>
                </com:DeliveryInfo>
                <com:PhoneNumber AreaCode="403" CountryCode="1" Location="YYC" Number="555-1212" />
                <com:Email EmailID="test@travelport.com" Type="Home" />';
				
				foreach($air_booking_info as $abik1 => $abiv1){
					if( !empty($air_booking_info[0]) ){
						foreach($abiv1 as $abik2 => $abiv2){
							if($abik2 == '@attributes'){
								$message .= '<com:SSR Carrier="DL" FreeText="P/IN/F1234567/IN/05Jan85/M/13Dec14/Jones/Stephen" SegmentRef="'.$abiv2['SegmentRef'].'" Status="HK" Type="DOCS" />';
							}
						}
					}else{
						if($abik1 == '@attributes'){
							$message .= '<com:SSR Carrier="DL" FreeText="P/IN/F1234567/IN/05Jan85/M/13Dec14/Jones/Stephen" SegmentRef="'.$abik1['SegmentRef'].'" Status="HK" Type="DOCS" />';
						}
					}
				}
				
               $message .= '<com:Address>
                    <com:AddressName>Home</com:AddressName>
                    <com:Street>123 Dalton Drive</com:Street>
                    <com:City>Calgary</com:City>
                    <com:State>AB</com:State>
                    <com:PostalCode>T2P1K6</com:PostalCode>
                    <com:Country>CA</com:Country>
                </com:Address>
            </com:BookingTraveler>
            <com:AgencyContactInfo xmlns:com="http://www.travelport.com/schema/common_v29_0">
                <com:PhoneNumber Number="0506998223" AreaCode="07" Text="Elnatan" Type="Agency" CountryCode="050" />
            </com:AgencyContactInfo>
			
			
            <air:AirPricingSolution xmlns:air="http://www.travelport.com/schema/air_v29_0" Key="'.$air_pricing_sol['Key'].'" TotalPrice="'.$air_pricing_sol['TotalPrice'].'" BasePrice="'.$air_pricing_sol['BasePrice'].'" ApproximateTotalPrice="'.$air_pricing_sol['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$air_pricing_sol['ApproximateBasePrice'].'" EquivalentBasePrice="'.$air_pricing_sol['EquivalentBasePrice'].'" Taxes="'.$air_pricing_sol['Taxes'].'" ApproximateTaxes="'.$air_pricing_sol['ApproximateTaxes'].'">';

		
				foreach($air_segment as $ask1 => $asv1){
					if( !empty($air_segment[0]) ){
						foreach($asv1 as $ask2 => $asv2){
							if($ask2 == '@attributes'){
								$message .='<air:AirSegment Key="'.$asv2['Key'].'" Group="'.$asv2['Group'].'" Carrier="'.$asv2['Carrier'].'" FlightNumber="'.$asv2['FlightNumber'].'" ProviderCode="'.$asv2['ProviderCode'].'" Origin="'.$asv2['Origin'].'" Destination="'.$asv2['Destination'].'" DepartureTime="'.$asv2['DepartureTime'].'" ArrivalTime="'.$asv2['ArrivalTime'].'" ChangeOfPlane="'.$asv2['ChangeOfPlane'].'" OptionalServicesIndicator="'.$asv2['OptionalServicesIndicator'].'" ParticipantLevel="'.$asv2['ParticipantLevel'].'" />';
							}
						}
					}else{
						if($ask1 == '@attributes'){
							$message .='<air:AirSegment Key="'.$asv1['Key'].'" Group="'.$asv1['Group'].'" Carrier="'.$asv1['Carrier'].'" FlightNumber="'.$asv1['FlightNumber'].'" ProviderCode="'.$asv1['ProviderCode'].'" Origin="'.$asv1['Origin'].'" Destination="'.$asv1['Destination'].'" DepartureTime="'.$asv1['DepartureTime'].'" ArrivalTime="'.$asv1['ArrivalTime'].'" ChangeOfPlane="'.$asv1['ChangeOfPlane'].'" OptionalServicesIndicator="'.$asv1['OptionalServicesIndicator'].'" ParticipantLevel="'.$asv1['ParticipantLevel'].'" />';
						}
					}
				}
				
	
               $message .='<air:AirPricingInfo Key="'.$air_pricing_info['Key'].'" TotalPrice="'.$air_pricing_info['TotalPrice'].'" BasePrice="'.$air_pricing_info['BasePrice'].'" ApproximateTotalPrice="'.$air_pricing_info['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$air_pricing_info['ApproximateBasePrice'].'" ApproximateTaxes="'.$air_pricing_info['ApproximateTaxes'].'" Taxes="'.$air_pricing_info['Taxes'].'" LatestTicketingTime="'.$air_pricing_info['LatestTicketingTime'].'" PricingMethod="'.$air_pricing_info['PricingMethod'].'" PlatingCarrier="'.$air_pricing_info['PlatingCarrier'].'" ProviderCode="'.$air_pricing_info['ProviderCode'].'">';
			   
			   
			   
                   foreach($air_fare_info as $afik1 => $afiv1){
						if( !empty($air_fare_info[0]) ){
							foreach($afiv1 as $afik2 => $afiv2){
								if($afik2 == '@attributes'){
									$message .=' <air:FareInfo Key="'.$afiv2['Key'].'" FareBasis="'.$afiv2['FareBasis'].'" PassengerTypeCode="'.$afiv2['PassengerTypeCode'].'" Origin="'.$afiv2['Origin'].'" Destination="'.$afiv2['Destination'].'" EffectiveDate="'.$afiv2['EffectiveDate'].'" Amount="'.$afiv2['Amount'].'"><air:FareRuleKey FareInfoRef="'.$afiv2['Key'].'" ProviderCode="1P">'.$afiv1['airFareRuleKey'].'</air:FareRuleKey></air:FareInfo>';
								}
							}
						}else{
							if($afiv1 == '@attributes'){
								$message .=' <air:FareInfo Key="'.$afiv1['@attributes']['Key'].'" FareBasis="'.$afiv1['@attributes']['FareBasis'].'" PassengerTypeCode="'.$afiv1['@attributes']['PassengerTypeCode'].'" Origin="'.$afiv1['@attributes']['Origin'].'" Destination="'.$afiv1['@attributes']['Destination'].'" EffectiveDate="'.$afiv1['@attributes']['EffectiveDate'].'" Amount="'.$afiv1['@attributes']['Amount'].'"><air:FareRuleKey FareInfoRef="'.$afiv1['@attributes']['Key'].'" ProviderCode="1P">'.$afiv1['airFareRuleKey'].'</air:FareRuleKey>
								</air:FareInfo>';
							}
						}
					}
						
					foreach($air_booking_info as $abik1 => $abiv1){
						if( !empty($air_booking_info[0]) ){
							foreach($abiv1 as $abik2 => $abiv2){
								if($abik2 == '@attributes'){
									$message .='<air:BookingInfo BookingCode="'.$abiv2['BookingCode'].'" CabinClass="'.$abiv2['CabinClass'].'" FareInfoRef="'.$abiv2['FareInfoRef'].'" SegmentRef="'.$abiv2['SegmentRef'].'" />';
								}
							}
						}else{
							if($abik1 == '@attributes'){
								$message .='<air:BookingInfo BookingCode="'.$abiv1['BookingCode'].'" CabinClass="'.$abiv1['CabinClass'].'" FareInfoRef="'.$abiv1['FareInfoRef'].'" SegmentRef="'.$abiv1['SegmentRef'].'" />';
							}
						}
					}
				
				
					foreach($air_tax_info as $ati => $ativ){
						$message .= '<air:TaxInfo Category="'.$ativ['@attributes']['Category'].'" Amount="'.$ativ['@attributes']['Amount'].'" Key="'.$ativ['@attributes']['Key'].'" />';
					}
					
                    $message .='<air:FareCalc>'.$air_fare_calc.'</air:FareCalc>
					
                    <air:PassengerType Code="'.$air_passenger_type['@attributes']['Code'].'" />
					
                    <air:BaggageAllowances> 
                        <air:BaggageAllowanceInfo TravelerType="'.$air_baggage_info['@attributes']['TravelerType'].'" Origin="'.$air_baggage_info['@attributes']['Origin'].'" Destination="'.$air_baggage_info['@attributes']['Destination'].'" Carrier="'.$air_baggage_info['@attributes']['Carrier'].'">
                            <air:URLInfo>
                                <air:URL>'.$air_baggage_info['airURLInfo']['airURL'].'</air:URL>
                            </air:URLInfo>';
							
                            $message .='<air:TextInfo>';
							foreach($air_baggage_info['airTextInfo']['airText'] as $airtext){
                                $message .='<air:Text>'.$airtext.'</air:Text>';
							}
                            $message .='</air:TextInfo>';
							
							foreach($air_baggage_info['airBagDetails'] as $bagdetails){
								$message .='<air:BagDetails ApplicableBags="'.$bagdetails['@attributes']['ApplicableBags'].'" BasePrice="'.$bagdetails['@attributes']['BasePrice'].'" ApproximateBasePrice="'.$bagdetails['@attributes']['ApproximateBasePrice'].'" 	TotalPrice="'.$bagdetails['@attributes']['TotalPrice'].'" ApproximateTotalPrice="'.$bagdetails['@attributes']['ApproximateTotalPrice'].'">
                                <air:BaggageRestriction>
                                    <air:TextInfo>
                                        <air:Text>'.$bagdetails['airBaggageRestriction']['airTextInfo']['airText'].'</air:Text>
                                    </air:TextInfo>
                                </air:BaggageRestriction>
								</air:BagDetails>';
							}
							
                         $message .='</air:BaggageAllowanceInfo>
						
						<air:CarryOnAllowanceInfo Origin="'.$air_carry_info['@attributes']['Origin'].'" Destination="'.$air_carry_info['@attributes']['Destination'].'" Carrier="'.$air_carry_info['@attributes']['Carrier'].'">
                            <air:URLInfo />';
							foreach($air_carry_info['airTextInfo'] as $air_carry_textinfo){
								$message .=' <air:TextInfo>
									<air:Text>'.$air_carry_textinfo['airText'].'</air:Text>
								</air:TextInfo>';
							}
							
                            $message .='<air:CarryOnDetails ApplicableCarryOnBags="'.$air_carry_info['airCarryOnDetails']['@attributes']['ApplicableCarryOnBags'].'" BasePrice="'.$air_carry_info['airCarryOnDetails']['@attributes']['BasePrice'].'" ApproximateBasePrice="'.$air_carry_info['airCarryOnDetails']['@attributes']['ApproximateBasePrice'].'" TotalPrice="'.$air_carry_info['airCarryOnDetails']['@attributes']['TotalPrice'].'" ApproximateTotalPrice="'.$air_carry_info['airCarryOnDetails']['@attributes']['ApproximateTotalPrice'].'" />
							
                        </air:CarryOnAllowanceInfo>';
						
                    $message .='</air:BaggageAllowances>
                </air:AirPricingInfo>
            </air:AirPricingSolution>';
			
			$current_date = date('Y-m-d\TH:i:s', strtotime("now +60 minutes") );
            $message .='<com:ActionStatus xmlns:com="http://www.travelport.com/schema/common_v29_0" ProviderCode="1P" TicketDate="2018-12-20T10:35:52" Type="TAW" />';
			
        $message .='</univ:AirCreateReservationReq>
    </soapenv:Body>
</soapenv:Envelope>';


echo $message;die;