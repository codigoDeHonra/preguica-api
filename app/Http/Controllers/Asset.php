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

        $asset = AssetModel::with(['category'])->get();

        return response()->json($asset->load('category'), 200);
    }

    public function show(Request $request, $code) {

        $asset = AssetModel::where('name', $code)->with(['category'])->first();

        return response()->json($asset->load('category'), 200);
    }

    public function post(Request $request) {

        $asset = new AssetModel();
        $asset->name = trim($request->input('name'));
        $asset->category_id = $request->input('category')['_id'];
        $asset->price = $request->input('price');

        $asset->save();

        return response()->json(['msg' => 'criado com sucesso', 'asset' => $asset], 200);
    }

    public function put(Request $request) {

        $asset = assetModel::find($request->input('_id'));

        $asset->name = trim($request->input('name'));
        $asset->category_id = $request->input('category')['_id'];
        $asset->price = $request->input('price');

        $asset->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $asset = AssetModel::find($id);
        $asset->delete();

        return response()->json($asset, 200);
    }
}
