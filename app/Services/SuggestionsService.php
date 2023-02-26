<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Requests;
use App\Models\Connection;

class SuggestionsService {
 
    
    public function index()
    {
        // REQUESTS
        $request = Requests::where('send_by_id', Auth::id())->orWhere('send_to_id', Auth::id())->get();
        $requestIds = $request->pluck('send_to_id')->toArray();
        $requestIdsBy = $request->pluck('send_by_id')->toArray();
        // CONNECTIONS
        $connection = Connection::where('connected_to_id', Auth::id())->orWhere('connected_by_id', Auth::id())->get();
        $connectionIdsBy = $connection->pluck('connected_by_id')->toArray();
        $connectionIdsTo = $connection->pluck('connected_to_id')->toArray();
        // SUGGESTIONS
        $suggestion = User::where('id', '!=', Auth::id())
            ->whereNotIn('id', $requestIds)
            ->whereNotIn('id', $requestIdsBy)
            ->whereNotIn('id', $connectionIdsBy)
            ->whereNotIn('id', $connectionIdsTo)->paginate(10);
        
        return $suggestion;
    }

    public function total($suggestion) 
    {
        return $suggestion->count();
    }
 
}