<?php

namespace App\Http\Controllers;
use App\Models\Wallet as WalletModel;
use App\Models\Trades as TradesModel;
use Illuminate\Http\Request;

class Wallet extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $wallet = WalletModel::all();

        return response()->json($wallet, 200);
    }

    public function count(Request $request) {
        $aux = [];
        $aux2 = [];
        $aux3 = [];
        $wallets = WalletModel::all();

        /* dd($wallets);die; */
        foreach($wallets as $wallet) {

            if($wallet->categories->count() > 0 ){

                foreach($wallet->categories as $c) {
                    if($c->assets->count() > 0){

                        foreach($c->assets as $a) {
                            $aux[$c->name][] = TradesModel::where('assetObj.name', $a->name)
                                   ->groupBy('asset_id')
                                   ->sum('investiment');
                        }

                        $aux2[$wallet->name][] = array_sum($aux[$c->name]) ;
                        unset($aux[$c->name]);
                        $aux = array_filter($aux);
                    }
                }
                $aux3[] = ['name' => $wallet->name, 'total' => array_sum($aux2[$wallet->name]) ];
                /* unset($aux[$c->name]); */
                /* $aux3 = array_filter($aux); */
            }
        }

        return response()->json($aux3, 200);
    }

    public function post(Request $request) {

        $wallet = new WalletModel();
        $wallet->name = $request->input('name');

        $wallet->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $wallet = WalletModel::find($id);

        $wallet->name = $request->input('name');

        $wallet->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $wallet = WalletModel::find($id);
        $wallet->delete();

        return response()->json($wallet, 200);
    }
}
