<?php

namespace App\Http\Controllers;
use App\Models\Trades;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Hash;
class Trade extends Controller
{
    public function __construct()
    {
        //
    }
    public function ticker() {


        /* $client = new \GuzzleHttp\Client(); */
        /* $response = $client->request('GET', 'https://api.hgbrasil.com/finance/stock_price?key=576aaf5b&symbol=ITUB4'); */
        /*  /1* dd($response->getStatusCode()); *1/ */
        /* /1* dd($response); *1/ */
        /* /1* dd((array)json_decode($response->getBody())); ; *1/ */
        /* $res = (array)json_decode($response->getBody()); ; */
        /* /1* dd($res['results']); *1/ */

        $assets = Asset::all();

        $client = new \GuzzleHttp\Client();
        echo '<pre>';
        foreach($assets as $asset){

            $response = $client->request('GET', 'https://api.hgbrasil.com/finance/stock_price?key=576aaf5b&symbol=' . trim($asset->name));
            $res = (array)json_decode($response->getBody()); ;
            /* dd($res['results']->{$asset->name}->price); */
            echo $asset->name;
/* var_dump($res['results']); */
            if(empty($res['results']->{trim($asset->name)}->error)){
                $price = ($res['results']->{trim($asset->name)}->price);
                $asset->price = $price;
                $asset->save();
            }
        }
        die;

        return response()->json('true');
    }

    public function index(Request $request, $userId) {

        $aux = [];

        $trades = Trades::where('usuarioId', '=', $userId)
            ->get();

        $trades->load('asset');

        foreach($trades as $key => $trade) {
            $aux[$key] = $trade;
            $aux[$key]->asset = $trade->asset->load('category');
            $aux[$key]->wallet = $trade->asset->category->getWallet;
            /* dd($aux); */
        }

        /* dd((array)$aux); */

        return response()->json($aux, 200);
    }

    public function count() {
        $aux = [];

        $trades = Trades::groupBy('asset_id')->get(['asset_id']);
        /* dd($trades[0]->asset->name); */
        foreach($trades as $t) {
            /* dd($t->asset->category->getWallet->name); */
            $aux[] = [
                "name" => $t->asset->name,
                "price" => $t->asset->price,
                "category" => $t->asset->category->name,
                "wallet" => $t->asset->category->getWallet->name,
                "total" => Trades::where('asset_id', $t->asset->_id)
                                                         ->groupBy('asset_id')
                                                         ->sum('investiment')
                          ];
            /* dd($aux); */
        }


        return response()->json($aux, 200);
    }

    public function post(Request $request) {

        $trade = new Trades();
        $trade->broker = $request->input('broker');
        $trade->amount = $request->input('amount');
        $trade->payout = $request->input('payout');
        $trade->date = $request->input('date');

        $asset = Asset::find($request->input('asset')['_id']);
        $trade->asset()->associate($asset);
        $trade->assetObj = $request->input('asset');

        /* $trade->asset = $request->input('asset'); */
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
        $trade->investiment = (float)$request->input('investiment');

        $trade->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $trades = Trades::find($id);
        $trades->delete();

        return response()->json($trades, 200);
    }
}
