<?php
	/*
		notes:
		quick and dirty -- clean ltr? 
		-justin
	*/

	/*
		get weather data (brrr)
	*/

	// yahoo 
    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="brooklyn, ny")';
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

    // curl data
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    $phpObj =  json_decode($json);
    $condition = $phpObj->query->results->channel->item->condition->text;
    $wind = $phpObj->query->results->channel->wind->speed;
    $temp = $phpObj->query->results->channel->item->condition->temp;

    // test 
    echo $condition;
    echo "\n";
    echo $temp;
    echo "\n";
    echo $wind;

    /*
    	send udp (pew pew)
    */
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    $to  = '1.2.3.177';
    $toPort = 8888;
    $msg = abs(15-$wind);
    $len = strlen($msg);
    // test
    echo "\n";
    echo $msg;
    echo "\n";
    socket_sendto($sock, $msg, $len, 0 ,$to, $toPort);
    socket_close($sock);


    /* 
    	write ssid(s)
    */

    $ssid1 = "++++🆆🆂🆂🅸🅳";
    $ssid2 = "++-Brooklyn,+NY+".(string)$temp."°";
    $ssid3 = "++-Currently+".$condition;
    $ssid4 = "++-Wind ▁▂◌▃▅▆▇";
    // :(
    exec("curl http://1.2.3.4/apply.cgi -d \"submit_button=Wireless_Basic&action=ApplyTake&change_action=gozila_cgi&submit_type=save&wl0_nctrlsb=&wl1_nctrlsb=&iface=&wl0_mode=ap&wl0_net_mode=mixed&wl0_ssid=".$ssid1."&wl0_channel=6&wl0_closed=0&wl0_distance=2000&eth1_bridged=1&eth1_multicast=0&eth1_nat=1&eth1_ipaddr=4&eth1_ipaddr_0=0&eth1_ipaddr_1=0&eth1_ipaddr_2=0&eth1_ipaddr_3=0&eth1_netmask=4&eth1_netmask_0=0&eth1_netmask_1=0&eth1_netmask_2=0&eth1_netmask_3=0&wl0.1_ssid=".$ssid2."&wl0.1_closed=0&wl0.1_ap_isolate=0&wl0.1_bridged=1&wl0.1_multicast=0&wl0.1_nat=1&wl0.1_ipaddr=4&wl0.1_ipaddr_0=0&wl0.1_ipaddr_1=0&wl0.1_ipaddr_2=0&wl0.1_ipaddr_3=0&wl0.1_netmask=4&wl0.1_netmask_0=0&wl0.1_netmask_1=0&wl0.1_netmask_2=0&wl0.1_netmask_3=0&wl0.2_ssid=".$ssid3."&wl0.2_closed=0&wl0.2_ap_isolate=0&wl0.2_bridged=1&wl0.2_multicast=0&wl0.2_nat=1&wl0.2_ipaddr=4&wl0.2_ipaddr_0=0&wl0.2_ipaddr_1=0&wl0.2_ipaddr_2=0&wl0.2_ipaddr_3=0&wl0.2_netmask=4&wl0.2_netmask_0=0&wl0.2_netmask_1=0&wl0.2_netmask_2=0&wl0.2_netmask_3=0&wl0.3_ssid=".$ssid4."&wl0.3_closed=0&wl0.3_ap_isolate=0&wl0.3_bridged=1&wl0.3_multicast=0&wl0.3_nat=1&wl0.3_ipaddr=4&wl0.3_ipaddr_0=0&wl0.3_ipaddr_1=0&wl0.3_ipaddr_2=0&wl0.3_ipaddr_3=0&wl0.3_netmask=4&wl0.3_netmask_0=0&wl0.3_netmask_1=0&wl0.3_netmask_2=0&wl0.3_netmask_3=0\" -u user:pass");

?>