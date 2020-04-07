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

    public function count() {
        $aux = [];

        $trades = Trades::groupBy('asset')->get(['asset']);
        foreach($trades as $t) {
            /* dd($t->asset['name']); */
            $aux[] = [
                "name" => $t->asset['name'],
                "total" => Trades::where('asset.name', $t->asset['name'])
                                                         ->groupBy('asset')
                                                         ->sum('investiment')
                          ];
        }


        return response()->json($aux, 200);
    }

    public function post(Request $request) {

        $trade = new Trades();
        $trade->broker = $request->input('broker');
        $trade->amount = $request->input('amount');
        $trade->payout = $request->input('payout');
        $trade->date = $request->input('date');
        $trade->asset = $request->input('asset');
        $trade->investiment = (float)$request->input('investiment');
        $trade->usuarioId = $request->input('usuarioId');

        $trade->save();

        return response()->json(['msg' => 'criado com sucesso', 'trade' => $trade], 200);
    }

    public function put(Request $request, $id) {

        $trade = Trades::find($id);

        $trade->broker = $request->input('broker');
        $trade->amount = $request->input('amount');
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
