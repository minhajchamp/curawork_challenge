<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;
    protected $fillable = ['send_to_id', 'send_by_id'];
    public function sendBy()
    {
        return $this->belongsTo(User::class, 'send_by_id');
    }
    public function sendTo()
    {
        return $this->belongsTo(User::class, 'send_to_id');
    }
}
