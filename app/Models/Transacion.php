<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacion extends Model
{
    protected  $table = 'transactions';
    protected $fillable = ['amount','title','date','user_id','type'];
    use HasFactory;
    public function transactionable(){
        return $this->morphTo();
    }
}
