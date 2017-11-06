<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['categories'] = Category::where('parent_id', 0)->get();

        $query = Product::where('status', 1)->orderBy('updated_at', 'DESC');

        if ($request->has('category_id')) {
            if ($category = Category::where('id', $request->category_id)->first()) {
                $data['category'] = $category;
                if ($category->parent_id == 0) {
                    $query->whereIn('category_id', $category->children()->pluck('id'));
                } else {
                    $query->where('category_id', $category->id);
                }
            }
        }

        $data['products'] = $query->paginate(8);

        $request->flashOnly('category_id');

        $data['queries'] = $request->only('category_id');

        return view('product.index', $data);
    }

    public function show($id)
    {
        $product = Product::where('status', 1)->findOrFail($id);

        return view('product.show', compact('product'));
    }

    public function custom(Request $request, $id)
    {
        $data = [];

        $product = Product::where('status', 1)->findOrFail($id);

        if ($product->colours()->count()) {
            if (!$request->has('colour_id')) {
                Notification::error('请选择颜色');
                return redirect('/product/' . $id);
            }
            if (!$productColour = $product->colours()->where('product_colours.id', $request->colour_id)->first()) {
                Notification::error('找不到该颜色');
                return redirect('/product/' . $id);
            }
            $data['productColour'] = $productColour;
        }

        $data['product'] = $product;

        return view('product.custom', $data);
    }
}
