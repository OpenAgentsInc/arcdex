<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurboConvo extends Model
{
    use HasFactory;

    protected $guarded = [];

    // hasmany Messages
    public function messages()
    {
        return $this->hasMany(TurboMessage::class);
    }
}
