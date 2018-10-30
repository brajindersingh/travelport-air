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
					<com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v29_0" OriginApplication="UAPI"/>
						<air:SearchAirLeg>
							<air:SearchOrigin>
								<com:Airport xmlns:com="http://www.travelport.com/schema/common_v29_0" Code="'.$origin.'"/>
							</air:SearchOrigin>
							<air:SearchDestination>
								<com:Airport xmlns:com="http://www.travelport.com/schema/common_v29_0" Code="'.$destination.'"/>
							</air:SearchDestination>
							<air:SearchDepTime PreferredTime="'.$dep_time.'"/>
						</air:SearchAirLeg>
						<air:AirSearchModifiers>
							<air:PreferredProviders>
								<com:Provider xmlns:com="http://www.travelport.com/schema/common_v29_0" Code="'.$provider.'"/>
							</air:PreferredProviders>
						</air:AirSearchModifiers>
						<com:SearchPassenger xmlns:com="http://www.travelport.com/schema/common_v29_0" BookingTravelerRef="gr8AVWGCR064r57Jt0+8bA==" Code="ADT"/>
					</air:LowFareSearchReq>
				</soapenv:Body>
			</soapenv:Envelope>';
