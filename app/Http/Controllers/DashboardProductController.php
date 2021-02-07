<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\ProductGallery;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;

class DashboardProductController extends Controller
{
    //
    public function index() {
        $products = Product::with(['galleries','category'])->where('users_id', Auth::user()->id)->get();
        return view('pages.dashboard-products',[
            'products'=>$products
        ]);
    }
    public function details(Request $request,$id) {
        $product = Product::with(['galleries','user','category'])->findOrFail($id);
        $categories = Category::all();
        return view('pages.dashboard-products-detail',[
            'product'=>$product,
            'categories'=>$categories
        ]);
    }

    public function uploadGallery(Request $request){

         //
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/product','public');

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-detail',$request->products_id);      
    }

    public function deleteGallery(Request $request, $id){
        $item = ProductGallery::FindOrFail($id);
        $item->delete();

        return redirect()->route('dashboard-product-detail',$item->products_id);
    }
    public function create() {
        $categories = Category::all();
        return view('pages.dashboard-products-create',[
            'categories'=>$categories
        ]);
    }
    public function store(ProductRequest $request)
    {
        //
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        $gallery = [
            'products_id'=> $product->id,
            'photos'=>$request->file('photo')->store('assets/product','public')
        ];
        ProductGallery::create($gallery);
        // dd($gallery);

        return redirect()->route('dashboard-product');
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::FindOrFail($id);

        $data['slug'] = Str::slug($request->name);
        
        $item->update($data);

        return redirect()->route('dashboard-product');

    }

}
