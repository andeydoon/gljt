<?php

namespace App\Http\Controllers\Api;

use App\Area;
use App\Category;
use App\Feedback;
use App\Material;
use App\Product;
use App\UserQuote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->from == 'ckeditor') {
            $funcNum = $request->input('CKEditorFuncNum');
            $message = $fileUrl = '';
            if ($request->hasFile('upload')) {
                if ($request->file('upload')->isValid()) {
                    $file = $request->file('upload')->store('uploads');
                    $url = sprintf('http://%s/%s/%s', env('OSS_DOMAIN'), env('OSS_PREFIX'), $file);
                } else {
                    $message = '上传文件发生错误';
                }
            } else {
                $message = '未选择上传文件';
            }

            return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        }

        $files = [];
        foreach ($request->allFiles() as $name => $file) {
            $path = $file->store('uploads');
            $path = sprintf('http://%s/%s/%s', env('OSS_DOMAIN'), env('OSS_PREFIX'), $path);
            $files[$name] = $path;
        }

        return response()->json(['status' => 'success', 'data' => compact('files')]);
    }

    public function feedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
            'content' => ['required'],
        ], [
            'phone.required' => '电话不能为空',
            'content.required' => '内容不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $user = $request->user();

        $feedback = new Feedback;
        $feedback->phone = $request->phone;
        $feedback->content = $request->content;

        $user->feedback()->save($feedback);

        return response()->json(['status' => 'success']);
    }

    public function area(Request $request)
    {
        $parentId = $request->input('parent_id', 100000);

        $areas = Area::where('parent_id', $parentId)->get();

        return response()->json(['status' => 'success', 'data' => compact('areas')]);
    }

    public function category(Request $request)
    {
        $parentId = $request->input('parent_id', 0);

        $categories = Category::where('parent_id', $parentId)->with('materials')->get();

        return response()->json(['status' => 'success', 'data' => compact('categories')]);
    }

    public function material(Request $request)
    {
        $categoryId = $request->input('category_id', 0);

        $materials = Material::where('category_id', $categoryId)->get();

        return response()->json(['status' => 'success', 'data' => compact('materials')]);
    }

    public function quote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['required'],
            'material_id' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'district_id' => ['required'],
            'phone' => ['required'],
        ], [
            'category_id.required' => '类型不能为空',
            'material_id.required' => '材质不能为空',
            'province_id.required' => '省份不能为空',
            'city_id.required' => '城市不能为空',
            'district_id.required' => '区县不能为空',
            'phone.required' => '电话不能为空',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

            $userQuote = new UserQuote;
            $userQuote->category_id = $request->category_id;
            $userQuote->material_id = $request->material_id;
            $userQuote->province_id = $request->province_id;
            $userQuote->city_id = $request->city_id;
            $userQuote->district_id = $request->district_id;
            $userQuote->thickness = $request->thickness;
            $userQuote->height = $request->height;
            $userQuote->width = $request->width;
            $userQuote->phone = $request->phone;

            $userQuote->save();

            $data = [];

            $data['price_min'] = Product::where('material_id', $request->material_id)->where('type', 1)->orderBy('price', 'ASC')->value('price');
            $data['price_max'] = Product::where('material_id', $request->material_id)->where('type', 1)->orderBy('price', 'DESC')->value('price');
            $products = [];
            foreach (Product::where('material_id', $request->material_id)->where('type', 1)->inRandomOrder()->take(2)->get() as $product) {
                $array = [];
                $array['name'] = $product->name;
                $array['id'] = $product->id;
                $array['cover'] = $product->galleries()->value('src');
                $products[] = $array;
            }
            $data['products'] = $products;

            DB::commit();
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = '系统繁忙，请稍后再试';
            if (app()->environment('local')) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'message' => $message]);
        }


    }
}
