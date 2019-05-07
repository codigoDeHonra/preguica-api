<?php

namespace App\Http\Controllers;
use App\Models\Trades;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
class Trade extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request, $userId) {

        $trades = Trades::where('usuarioId', '=', $userId)->get();

        return response()->json($trades, 200);
    }

    public function post(Request $request) {

        $trade = new Trades();
        $trade->payout = $request->input('payout');
        $trade->date = $request->input('date');
        $trade->pair = $request->input('pair');
        $trade->investiment = $request->input('investiment');
        $trade->usuarioId = $request->input('usuarioId');

        $trade->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $trade = Trades::find($id);

        $trade->payout = $request->input('payout');
        $trade->date = $request->input('date');
        $trade->pair = $request->input('pair');
        $trade->investiment = $request->input('investiment');

        $trade->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $trades = Trades::find($id);
        $trades->delete();

        return response()->json($trades, 200);
    }
}
