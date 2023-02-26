<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\SuggestionsService;
use App\Models\User;
use App\Models\Requests;
use App\Models\Connection;

class SuggestionsController extends Controller
{
    /**
     * Display a listing of the suggestions.
     * @return JSON
     */
    public function index(Request $request)
    {
        try {
            $suggestion      = new SuggestionsService();
            $suggestionData  = $suggestion->index();
            $suggestionTotal = $suggestion->total($suggestionData);
            $html = view('components.suggestion', ['suggestions' => $suggestionData])->render();
            return response()->json(array('success' => true, 'html' => $html, 'count' => $suggestionTotal));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function store(Request $request)
    {
        try {
            Requests::create([
                'send_to_id'   => $request->sugg_id,
                'send_by_id'   => Auth::id()
            ]);
            return response()->json(array('success' => true, 'html' => "success"));
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'html' => $ex->getMessage()));
        }
    }
}
