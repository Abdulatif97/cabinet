<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'cabinet_schedule';
    protected $fillable = ['from', 'date', 'to', 'cabinet_id', 'user_id'];

    public function user() {
        return $this->hasOne( User::class, 'id', 'user_id' );
    }

    public function cabinet() {
        return $this->hasOne( Cabinet::class, 'id','cabinet_id' );
    }

}
