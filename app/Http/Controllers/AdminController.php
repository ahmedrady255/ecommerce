<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\image;
use App\Models\Order;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers=User::where('is_admin',0)->count();
        $totalOrders=Order::all()->count();
        $totalDelivered=Order::where('status','delivered')->count();
        $totalOnTheWay=Order::where('status','On The Way')->count();
        return view('admin.index',compact('totalUsers','totalOrders','totalDelivered','totalOnTheWay'));
    }

    public function category()
    {
        $category = Category::all();
        $totalCategories=Category::all()->count();
        return view('admin.category', ['categories' => $category, 'total' => $totalCategories]);

    }

    public function add_category(Request $request)
    {
        $request->validate([
            'category' => 'required|unique:categories,category_name'
        ]);
        $category = new Category();
        $category->category_name = $request->category;
        $category->save();
        flash()->timeout(3000)->success('category added successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $data = Category::find($id);
        $data->delete();
        flash()->timeout(3000)->warning('category deleted successfully');
        return to_route('admin.category');

    }

    public function edit($id)
    {
        $data = Category::find($id);
        return view('admin.edit', ['cat' => $data]);
    }

    public function update($id)
    {

        $data = Category::find($id);
        request()->validate([
            'category' => 'required|string|max:255',
        ]);
        $data->update([
            'category_name' => request()->category
        ]);
//        $data->save();
        flash()->timeout(3000)->success('category updated successfully');
        return redirect()->route('admin.category');
    }

    public function addProduct()
    {
        $category = Category::all();
        return view('admin.addProduct', ['category' => $category]);
    }

    public function storeProduct(Request $request)
    {
        request()->all([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $pro_name = request()->name;
        $pro_price = request()->price;
        $pro_quantity = request()->quantity;
        $pro_category = request()->category;
        $pro_description = request()->description;
        $pro_image = request()->image;
        $pro_slider= request()->slider;
        $newProductImageName = time() . '_' . request()->name . '.' . $pro_image->extension();
        request()->image->move(public_path('productsImages'), $newProductImageName);

     $product= product::create([
            'name' => $pro_name,
            'price' => $pro_price,
            'quantity' => $pro_quantity,
            'category' => $pro_category,
            'description' => $pro_description,
            'image' => $newProductImageName,
         'with_slider' => $pro_slider,
        ]);
     if($pro_slider==1) {
         if ($request->hasFile('images')) {
             $i = 1;
             foreach ($request->file('images') as $image) {
                 $imageName = time() . '_' . request()->name . '_prodSlider' . '_' . $i . '.' . $image->extension();
                 $image->move(public_path('productsImages'), $imageName);
                 $i = $i + 1;
                 $product->images()->create(['image_path' => $imageName]);
             }
         }
     }

        flash()->timeout(3000)->success('product added successfully');
        return to_route('admin.view_products');
    }



    public function viewProducts()
    {
        $totalProducts=Product::all()->count();
        $products = product::paginate(6);
        return view('admin.viewProducts', ['products' => $products,'total' => $totalProducts]);
    }



    public function productDestroy($id)
    {
        $product_id=$id;
        $data = product::find($id);
        $im_path = public_path('productsImages/' . $data->image);
        if (file_exists($im_path)) {
            unlink($im_path);
        }

        $sliderImages=image::where('product_id',$id)->get();
        foreach ( $sliderImages as $image ) {
              $image_path = public_path('productsImages/' . $image->image_path);
              if (file_exists($image_path)) {
                  unlink($image_path);
              }
              $image->delete();

        }

        $data->delete();
        flash()->timeout(3000)->warning('category deleted successfully');
        return to_route('admin.view_products');
    }


    public function productSearch(Request $request){
        $search = $request->search;
        $results=product::where('name',$search)->orwhere('description','like',$search)->orwhere('category',$search)->get();
        return view('admin.productSearch',['results'=>$results] );
    }



    public function editProduct($id){
        $category = Category::all();
        $productFromDB=product::find($id);
        $sliderImages=image::where('product_id',$id)->get();
        return view('admin.editProduct', ['product' => $productFromDB, 'category' => $category, 'sliderImages' => $sliderImages]);
    }



    public function updateProduct($id, Request $request){

        request()->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',

        ]);
        $pro_name = request()->name;
        $pro_price = request()->price;
        $pro_quantity = request()->quantity;
        $pro_category = request()->category;
        $pro_description = request()->description;
        $pro_image = request()->image;
        $pro_slider= request()->slider;
        $product=product::find($id);

    if ($pro_image ) {
            // Retrieve the old image name
            $oldImageName = $product->image;

            // If an old image exists, delete it from storage
            if ($oldImageName) {
                $oldImagePath = public_path('productImages') . '/' . $oldImageName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload the new image
            $NewUpdatedImageName = time() . '_' . request()->title . '.' . $pro_image->extension();
            request()->image->move(public_path('images'), $NewUpdatedImageName);

            // Update the database with the new image name
            $product->update([
                'name' => $pro_name,
                'price' => $pro_price,
                'quantity' => $pro_quantity,
                'category' => $pro_category,
                'description' => $pro_description,
                'image' => $NewUpdatedImageName,
            ]);

        } else {
        // Update the database without changing the image
        $product->update([
            'name' => $pro_name,
            'price' => $pro_price,
            'quantity' => $pro_quantity,
            'category' => $pro_category,
            'description' => $pro_description,
        ]);
    }
            $sliderImages=image::where('product_id',$id)->get();
        if($pro_slider==1) {
                foreach($sliderImages as $oldImage) {
                    $image_path = public_path('productsImages/' . $oldImage->image_path);
                    if (file_exists($image_path)) {
                        unlink($image_path);
                        $old= $oldImage->image_path;
                        $old->delete();

                    }
                }
                $i = 1;
                foreach ($request->file('images') as $image) {
                    $NewUpdatedImageName = time() . '_' . request()->name . '_prodSlider' . '_' . $i . '.' . $image->extension();
                    $image->move(public_path('productsImages'), $NewUpdatedImageName);
                    $i = $i + 1;
                    $product->images()->create(['image_path' =>  $NewUpdatedImageName ]);
                }
            }


        flash()->timeout(3000)->success('product updated successfully');
    return to_route('admin.view_products');

    }

    public function viewOrders(){
        $order=order::all();
        $total=order::all()->count();
        return view('admin.viewOrders',compact('order','total'));
    }
    public function onTheWay($id)
    {
        $order=order::find($id);
        $product=product::find($order->product_id);
        if($product->quantity>=1){
           $order->status="On The Way";
           $order->save();
           $product->quantity=$product->quantity-1;
           $product->save();
        }
        else
        {
            $order->status="Canceled";
            $order->save();
            flash()->timeout(3000)->warning('product quantity is out of stock');
        }

        return redirect()->back();
    }
    public function Delivered($id)
    {
      Order::find($id)->update([
          'status'=>'Delivered'
      ]);
        return redirect()->back();
    }
}
