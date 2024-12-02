<?php

namespace app\Http\Controllers;

use App\Models\Category;
use App\Models\stores;

class StoreController extends Controller
{
    private $stores;
    private $count;
    private $category;
    public function __construct()
    {
        $this->stores = stores::all();
        $this->count = count($this->stores);
        $this->category = category::all();
    }
    public function index(){
        return view('admin.storesIndex',['stores'=>$this->stores,'count'=>$this->count]);
    }
    public function addStore(){
        return view('admin.addStore',['stores'=>$this->stores,'category'=>$this->category]);
    }
    public function pushStore()
    {

        $validated = request()->validate([
            "name" => "required|string",
            "address" => "required|string",
            "phone" => "required|numeric",
            "email" => "required|email",
            "description" => "required|string",
            "category" => "required|string",
            "image" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);


        if (request()->hasFile('image')) {
            $imageName= time()."_".$validated['name'].".".request()->file('image')->getClientOriginalExtension();
            request()->file('image')->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }


        $store = new stores();
        $store->name = $validated['name'];
        $store->address = $validated['address'];
        $store->phone = $validated['phone'];
        $store->email = $validated['email'];
        $store->description = $validated['description'];
        $store->categories = $validated['category'];
        $store->icon = $validated['image'];
        $store->save();

        return to_route("admin.stores")->with('success', 'Store added successfully!');
    }

public function storeDestroy($id)
{
    try {
        $store = stores::find($id);
        if ($store) {
            unlink(public_path('images/' . $store->icon));
            $store->delete();

            return to_route("admin.stores")->with('success', "store deleted successfully!");
        }
    } catch (\Exception $exception) {
        return to_route("admin.stores")->with('error', $exception->getMessage());
    }
}
}
