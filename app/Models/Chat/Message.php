<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Message extends Model
{
    //fillable recebe a coluna body
    protected $fillable = ['body'];
    //quais vlores pego aqui para destacar a mensagem
    protected $appends = ['owner'];

    //para destacar a mensagem
    public function getOwnerAttribute()
    {
        //retorno true caso o usu seja logado , verifica se a coluna id é logado se sim retorna true sñ retorna falso
        return $this->user_id == auth()->user()->id;
    }
    //formatando a data
    public function getCreatedAtAttribute($value)
    {

        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
    //retorna um único usuáiro, muitos para um
    public function user()
    {
        //quando se trabalha de muitos para um, usa-se belongsTo, como params qual model quero me relacionar
        return $this->belongsTo(User::class);
        //agora a authenticação de usu php artisan make:auth
    }
}
