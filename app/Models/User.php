<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Chat\Message;

class User extends Authenticatable
{
    use Notifiable;

    //
    protected $fillable = [
        'name', 'email', 'password', 'image',
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    //rel de muitos para muitos
    public function messages()
    {
        return $this->hasMany(Message::class);
        //faço o mesmo no menssage
    }
}
