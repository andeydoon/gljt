<?php

namespace App\Http\Controllers\Api\Admin;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::with('category');

        return Datatables::of($materials)->make(true);
    }

    public function destroy($id)
    {
        $material = Material::find($id);

        if ($material->products()->count()) {
            return response()->json(['status' => 'error', 'message' => '无法删除存在产品的材质']);
        }

        $material->delete();

        return response()->json(['status' => 'success']);
    }
}
