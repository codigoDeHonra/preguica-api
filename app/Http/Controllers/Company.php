<?php

namespace App\Http\Controllers;
use App\Models\Company as CompanyModel;
use Illuminate\Http\Request;

class Company extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $company = CompanyModel::all();

        return response()->json($company, 200);
    }

    public function assets(Request $request) {

        $companies = CompanyModel::all();
        $assets = [];

        foreach($companies as $company) {
            foreach($company['codigos'] as $code) {
                $assets[] = $code;
            }
        }

        return response()->json($assets, 200);
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

    public function put(Request $request, $id) {

        $asset = assetModel::find($id);

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
