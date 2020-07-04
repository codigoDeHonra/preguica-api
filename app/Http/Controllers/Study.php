<?php

namespace App\Http\Controllers;
use App\Models\Study as StudyModel;
use Illuminate\Http\Request;

class Study extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request, $code) {

        $study = StudyModel::where('asset_code', $code)->get();

        return response()->json($study, 200);
    }

    public function show(Request $request, $code) {

        $study = studyModel::where('name', $code)->with(['category'])->get();

        return response()->json($study->load('category'), 200);
    }

    public function post(Request $request) {

        $study = new StudyModel();
        $study->name = trim($request->input('name'));
        $study->asset_code = trim($request->input('asset_code'));
        $study->asset_id = trim($request->input('asset_id'));
        $study->description = $request->input('description');

        $study->usuario_id = \Auth::user()->id;

        $study->save();

        return response()->json(['msg' => 'criado com sucesso', 'study' => $study], 200);
    }

    public function put(Request $request, $id) {

        $study = studyModel::find($id);

        $study->name = trim($request->input('name'));
        $study->category_id = $request->input('category')['_id'];

        $study->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $study = studyModel::find($id);
        $study->delete();

        return response()->json($study, 200);
    }
}
