<?php

use App\Models\User;
use App\Models\Requests;
use App\Models\Connection;
use App\Services\SuggestionsService;
use App\Services\ConnectionsService;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getCustomerDetail')) {
    function getCustomerDetail(String $type, $id)
    {
        $cat = User::where('id', $id)->pluck($type)->first();
        return $cat;
    }
}

if (!function_exists('getTotalRequests')) {
    function getTotalRequests()
    {
        $userId = Auth::id();
        $request = Requests::where('send_by_id', $userId)->get();
        $requestIds = $request->pluck('send_to_id')->count();
        return $requestIds;
    }
}

if (!function_exists('getCommonConnections')) {
    function getCommonConnections($id)
    {
        $connection = Connection::where('connected_to_id', $id)->pluck('connected_by_id')->toArray();
        $connectionMy = Connection::where('connected_to_id', Auth::id())->pluck('connected_by_id')->toArray();
        $commonConnection = array_intersect($connection, $connectionMy);
        return count($commonConnection) ?? 0;
    }
}

if (!function_exists('getTotalReceiveRequests')) {
    function getTotalReceiveRequests()
    {
        $request = Requests::where('send_to_id', Auth::id())->get();
        $requestIds = $request->pluck('send_to_id')->count();
        return $requestIds;
    }
}

if (!function_exists('getTotalSuggestions')) {
    function getTotalSuggestions()
    {
        $suggestion = new SuggestionsService();
        $suggestion = $suggestion->index();
        return $suggestion->total($suggestion);
    }
}

if (!function_exists('getTotalConnections')) {
    function getTotalConnections()
    {
        $connection = new ConnectionsService();
        $connection = $connection->index();
        return $connection->total($connection);
    }
}



