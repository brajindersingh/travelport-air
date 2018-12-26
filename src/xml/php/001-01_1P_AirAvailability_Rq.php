<?php
/*
SNN65 - restricted senior age (65 and older)
DP30 - 30 percent discount off of the base fare.
ADT: adult
CHD: child
INF: infant without a seat
INS: infant with a seat
UNN: unaccompanied child
*/

$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
				<soapenv:Header/>
				<soapenv:Body>
					<air:LowFareSearchReq xmlns:air="http://www.travelport.com/schema/air_v29_0" AuthorizedBy="'.$user.'" SolutionResult="true" TargetBranch="'.$target_branch.'" TraceId="'.$trace_id.'">
					<com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v29_0" OriginApplication="UAPI"/>';			
					foreach($routesArr as $val){
					
						$message .=	'<air:SearchAirLeg>
										<air:SearchOrigin>
											<com:Airport xmlns:com="http://www.travelport.com/schema/common_v29_0" Code="'.$val["origin"].'"/>
										</air:SearchOrigin>
										<air:SearchDestination>
											<com:Airport xmlns:com="http://www.travelport.com/schema/common_v29_0" Code="'.$val["destination"].'"/>
										</air:SearchDestination>
										<air:SearchDepTime PreferredTime="'.$val["deptime"].'"/>
									</air:SearchAirLeg>';
					
					}
					
			$message .=	'<air:AirSearchModifiers>
						<air:PreferredProviders>
							<com:Provider xmlns:com="http://www.travelport.com/schema/common_v29_0" Code="'.$provider.'"/>
						</air:PreferredProviders>
					</air:AirSearchModifiers>';
				foreach($routesArr as $val){
					if(!empty($val['traveler_data'])){
						foreach($val['traveler_data'] as $traveler){
							$message .=	'<com:SearchPassenger xmlns:com="http://www.travelport.com/schema/common_v29_0" BookingTravelerRef="'.uniqid().'" Code="ADT"/>';
						}
					}else{
						$message .=	'<com:SearchPassenger xmlns:com="http://www.travelport.com/schema/common_v29_0" BookingTravelerRef="'.uniqid().'" Code="ADT"/>';
					}
				}
			$message .=
				'</air:LowFareSearchReq>
			</soapenv:Body>
		</soapenv:Envelope>';

		