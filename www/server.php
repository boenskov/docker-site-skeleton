#!/usr/local/bin/php -q
<?php

$address = '0.0.0.0';
$port = 10000;

error_reporting(E_ALL);

set_time_limit(0);

ob_implicit_flush();


if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "Не удалось выполнить socket_bind(): причина:  " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
}

//clients array
$clients = array();

do {
    $read = array();
    $read[] = $sock;

    $read = array_merge($read,$clients);

    // Set up a blocking call to socket_select
    if(socket_select($read,$write = NULL, $except = NULL, $tv_sec = 5) < 1)
    {
        //    SocketServer::debug("Problem blocking socket_select?");
        continue;
    }

    // Handle new Connections
    if (in_array($sock, $read)) {

        if (($msgsock = socket_accept($sock)) === false) {
            echo "Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
            break;
        }
        $clients[] = $msgsock;
        $key = array_keys($clients, $msgsock);

        /* Enviar instrucciones. */
        $msg = "\nBienvenido al Servidor De Prueba de PHP. \n" .
        "Usted es el cliente numero: {$key[0]}\n" .
        "Para salir, escriba 'quit'. Para cerrar el servidor escriba 'shutdown'.\n";
        socket_write($msgsock, $msg, strlen($msg));

    }

    // Handle Input
    foreach ($clients as $key => $client) { // for each client
        if (in_array($client, $read)) {
            if (false === ($buf = socket_read($client, 2048, PHP_NORMAL_READ))) {
                echo "Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($client)) . "\n";
                break 2;
            }
            if (!$buf = trim($buf)) {
                continue;
            }
            if ($buf == 'quit') {
                unset($clients[$key]);
                socket_close($client);
                break;
            }
            if ($buf == 'shutdown') {
                socket_close($client);
                break 2;
            }
            $talkback = "Клиент {$key}: Вы сказали '$buf'.\n";
            socket_write($client, $talkback, strlen($talkback));
            echo "$buf\n";
        }

    }
} while (true);

socket_close($sock);

