#!/usr/bin/php
<?php
$pid = pcntl_fork();

if ($pid == -1) {
    echo "fork error\n";
    exit;
} elseif ($pid > 0) {
    // завершаем работу родительского процесса
    exit;
}

umask(0);
chdir("/");

if (posix_setsid() == -1) {
    exit;
}

set_time_limit(0);

while (true) {
	$str = "";
	$address = "localhost";
	$port = 8081;
	if (!(($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) && (@socket_connect($socket, $address, $port))))
	{
		print date("d-m-y H:i:s ") . "Chat fails\n";
		print date("d-m-y H:i:s ") . "No process\n";
		copy("/tmp/chat/chat", "/tmp/chat/chat-" . date("d_m_y_H_i_s"));
		system("/etc/init.d/chat restart");
		print date("d-m-y H:i:s ") . "Chat restarted\n";
	} else {
		socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
		$str = @socket_read($socket, 10);
		if (empty($str)) {
			print date("d-m-y H:i:s ") . "Chat fails\n";
			print date("d-m-y H:i:s ") . "Read timeout 1 sec\n";
			copy("/tmp/chat/chat", "/tmp/chat/chat-" . date("d_m_y_H_i_s"));
			system("/etc/init.d/chat restart");
			print date("d-m-y H:i:s ") . "Chat restarted\n";
		}
	}
	sleep(20);
}
?>
