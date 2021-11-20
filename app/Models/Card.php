<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Card extends Model
{
    protected $table = 'cards';
    protected $fillable=['cart_number','title','user_id'];
    use HasFactory,SoftDeletes;
    public function transactions(){
        return $this->morphMany(Transacion::class , 'transactionable');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
