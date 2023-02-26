<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Requests;
use App\Models\Connection;
use App\Models\User;

class RequestsController extends Controller
{
    /**
     * Showing all connections.
     * @return JSON
     */
    public function index(Request $request)
    {
        try {
            $sendStatus = "send_by_id";
            if ($request->has('mode') && $request->mode == "accept") {
                $sendStatus = "send_to_id";
            }
            $request = Requests::where($sendStatus, Auth::id())->paginate(10);
            $html = view('components.request', ['request' => $request])->render();
            return response()->json(array('success' => true, 'html' => $html, 'count' => $request->count()));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }

    /**
     * Storing data in connections table.
     * @return JSON
     */
    public function store(Request $request)
    {
        try {
            Connection::create([
                'connected_to_id' => Auth::id(),
                'connected_by_id' => $request->connected_by_id
            ]);
            Connection::create([
                'connected_to_id' => $request->connected_by_id,
                'connected_by_id' => Auth::id()
            ]);
            $request = Requests::where('send_by_id', $request->connected_by_id)->where('send_to_id', Auth::id())->delete();
            return response()->json(array('success' => true, 'html' => "success"));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }

    /**
     * Removing value from request table or withdraw.
     * @param  int  $id
     * @return JSON
     */
    public function destroy($id)
    {
        try {
            $request = Requests::where('send_by_id', Auth::id())->where('send_to_id', $id)->delete();
            return response()->json(array('success' => true, 'html' => "success"));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }
}
