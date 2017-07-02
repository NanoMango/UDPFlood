@echo off
TITLE UDPFlood
cd /d %~dp0

if exist bin\php\php.exe (
	set PHPRC=""
	set PHP_BINARY=bin\php\php.exe
) else (
	set PHP_BINARY=php
)

if exist UDPFlood\UDPFlood.php (
	set UDPFLOOD=UDPFlood\UDPFlood.php
) else (
	echo "UDPFlood.php is not found."
	pause
	exit 1
)

REM if exist bin\php\php_wxwidgets.dll (
REM 	%PHP_BINARY% %UDPFLOOD% --enable-gui %*
REM ) else (
	if exist bin\mintty.exe (
		start "" bin\mintty.exe -o Columns=130 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o Font="DejaVu Sans Mono" -o FontHeight=10 -o CursorType=0 -o CursorBlinks=1 -h error -t "UDPFlood" -i bin/udpflood.ico %PHP_BINARY% %UDPFLOOD% --enable-ansi %*
	) else (
		%PHP_BINARY% -c bin\php %UDPFLOOD% %*
	)
REM )
