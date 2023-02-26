<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Requests;
use App\Models\Connection;

class ConnectionsService {
 
    
    public function index()
    {
        $userId = Auth::id();
        // CONNECTIONS
        $connection = Connection::where('connected_to_id', $userId)
            ->orWhere('connected_by_id', $userId)
            ->get();
        $connectionId = $connection
            ->pluck('connected_to_id')
            ->toArray();
        // SEARCH THE ID IN USER MODEL
        $users = User::where('id', '!=', $userId)
            ->whereIn('id', $connectionId)
            ->paginate(10);
        return $users;
    }

    public function total($connection) 
    {
        return $connection->count();
    }
 
}