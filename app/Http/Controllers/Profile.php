<?php

namespace App\Http\Controllers;
use App\Models\Profile as ProfileModel;
use App\Models\Trades as TradesModel;
use Illuminate\Http\Request;

class Profile extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, $userId) {

        /* $profile = ProfileModel::all(); */
        $profile = ProfileModel::where('user_id', $userId)->get();


        return response()->json($profile, 200);
    }

    public function count(Request $request) {
        $profiles = ProfileModel::all();

        $aux = [];
        $auxProf = [];
        $totalAsset = 0;

        foreach($profiles as $index => $profile) {

            if(!empty($profile->wallet)) {
                foreach($profile->wallet as $wallet) {
                    foreach($wallet->categories as $category) {
                        $totalAsset = 0;
                        foreach($category->assets as $asset) {

                            $tradesSum = TradesModel::where('asset_id', $asset->_id)->get();

                            foreach($tradesSum as $s) {
                                $totalAsset += ((int)$s->amount * (int)$s->investiment);
                            }

                            $aux[] = [
                                "name" => $asset->name,
                                "price" => $asset->price,
                                "category" => $asset->category->name,
                                "wallet" => $asset->category->wallet->name,
                                "amount" => TradesModel::where('asset_id', $asset->_id)
                                                                         ->groupBy('asset_id')
                                                                         ->sum('amount'),
                               'total'   => $totalAsset
                            ];

                        }
                    }
                }
            }

            $totalPro = 0;
            foreach($aux as $as) {
                $totalPro += $as['total'];
            }
            $aux = [];

            $auxProf[$index] = [
                '_id' => $profile->_id,
                'default' => $profile->default,
                'name' => $profile->name,
                'total' => $totalPro
            ];

        }

        /* dd($aux); */
        /* dd($auxProf); */

        return response()->json($auxProf, 200);
    }

    /* public function count() { */
    /*     $aux = []; */

    /*     $trades = Trades::groupBy('asset_id')->get([]); */
    /*     foreach($trades as $t) { */

    /*         $tradesSum = Trades::where('asset_id', $t->asset->_id)->get(); */
    /*         foreach($tradesSum as $s) { */
    /*             $totalAsset += ($s->amount * $s->investiment); */
    /*         } */

    /*         $aux[] = [ */
    /*             "name" => $t->asset->name, */
    /*             "price" => $t->asset->price, */
    /*             "category" => $t->asset->category->name, */
    /*             "wallet" => $t->asset->category->wallet->name, */
    /*             "amount" => Trades::where('asset_id', $t->asset->_id) */
    /*                                                      ->groupBy('asset_id') */
    /*                                                      ->sum('amount'), */
    /*            'total'   => $totalAsset */
    /*        ]; */
    /*     } */

    /*     return response()->json($aux, 200); */
    /* } */

    public function post(Request $request) {

        $profile = new ProfileModel();
        $profile->name = $request->input('name');
        $profile->default = (boolean)$request->input('default');
        $profile->user_id = \Auth::user()->id;

        $profile->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $profile = ProfileModel::find($id);

        $profile->name = $request->input('name');
        $profile->default = (boolean)$request->input('default');

        $profile->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $profile = ProfileModel::find($id);
        $profile->delete();

        return response()->json($profile, 200);
    }
}
