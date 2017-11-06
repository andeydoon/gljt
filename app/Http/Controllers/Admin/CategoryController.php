<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Krucas\Notification\Facades\Notification;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        $category_parent = Category::where('parent_id', 0)->get();

        return view('admin.category.create', compact('category_parent'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'parent_id' => ['required'],
            'name' => ['required'],
        ], [
            'name.required' => '名称不能为空',
        ]);

        $category = new Category;

        $category->parent_id = $request->parent_id;
        $category->name = $request->name;
        $category->save();

        Notification::success('新分类创建成功');

        return redirect()->route('admin.category.edit', $category);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $category_parent = Category::where('parent_id', 0)->get();

        return view('admin.category.edit', compact('category', 'category_parent'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->parent_id = $request->parent_id;
        $category->name = $request->name;
        $category->save();

        Notification::success('分类编辑成功');

        return redirect()->route('admin.category.index');
    }

    public function destroy($id)
    {
        //
    }

    public function map()
    {
        return view('admin.category.map');
    }
}
