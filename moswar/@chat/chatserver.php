#!/usr/bin/php
<?php
require_once "config.inc.php";
require_once "ClientSock.php";
require_once "TCPListener.php";
require_once "Chat.php";

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

$tcpListener = new TCPListener($listenip, $listenport);
SocketManager::addSocket($tcpListener, "server");

$isRunning = true;
Chat::init();
while ( $isRunning ) {
	$status = null;
	$pid = pcntl_wait($status, WNOHANG);
	if (isset(Chat::$pids["p" . $pid]) && Chat::$pids["p" . $pid]) {
		Chat::$pids["p" . $pid] = false;
		unset(Chat::$pids["p" . $pid]);
	}
	SocketManager::handleEvents();
}

?>
