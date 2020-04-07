<?php

namespace App\Http\Controllers;
use App\Models\Category as CategoryModel;
use App\Models\Wallet as WalletModel;
use App\Models\Trades as TradesModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
class Category extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $category = CategoryModel::all();

        return response()->json($category, 200);
    }

    public function byWallet(Request $request, $walletId) {
        $aux = [];
        $aux2 = [];

        $wallet = WalletModel::find($walletId);

        foreach($wallet->categories as $c) {

            foreach($c->assets as $a) {
                /* dd($a); */
                $aux[$c->name][] = TradesModel::where('asset.name', $a->name)
                                                             ->groupBy('asset')
                                                             ->sum('investiment');
            }

            $aux2[] = [
                'name' => $c->name,
                'total' => array_sum($aux[$c->name])
            ];
            unset($aux[$c->name]);
            $aux = array_filter($aux);
        }


        return response()->json($aux2, 200);
    }

    public function post(Request $request) {

        $category = new CategoryModel();
        $category->name = $request->input('name');
        $category->wallet = $request->input('wallet')['_id'];

        $category->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $category = CategoryModel::find($id);

        $category->name = $request->input('name');
        $category->wallet = $request->input('wallet')['_id'];

        $category->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $category = CategoryModel::find($id);
        $category->delete();

        return response()->json($category, 200);
    }
}
