<?php

namespace App\Http\Controllers;
use App\Models\Broker as BrokerModel;
use Illuminate\Http\Request;

class Broker extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $broker = BrokerModel::all();

        return response()->json($broker, 200);
    }

    public function post(Request $request) {

        $broker = new BrokerModel();
        $broker->name = $request->input('name');

        $broker->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $broker = BrokerModel::find($id);

        $broker->name = $request->input('name');

        $broker->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $broker = BrokerModel::find($id);
        $broker->delete();

        return response()->json($broker, 200);
    }
}
