<?php

namespace App\Http\Controllers;
use App\Models\Asset as AssetModel;
use Illuminate\Http\Request;

class Asset extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $asset = AssetModel::all();

        return response()->json($asset, 200);
    }

    public function post(Request $request) {

        $asset = new AssetModel();
        $asset->name = $request->input('name');
        $asset->category = $request->input('category');

        $asset->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $asset = assetModel::find($id);

        $asset->name = $request->input('name');

        $asset->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $asset = AssetModel::find($id);
        $asset->delete();

        return response()->json($asset, 200);
    }
}
