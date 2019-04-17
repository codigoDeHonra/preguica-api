<?php

namespace App\Http\Controllers;
use App\Models\Trades;
use Illuminate\Http\Request;

class Trade extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $trades = Trades::all();

        return response()->json($trades, 200);
    }

    public function post(Request $request) {

        $trade = new Trades();
        $trade->payout = $request->input('payout');
        $trade->date = $request->input('date');
        $trade->pair = $request->input('pair');
        $trade->investiment = $request->input('investiment');
        $trade->save();

        return response()->json('criado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $trades = Trades::find($id);
        $trades->delete();

        return response()->json($trades, 200);
    }
}
