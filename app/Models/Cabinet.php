<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'background'];

    public function schedules()
    {
        return $this->hasMany(
            Schedule::class,
            'cabinet_id'
        );
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($cabinet) {
            $cabinet->schedules()->delete();
        });
    }



}
