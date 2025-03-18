<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index(){
        $items = Item::select('id','name','price','image')->get();
        return response(['data' => $items], 200);
    }
    public function store (Request $request)
    {
         $request->validate([
            'name' =>'required|max:100',
            'price' =>'required|integer',
            'image' =>'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $newName = null;  // default image name

        if($request->file('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $newName = $request->name . '-' . now()->timestamp . '.' . $extension;
            $file->storeAs('items', $newName, 'public');
            $request['image'] = $newName;
        }

        $data = array_merge(
        $request->only(['name', 'price']),
        ['image' => $newName]
    );
        $item = Item::create($data);

        return response(['data' => $item], 201);
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'name' =>'required|max:100',
            'price' =>'required|integer',
            'image' =>'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

            $item = Item::findOrFail($id);
            $newName = $item->image; 

         if($request->file('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $newName = $request->name . '-' . now()->timestamp . '.' . $extension;
            $file->storeAs('items', $newName, 'public');
            $request['image'] = $newName;
        }

        $data = array_merge(
        $request->only(['name', 'price']),
        ['image' => $newName]
        );
        $item->update($data);

        return response(['data' => $item], 201);
    
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response(['data' => $item], 200);
    }

   
}
