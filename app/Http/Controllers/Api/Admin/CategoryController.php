<?php

namespace App\Http\Controllers\Api\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categoies = Category::with('parent');

        return Datatables::of($categoies)->make(true);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category->children()->count()) {
            return response()->json(['status' => 'error', 'message' => '无法删除存在子分类的分类']);
        }

        if ($category->products()->count()) {
            return response()->json(['status' => 'error', 'message' => '无法删除存在产品的分类']);
        }

        $category->delete();

        return response()->json(['status' => 'success']);
    }
}
