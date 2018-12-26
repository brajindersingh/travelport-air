<?php

$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">   
			<soapenv:Header/>   
			<soapenv:Body>      
				<air:AirPriceReq xmlns:air="http://www.travelport.com/schema/air_v29_0" AuthorizedBy="'.$user.'" TargetBranch="'.$target_branch.'" TraceId="'.$trace_id.'">         
					<com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v29_0" OriginApplication="UAPI"/>         <air:AirItinerary>';
						foreach($segment_data as $segment){
							$message .= '<air:AirSegment ArrivalTime="'.$segment['ArrivalTime'].'" AvailabilitySource="'.$segment['AvailabilitySource'].'" Carrier="'.$segment['Carrier'].'" ChangeOfPlane="'.$segment['ChangeOfPlane'].'" DepartureTime="'.$segment['DepartureTime'].'" Destination="'.$segment['Destination'].'" Distance="'.$segment['Distance'].'" ETicketability="'.$segment['ETicketability'].'" Equipment="'.$segment['Equipment'].'" FlightNumber="'.$segment['FlightNumber'].'" FlightTime="'.$segment['FlightTime'].'" Group="'.$segment['Group'].'" Key="'.$segment['Key'].'" OptionalServicesIndicator="'.$segment['OptionalServicesIndicator'].'" Origin="'.$segment['Origin'].'" ParticipantLevel="'.$segment['ParticipantLevel'].'" ProviderCode="'.$provider.'"/>';
						}
				$message .= '</air:AirItinerary> ';
					foreach($segment_data as $segment){
						if(!empty($segment['traveler_data'])){
							foreach($segment['traveler_data'] as $traveler){
								$message .= '<com:SearchPassenger xmlns:com="http://www.travelport.com/schema/common_v29_0" BookingTravelerRef="'.uniqid().'" Code="ADT"/>'; 
							}
						}						
					}
				$message .= '<air:AirPricingCommand/>      
				</air:AirPriceReq>   
			</soapenv:Body>
			</soapenv:Envelope>';

			
			//pr($message);die;