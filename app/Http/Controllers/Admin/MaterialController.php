<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Krucas\Notification\Facades\Notification;

class MaterialController extends Controller
{
    public function index()
    {
        return view('admin.material.index');
    }

    public function create()
    {
        $category_parent = Category::where('parent_id', 0)->get();

        return view('admin.material.create', compact('category_parent'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => ['required'],
            'name' => ['required'],
        ], [
            'category_id.required' => '类型不能为空',
            'name.required' => '名称不能为空',
        ]);

        $material = new Material;

        $material->category_id = $request->category_id;
        $material->name = $request->name;
        $material->save();

        Notification::success('新材质创建成功');

        return redirect()->route('admin.material.edit', $material);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $category_parent = Category::where('parent_id', 0)->get();

        return view('admin.material.edit', compact('material', 'category_parent'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $material->category_id = $request->category_id;
        $material->name = $request->name;
        $material->save();

        Notification::success('材质编辑成功');

        return redirect()->route('admin.material.index');
    }

    public function destroy($id)
    {
        //
    }

    public function map()
    {
        return view('admin.material.map');
    }
}
