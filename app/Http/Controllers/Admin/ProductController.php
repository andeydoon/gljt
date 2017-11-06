<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use App\ProductAttribute;
use App\ProductColour;
use App\ProductGallery;
use App\ProductParameter;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Krucas\Notification\Facades\Notification;

class ProductController extends Controller
{
    public function index()
    {
        $data = [];
        $data['product_statuses'] = $this->product_statuses;

        return view('admin.product.index', $data);
    }

    public function edit($id)
    {
        $data = [];

        $data['product'] = Product::findOrFail($id);
        $data['product_statuses'] = $this->product_statuses;
        $data['category_parent'] = Category::where('parent_id', 0)->get();
        $data['dealers'] = User::where('type', User::TYPE_DEALER)->get();

        return view('admin.product.edit', $data);
    }

    public function create()
    {
        $data = [];

        $data['product_statuses'] = $this->product_statuses;
        $data['category_parent'] = Category::where('parent_id', 0)->get();
        $data['dealers'] = User::where('type', User::TYPE_DEALER)->get();

        return view('admin.product.create', $data);
    }
}
