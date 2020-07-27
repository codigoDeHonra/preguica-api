<?php

namespace App\Http\Controllers;
use App\Models\Trades;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\UsersImport;

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

    public function cedro() {

        $urlBase = 'http://webfeeder.cedrotech.com/';

        $signIn = 'http://webfeeder.cedrotech.com/SignIn';

        $urlLogin = '/token/authentication?login=wouerner&password=102030' ;

        $client = new \GuzzleHttp\Client([
               'base_uri' => $urlBase,
               'cookies' => true,
               'allow_redirects' => true
            ]);

        $response = $client->request('POST', $urlLogin);
        $cookieJar = $client->getConfig('cookies');
        /* dd($cookieJar); */

        $res = (array)json_decode($response->getBody()); ;

        /* dd($response->getHeaders()); */

        $r1 = $client->request(
            'GET',
            '/services/quotes/quote/petr4',
            [ 'cookies' => $cookieJar ]
        );

        $res = (array)json_decode($r1->getBody()); ;
        dd($res);


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

        /* dd($userId); */
        $trades = Trades::where('user_id', $userId)->get();

        $trades->load('asset');
        $trades->load('broker');

        /* echo '<pre>'; */
        foreach($trades as $key => $trade) {
            /* dd($trade); */
            $aux[$key] = $trade;
            $aux[$key]->asset = $trade->asset->load('category');
            $aux[$key]->wallet = $trade->asset->category->wallet;
            $aux[$key]->broker = $trade->broker;

            /* var_dump($trade->_id); */
            /* var_dump($trade->asset->name); */
            /* var_dump($trade->asset->category->name); */
            /* var_dump($trade->asset->category->getWallet->name); */

            /* dd($aux[$key]->asset->category->getWallet); */
            /* dd($aux); */
        }
        /* die; */

        /* dd((array)$aux); */

        return response()->json($aux, 200);
    }

    public function count() {
        $aux = [];

        $trades = Trades::groupBy('asset_id')->get([]);
        /* $trades->load('asset'); */
        /* dd($trades); */
        foreach($trades as $t) {


            /* $asset = Trades::find($t->asset_id); */


            $totalAsset = 0;
            $tradesSum = Trades::where('asset_id', $t->asset->_id)->get();
            foreach($tradesSum as $s) {
                $totalAsset += ($s->amount * $s->investiment);
            }
/* dd($t->asset->category->name); */
            $aux[] = [
                "name" => $t->asset->name,
                "price" => $t->asset->price,
                "category" => $t->asset->category->name,
                "wallet" => $t->asset->category->wallet->name,
                /* "total" => Trades::where('asset_id', $t->asset->_id) */
                /*                                          ->groupBy('asset_id') */
                /*                                          ->sum('investiment'), */
                "amount" => Trades::where('asset_id', $t->asset->_id)
                                                         ->groupBy('asset_id')
                                                         ->sum('amount'),
               'total'   => $totalAsset
           ];
        }

        return response()->json($aux, 200);
    }

    public function excel(Request $request) {
        /* dd($request->broker); */

        /* $array = Excel::toArray(new \App\Imports\UsersImport, 'InfoCEI.xls'); */
        $array = Excel::toArray(new \App\Imports\UsersImport, $request->file('file'));

        /* echo '<pre>'; */
        for( $i = 11; $i < count($array[0]); $i++){
            /* dd($array[0][$i][1], Carbon::createFromFormat('d/m/y', trim($array[0][$i][1]))->toDateTimeString()); //data */
            /* dd($array[0][$i][1]); //data */
            /* var_dump($array[0][$i][1]); //data */

            if (is_null($array[0][$i][1])) break;

            $date = $array[0][$i][1] ? Carbon::createFromFormat('d/m/y', trim($array[0][$i][1])) : null;
            $investiment = $array[0][$i][9];

            $assetName = trim($array[0][$i][6]);
            /* echo $assetName; */

            $asset = Asset::where('name', $array[0][$i][6])
                ->orWhere('name', substr($assetName, 0, -1))
                ->first();

            if($investiment > 0 && $asset && $asset->name){
                $trade = new Trades();

                $trade->broker_id = $request->broker;
                $trade->amount = $array[0][$i][8];
                $trade->payout = 0;
                $trade->date = $date;
                $trade->price = $array[0][$i][9];
                $trade->origin = 'CEI';

                $trade->asset()->associate($asset);
                $trade->assetObj = ['_id' => $asset->_id, 'name' => $asset->name];

                $trade->investiment = (float)$array[0][$i][9];
                $trade->user_id = \Auth::user()->id;

                $trade->save();
            }
        }

        die('ddd');
    }

    public function company(Request $request) {
        /* $this->app */
        /*      ->make(\Maatwebsite\Excel\Transactions\TransactionManager::class) */
        /*      ->extend( */
        /*          'your_handler', */
        /*          function() { */
        /*              return false; */
        /*          } */
        /*     ); */

        Excel::import(new \App\Imports\CompanyImport, 'company.xlsx');
        dd('t');
        # $array = Excel::toArray(new \App\Imports\Import, 'company.xlsx');
        /* $array = Excel::toArray(new \App\Imports\UsersImport, $request->file('file')); */

        /* dd($array); */
        /* echo '<pre>'; */
        for( $i = 11; $i < count($array[0]); $i++){
            /* dd($array[0][$i][1], Carbon::createFromFormat('d/m/y', trim($array[0][$i][1]))->toDateTimeString()); //data */
            /* dd($array[0][$i][1]); //data */
            /* var_dump($array[0][$i][1]); //data */

             dd($array[0]);

            if (is_null($array[0][$i][1])) break;

            $date = $array[0][$i][1] ? Carbon::createFromFormat('d/m/y', trim($array[0][$i][1])) : null;
            $investiment = $array[0][$i][9];

            $assetName = trim($array[0][$i][6]);
            /* echo $assetName; */

            $asset = Asset::where('name', $array[0][$i][6])
                ->orWhere('name', substr($assetName, 0, -1))
                ->first();

            if($investiment > 0 && $asset && $asset->name){
                $trade = new Trades();

                $trade->broker = '';
                $trade->amount = $array[0][$i][8];
                $trade->payout = 0;
                $trade->date = $date;
                $trade->price = $array[0][$i][9];

                $trade->asset()->associate($asset);
                $trade->assetObj = ['_id' => $asset->_id, 'name' => $asset->name];

                $trade->investiment = (float)$array[0][$i][9];
                $trade->usuarioId = \Auth::user()->id;

                $trade->save();
            }
        }

        die('ddd');
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
