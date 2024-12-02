<?php

namespace app\Http\Controllers;

use App\Models\Category;
use App\Models\image;
use App\Models\Order;
use App\Models\product;
use App\Models\stores;
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
        $totalStores=stores::all()->count();
        return view('admin.index',compact('totalUsers','totalOrders','totalDelivered','totalOnTheWay','totalStores'));
    }

    public function category()
    {
        $category = Category::all();
        $totalCategories=Category::all()->count();
        return view('admin.category', ['categories' => $category, 'total' => $totalCategories]);

    }

    public function add_category(Request $request)
    {
        try {
            $request->validate([
                'category_name' => 'required|string|max:255',
            ]);

            $category = new Category();
            $category->category_name = $request->category_name;
            $category->save();

            return response()->json([
                'success' => true,
                'category' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroyCategory($id)
    {
        try {
            $category = Category::findOrFail($id); // Find the category or throw a 404 exception
            $category->delete();


            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function edit($id)
    {
        $data = Category::find($id);
        return view('admin.edit', ['cat' => $data]);
    }

    public function update(Request $request, $id)
    {
        try {

            $data = Category::findOrFail($id);


            $request->validate([
                'category_name' => 'required|string|max:255',
            ]);


            $data->update([
                'category_name' => $request->category_name
            ]);


            return response()->json([
                'success' => true,
                'category' => $data,
                'message' => 'Category updated successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Category not found
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            // Other errors
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function stores ()
    {

    }

    public function addProduct()
    {
        $category = Category::all();
        return view('admin.addProduct', ['category' => $category]);
    }

    public function storeProduct(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'category' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->with_slider = $request->slider;

            // Handle the main product image
            if ($request->hasFile('image')) {
                $pro_image = $request->file('image');
                $newProductImageName = time() . '_' . $request->name . '.' . $pro_image->extension();
                $pro_image->move(public_path('productsImages'), $newProductImageName);
                $product->image = 'productsImages/' . $newProductImageName; // Corrected path
            }
            $product->save();


            if ($request->slider == 1 && $request->hasFile('images')) {
                $i = 1;
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $request->name . '_prodSlider_' . $i . '.' . $image->extension();
                    $image->move(public_path('productsImages'), $imageName);
                    $product->images()->create(['image_path' => 'productsImages/' . $imageName]);
                    $i++;
                }
            }

            flash()->timeout(3000)->success('Product added successfully');
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }




    public function viewProducts()
    {
        $totalProducts=Product::all()->count();
        $products = product::paginate(6);
        return view('admin.viewProducts', ['products' => $products,'total' => $totalProducts]);
    }



    public function productDestroy($id)
    {
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
        $orders=order::all();
        $total=order::all()->count();
        return view('admin.viewOrders',compact('orders','total'));
    }
    public function onTheWay($id)
    {
        $order=order::find($id)->update([
            'status'=>'On The Way'
        ]);


        return redirect()->back();
    }
    public function Delivered($id)
    {
      Order::find($id)->update([
          'status'=>'Delivered'
      ]);
        return redirect()->back();
    }
    public function canceled($id)
    {
     $order=Order::find($id)->update([
          'status'=>'Delivered'
      ]);

        return redirect()->back();
    }
    public function role()
    {
        $users=User::all();
        return view('admin.role',['users'=>$users]);
    }
    public function adminRole($id){
        User::find($id)->update([
            'is_admin'=>1
        ]);
        return redirect()->back();
    }
    public function userRole($id){
        User::find($id)->update([
            'is_admin'=>0
        ]);
        return redirect()->back();
    }
}

