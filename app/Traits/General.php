<?php

namespace App\Traits;
use App\Models\User;

trait General
{
    /* Get Information of User by Customer ID
    * @params $type, $customer_id
    */
    public function getDetailedById($data = []) 
    {
        return User::pluck($data['type'])->where('id', $data['id']);
    }
}