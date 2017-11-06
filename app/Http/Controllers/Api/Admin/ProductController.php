<?php

namespace App\Http\Controllers\Api\Admin;

use App\Product;
use App\ProductAttribute;
use App\ProductColour;
use App\ProductGallery;
use App\ProductParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category', 'material', 'user')->orderBy('created_at', 'ASC')->get();

        return Datatables::of($products)->make(true);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['required'],
            'material_id' => ['required'],
            'name' => ['required'],
            'unit' => ['required'],
            'price' => ['numeric', 'between:0.01,9999999'],
            'status' => ['required'],
            'old_attributes' => ['array'],
            'attributes' => ['array'],
            'old_colours' => ['array'],
            'colours' => ['array'],
            'old_parameters' => ['array'],
            'parameters' => ['array'],
            'old_galleries' => ['required_without:galleries', 'array'],
            'galleries' => ['required_without:old_galleries', 'array'],
        ], [
            'category_id.required' => '类型不能为空',
            'material_id.required' => '材质不能为空',
            'name.required' => '产品名称不能为空',
            'unit.required' => '计量单位不能为空',
            'status.required' => '状态不能为空',
            'price.numeric' => '单位价格格式有误',
            'price.between' => '单位价格大小为0.01~9999999',
            'colours.array' => '颜色格式有误',
            'parameters.array' => '参数格式有误',
            'old_galleries.required_without' => '产品大图不能为空',
            'old_galleries.array' => '产品大图格式有误',
            'galleries.required_without' => '产品大图不能为空',
            'galleries.array' => '产品大图格式有误',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $product = Product::findOrFail($id);

        $productColours = [];
        if ($request->has('colours')) {
            for ($i = 0; $i < count($request->colours['name']); $i++) {
                if (empty($request->colours['name'][$i]) || empty($request->colours['price'][$i]) || empty($request->colours['picture'][$i])) {
                    return response()->json(['status' => 'error', 'message' => '颜色信息未完善']);
                }
                if ($request->colours['price'][$i] < 0.01 || $request->colours['price'][$i] > 9999999) {
                    return response()->json(['status' => 'error', 'message' => '颜色价格大小为0.01~9999999']);
                }
                $productColour = new ProductColour;
                $productColour->name = $request->colours['name'][$i];
                $productColour->price = $request->colours['price'][$i];
                $productColour->picture = $request->colours['picture'][$i];

                $productColours[] = $productColour;
            }
        }
        parse_str(file_get_contents("php://input"), $_PUT);
        $productAttributes = [];
        if (isset($_PUT['attributes'])) {
            for ($i = 0; $i < count($_PUT['attributes']['label']); $i++) {
                if (empty($_PUT['attributes']['label'][$i]) || empty($_PUT['attributes']['value'][$i])) {
                    return response()->json(['status' => 'error', 'message' => '属性信息未完善']);
                }
                $productAttribute = new ProductAttribute;
                $productAttribute->label = $_PUT['attributes']['label'][$i];
                $productAttribute->value = $_PUT['attributes']['value'][$i];

                $productAttributes[] = $productAttribute;
            }
        }
        $productParameters = [];
        if ($request->has('parameters')) {
            for ($i = 0; $i < count($request->parameters['name']); $i++) {
                if (empty($request->parameters['name'][$i]) || empty($request->parameters['type'][$i]) || ($request->parameters['type'][$i] == 2 && empty($request->parameters['items'][$i]))) {
                    return response()->json(['status' => 'error', 'message' => '参数信息未完善']);
                }
                $productParameter = new ProductParameter;
                $productParameter->name = $request->parameters['name'][$i];
                $productParameter->items = $request->parameters['items'][$i];
                $productParameter->type = $request->parameters['type'][$i];

                $productParameters[] = $productParameter;
            }
        }
        $productGalleries = [];
        if ($request->has('galleries')) {
            foreach ($request->galleries as $gallery) {
                $productGallery = new ProductGallery;
                $productGallery->src = $gallery;

                $productGalleries[] = $productGallery;
            }
        }

        try {
            DB::beginTransaction();

            if ($request->has('old_colours')) {
                foreach ($product->colours as $colour) {
                    if (!array_key_exists($colour->id, $request->old_colours)) {
                        $colour->delete();
                    } else {
                        $colour->name = $request->old_colours[$colour->id]['name'];
                        $colour->price = $request->old_colours[$colour->id]['price'];
                        $colour->picture = $request->old_colours[$colour->id]['picture'];
                        $colour->save();
                    }
                }
            } else {
                $product->colours()->delete();
            }
            if ($request->has('old_attributes')) {
                foreach ($product->attributes as $attribute) {
                    if (!array_key_exists($attribute->id, $request->old_attributes)) {
                        $attribute->delete();
                    } else {
                        $attribute->label = $request->old_attributes[$attribute->id]['label'];
                        $attribute->value = $request->old_attributes[$attribute->id]['value'];
                        $attribute->save();
                    }
                }
            } else {
                $product->attributes()->delete();
            }
            if ($request->has('old_parameters')) {
                foreach ($product->parameters as $parameter) {
                    if (!array_key_exists($parameter->id, $request->old_parameters)) {
                        $parameter->delete();
                    } else {
                        $parameter->name = $request->old_parameters[$parameter->id]['name'];
                        $parameter->save();
                    }
                }
            } else {
                $product->parameters()->delete();
            }
            if ($request->has('old_galleries')) {
                foreach ($product->galleries as $gallery) {
                    if (!array_key_exists($gallery->id, $request->old_galleries)) {
                        $gallery->delete();
                    } else {
                        $gallery->src = $request->old_galleries[$gallery->id];
                        $gallery->save();
                    }
                }
            } else {
                $product->galleries()->delete();
            }

            $product->status = $request->status;
            $product->user_id = $request->user_id;
            $product->category_id = $request->category_id;
            $product->material_id = $request->material_id;
            $product->name = $request->name;
            $product->describe = $request->describe;
            $product->unit = $request->unit;
            $product->price = $request->price;
            $product->overview = $request->overview;

            $product->save();

            $product->attributes()->saveMany($productAttributes);
            $product->colours()->saveMany($productColours);
            $product->galleries()->saveMany($productGalleries);
            $product->parameters()->saveMany($productParameters);

            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = '系统繁忙，请稍后再试';
            if (app()->environment('local')) {
                $message = $e->getMessage();
            }
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['required'],
            'material_id' => ['required'],
            'name' => ['required'],
            'unit' => ['required'],
            'price' => ['numeric', 'between:0.01,9999999'],
            'colours' => ['array'],
            'parameters' => ['array'],
            'galleries' => ['required', 'array'],
        ], [
            'category_id.required' => '类型不能为空',
            'material_id.required' => '材质不能为空',
            'name.required' => '产品名称不能为空',
            'unit.required' => '计量单位不能为空',
            'price.numeric' => '单位价格格式有误',
            'price.between' => '单位价格大小为0.01~9999999',
            'attributes.array' => '属性格式有误',
            'colours.array' => '颜色格式有误',
            'parameters.array' => '参数格式有误',
            'galleries.required' => '产品大图不能为空',
            'galleries.array' => '产品大图格式有误',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'data' => $validator->errors()]);
        }

        $productColours = [];
        if ($request->has('colours')) {
            for ($i = 0; $i < count($request->colours['name']); $i++) {
                if (empty($request->colours['name'][$i]) || empty($request->colours['price'][$i]) || empty($request->colours['picture'][$i])) {
                    return response()->json(['status' => 'error', 'message' => '颜色信息未完善']);
                }
                if ($request->colours['price'][$i] < 0.01 || $request->colours['price'][$i] > 9999999) {
                    return response()->json(['status' => 'error', 'message' => '颜色价格大小为0.01~9999999']);
                }
                $productColour = new ProductColour;
                $productColour->name = $request->colours['name'][$i];
                $productColour->price = $request->colours['price'][$i];
                $productColour->picture = $request->colours['picture'][$i];

                $productColours[] = $productColour;
            }
        }
        $productAttributes = [];
        if (isset($_POST['attributes'])) {
            for ($i = 0; $i < count($_POST['attributes']['label']); $i++) {
                if (empty($_POST['attributes']['label'][$i]) || empty($_POST['attributes']['value'][$i])) {
                    return response()->json(['status' => 'error', 'message' => '属性信息未完善']);
                }
                $productAttribute = new ProductAttribute;
                $productAttribute->label = $_POST['attributes']['label'][$i];
                $productAttribute->value = $_POST['attributes']['value'][$i];

                $productAttributes[] = $productAttribute;
            }
        }
        $productParameters = [];
        if ($request->has('parameters')) {
            for ($i = 0; $i < count($request->parameters['name']); $i++) {
                if (empty($request->parameters['name'][$i]) || empty($request->parameters['type'][$i]) || ($request->parameters['type'][$i] == 2 && empty($request->parameters['items'][$i]))) {
                    return response()->json(['status' => 'error', 'message' => '参数信息未完善']);
                }
                $productParameter = new ProductParameter;
                $productParameter->name = $request->parameters['name'][$i];
                $productParameter->items = $request->parameters['items'][$i];
                $productParameter->type = $request->parameters['type'][$i];

                $productParameters[] = $productParameter;
            }
        }
        $productGalleries = [];
        foreach ($request->galleries as $gallery) {
            $productGallery = new ProductGallery();
            $productGallery->src = $gallery;

            $productGalleries[] = $productGallery;
        }

        $user = $request->user();

        try {
            DB::beginTransaction();

            $product = new Product;

            $product->status = $request->status;
            $product->user_id = $request->user_id;
            $product->category_id = $request->category_id;
            $product->material_id = $request->material_id;
            $product->name = $request->name;
            $product->describe = $request->describe;
            $product->unit = $request->unit;
            $product->price = $request->price;
            $product->overview = $request->overview;
            if ($request->has('type')) {
                $product->type = $request->type;
            }

            $user->products()->save($product);

            $product->attributes()->saveMany($productAttributes);
            $product->colours()->saveMany($productColours);
            $product->galleries()->saveMany($productGalleries);
            $product->parameters()->saveMany($productParameters);

            DB::commit();

            return response()->json(['status' => 'success', 'data' => ['product' => ['id' => $product->id]]]);
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
