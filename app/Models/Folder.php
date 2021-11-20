<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'folder';
    protected $fillable = ['title','user_id'];
    use HasFactory;
    public function transactions(){
        return $this->morphMany(Transacion::class , 'transactionable');
    }
    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }
}
