<?php

$ipaddr = "";
$ipaddr_old = "";

while(1) {
	$result = shell_exec("ifconfig wlan0");
	$output_array = array();
	preg_match_all("/inet addr:([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})/", $result, $output_array);

	$ipaddr = $output_array[1][0];
	if(strcmp($ipaddr_old, $ipaddr)) {
		file_get_contents("http://ipd.unist.xyz/?raspberrypi=$ipaddr");
		$ipaddr_old = $ipaddr;
		echo "ip updated".PHP_EOL;
	} else {
		echo "nop, skip".PHP_EOL;
	}
	
	sleep(10);
}

?>
