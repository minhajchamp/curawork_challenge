<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;
    protected $fillable = ['connected_by_id', 'connected_to_id'];
    public function connectedBy()
    {
        return $this->belongsTo(User::class,'connected_by_id');
    }
    public function connectedTo()
    {
        return $this->belongsTo(User::class,'connected_to_id');
    }
}
