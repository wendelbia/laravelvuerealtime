<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chat\Message;
use App\Events\Chat\MessageCreated;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function messages(Message $message)
    {
    	//se fizer só ->get() traz todas as mensagens
        $messages = $message->with('user')
        						//traz en decrescente
                                ->orderBy('id', 'DESC')
                                //qro 50 mensagens
                                ->limit(50)
                                //traz as últimas mensagens
                                ->latest()
                                ->get();
        //retorna a var 
        return response()->json($messages);
    }
//parra cadastro 
    public function store(Request $request)
    {
    	//pega o usu logado se pegar $request->user o resultado é o mesmo
        $user = auth()->user();
        //->messages() assim já recupero as mensagens do usu
        $message = $user->messages()->create([
        	//essa é a nova mensagem com o params body é bom lembrar q na model Message no fillable temos o body señ teriamos um  erro
            'body' => $request->body
        ]);

        $message['user'] = $user;
        //passo a menssagem e uso o toOthers q vai passar a mensagem para os dmaisi usuários volto em MessageCreated
        broadcast(new MessageCreated($message))->toOthers();

        return response()->json($message, 201);
    }
}
