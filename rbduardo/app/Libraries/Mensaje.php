<?php

namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Mensaje implements MessageComponentInterface
{
    protected $clients;
    protected $subscriptions;
    protected $users;
    private $userresources;


    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $this->userresources = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        // data es el mensaje enviado desde la vista, contiene varios campos:
        // command: Uno de los 4 comandos posibles:
        //      register: para registra a un usuario
        //      subscribe: para registra a un usuario en el canal
        //      message: mensaje 1 a 1 de from para to
        //      groupchat: mensaje enviado al canal en el que esté registrado el usuario
        // userId: El id del usuario que se registra
        // channel: canal de comunicación
        // to: hacia donde
        // from: desde donde
        // message: contenido del mensaje
        $data = json_decode($msg);
        switch ($data->command) {
            case 'register':
                // Si en los datos enviados desde la vista tengo el id del usuario
                if (isset($data->userId)) {
                    // Si el usuario ya está registrado
                    if (isset($this->userresources[$data->userId])) {
                        // Si el id del socket que envía se encuentra en los registros
                        if (!in_array($from->resourceId, $this->userresources[$data->userId])) {
                            // el id del socket fuente se convierte en la nueva llave del registro
                            $this->userresources[$data->userId][] = $from->resourceId;
                        }
                    // Si no
                    } else {
                        // Simplemente se asigna a un arreglo vacío
                        $this->userresources[$data->userId] = [];
                        $this->userresources[$data->userId][] = $from->resourceId;
                    }
                }
                break;
            case 'subscribe':
                // El id del socket fuente se convierte en la llave del canal enviado desde la vista
                $this->subscriptions[$from->resourceId] = $data->channel;
                break;
            case 'message':
                // Si el usuario al que se envía el mensaje se encuentra en los registros
                if (isset($this->userresources[$data->to])) {
                    
                    foreach ($this->userresources[$data->to] as $key => $resourceId) {
                        if (isset($this->users[$resourceId])) {
                            $this->users[$resourceId]->send($data->message);
                        }
                    }
                }

                if (isset($this->userresources[$data->from])) {
                    foreach ($this->userresources[$data->from] as $key => $resourceId) {
                        if (isset($this->users[$resourceId])  && $from->resourceId != $resourceId) {
                            $this->users[$resourceId]->send($data->message);
                        }
                    }
                }
                break;
            case 'groupchat':
                // Se envía el mensaje al canal para que llegue a todos los usuarios registrados en el mismo
                if (isset($this->subscriptions[$from->resourceId])) {
                    $target = $this->subscriptions[$from->resourceId];
                    foreach ($this->subscriptions as $id => $channel) {
                        if ($channel == $target and $id != $from->resourceId) {
                            $this->users[$id]->send($data->message);
                        }
                    }
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);

        foreach ($this->userresources as &$userId) {
            foreach ($userId as $key => $resourceId) {
                if ($resourceId == $conn->resourceId) {
                    unset($userId[$key]);
                }
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
