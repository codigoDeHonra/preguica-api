<?php

namespace App\Http\Controllers;
use App\Models\Category as CategoryModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
class Category extends Controller
{
    public function __construct()
    {
        //
    }
    public function index(Request $request) {

        $category = CategoryModel::all();

        return response()->json($category, 200);
    }

    public function post(Request $request) {

        $category = new CategoryModel();
        $category->name = $request->input('name');

        $category->save();

        return response()->json('criado com sucesso', 200);
    }

    public function put(Request $request, $id) {

        $category = CategoryModel::find($id);

        $category->name = $request->input('name');

        $category->save();

        return response()->json('atualizado com sucesso', 200);
    }

    public function delete(Request $request, $id) {

        $category = CategoryModel::find($id);
        $category->delete();

        return response()->json($category, 200);
    }
}
