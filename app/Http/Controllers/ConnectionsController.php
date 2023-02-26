<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ConnectionsService;
use App\Models\Requests;
use App\Models\Connection;
use App\Models\User;

class ConnectionsController extends Controller
{
    /**
     * Display a listing of connections.
     * @return JSON
     */
    public function index()
    {
        try {
            $connection      = new ConnectionsService();
            $connectionData  = $connection->index();
            $connectionTotal = $connection->total($connectionData);
            $html = view('components.connection', ['connection' => $connectionData])->render();
            return response()->json(array('success' => true, 'html' => $html, 'count' => $connectionTotal));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }

    /**
     * Display connections in common.
     * @param  int  $id
     * @return JSON
     */
    public function show($id)
    {
        try {
            $userId = Auth::id();
            // CONNECTIONS
            $connection = Connection::where('connected_to_id', $id)
                ->pluck('connected_by_id')
                ->toArray();
            $connectionMy = Connection::where('connected_to_id', $userId)
                ->pluck('connected_by_id')
                ->toArray();
            // GET THE COMMON IDS
            $commonConnection = array_intersect($connection, $connectionMy);
            // SEARCH THE IDS IN USER MODEL
            $get = User::whereIn('id', $commonConnection)->paginate(10);
            $html = view('components.connection_in_common', ['common_connection' => $get])->render();
            return response()->json(array('success' => true, 'html' => $html, 'count' => $get->count()));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }

    /**
     * Remove connection.
     * @param  int  $id
     * @return JSON
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Connection::where([
                'connected_to_id' => Auth::id(),
                'connected_by_id' => $id
            ])->delete();
            Connection::where([
                'connected_to_id' => $id,
                'connected_by_id' => Auth::id()
            ])->delete();
            DB::commit();
            return response()->json(array('success' => true, 'html' => 'success'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }
}
