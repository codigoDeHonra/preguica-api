<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User as UserModel;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $users = UserModel::all();

        return response()->json($users);
    }

    public function post(Request $request)
    {
        $user = new UserModel();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json('salvo!');
    }

    public function put(Request $request)
    {
        $user = UserModel::find($request->input('_id'));

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json('salvo!');
    }

    public function active(Request $request)
    {
        $user = UserModel::find($request->input('_id'));

        $user->active = (boolean)$request->input('active');
        $user->save();

        return response()->json('salvo!');
    }

    public function del(Request $request, $id)
    {
        $user = UserModel::find($id);

        UserModel::destroy($id);

        return response()->json($user);
    }
}
