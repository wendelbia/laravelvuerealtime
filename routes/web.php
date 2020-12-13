<?php


Broadcast::routes();
//crio um grupo de rotas q passa pelo middleware 
$this->group(['middleware' => 'auth'], function () {
    $this->get('chat', 'Chat\ChatController@index')->name('chat');
    
    $this->get('chat/messages', 'Chat\ChatController@messages');
    //rota de cadastro, posso dar um nome para essa rota
    $this->post('chat/message', 'Chat\ChatController@store');

    $this->get('meu-perfil', 'User\UserController@profile')->name('profile');
    $this->post('meu-perfil', 'User\UserController@profileUpdate')->name('profile.update');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
