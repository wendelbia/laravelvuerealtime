<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

//acrescento: implements ShouldBroadcast
class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    //crio o atributo para usar como params
    private $message;
    //acrescento um params
    public function __construct($message)
    {
        $this->message = $message;
    }

    //
    public function broadcastWith()
    {
        //return ['message' => $this->message]
        //vamos devolver a própria mensagem q acabamos de receber e vamos no vue.js para configura lá no Echo.js usando o listen
        return [
            //para concertar a cor de acordo com o usu
            'message' => array_merge($this->message->load('user')->toArray(), [
                'owner' => false
            ])
        ];
    }

    public function broadcastOn()
    {
        //ñ trabalho com canal privado
        //return new PrivateChannel('channel-name');
        return new PresenceChannel('chat');
        //e vou no controller
    }
}
