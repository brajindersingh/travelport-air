<?php
$ait_reservation_arr 	= $air_book_data['SOAPBody']['universalAirCreateReservationRsp']['universalUniversalRecord']['airAirReservation'];
$ait_pricing_info 	= $ait_reservation_arr['airAirPricingInfo'];

$message='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Header />
    <soapenv:Body>
        <air:AirTicketingReq xmlns:air="http://www.travelport.com/schema/air_v29_0" AuthorizedBy="'.$user.'" TargetBranch="'.$target_branch.'" TraceId="'.$trace_id.'" BulkTicket="false" ReturnInfoOnFail="true">
            <com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v29_0" OriginApplication="UAPI" />
            <air:AirReservationLocatorCode>'.$ait_reservation_arr['@attributes']['LocatorCode'].'</air:AirReservationLocatorCode>
            <air:AirPricingInfoRef Key="'.$ait_pricing_info['@attributes']['Key'].'" />
        </air:AirTicketingReq>
    </soapenv:Body>
</soapenv:Envelope>';

