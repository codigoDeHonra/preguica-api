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
    public function index(Request $request, $profileId) {

        $wallet = WalletModel::where('profile_id', $profileId)->get();

        return response()->json($wallet, 200);
    }

    public function count(Request $request, $profileId) {
        $aux = [];
        $aux2 = [];
        $aux3 = [];
        $wallets = WalletModel::where('profile_id', $profileId)->get();
        /* dd($profileId, $wallets); */

        foreach($wallets as $wallet) {

            if($wallet->categories->count() > 0 ){

                foreach($wallet->categories as $c) {
                    if($c->assets->count() > 0){

                        $totalAsset = 0;
                        foreach($c->assets as $a) {
                            $tradesSum = TradesModel::where('asset_id', $a->_id)->get();
                            foreach($tradesSum as $s) {
                                $totalAsset += ($s->amount * $s->investiment);
                            }
                        }
                        /* dd($aux[$c->name]); */

                        $aux2[$wallet->name][] = $totalAsset;
                        unset($aux[$c->name]);
                        $aux = array_filter($aux);
                    }
                }

                $aux3[] = [
                    'name' => $wallet->name,
                    'total' => array_sum($aux2[$wallet->name])
                ];
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
