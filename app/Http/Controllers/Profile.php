<?php

namespace App\Http\Controllers;
use App\Models\Profile as ProfileModel;
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

    public function post(Request $request) {

        $profile = new ProfileModel();
        $profile->name = $request->input('name');
        $profile->usuario_id = \Auth::user()->id;

        $profile->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $profile = ProfileModel::find($id);

        $profile->name = $request->input('name');

        $profile->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $profile = ProfileModel::find($id);
        $profile->delete();

        return response()->json($profile, 200);
    }
}
