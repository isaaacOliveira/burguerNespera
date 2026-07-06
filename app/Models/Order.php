<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   
    // Permite que estes campos sejam preenchidos em massa pelo controlador
    protected $fillable = [
        'user_id',
        'burger_id',
        'quantity',
        'total_price',
        'status',
    ];

    // Cria o relacionamento: O pedido pertence a um Hambúrguer
    public function burger()
    {
        return $this->belongsTo(Burger::class);
    }

    // Cria o relacionamento: O pedido pertence a um Utilizador (Cliente)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}




