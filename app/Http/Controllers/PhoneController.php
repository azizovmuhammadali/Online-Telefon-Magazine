<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneUpdateRequestRequest;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PhoneResource;
use App\Http\Requests\PhoneStoreRequest;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phone = Phone::with('user.images','images','category.images','comments')->paginate(10);
        return $this->responsePagination($phone, PhoneResource::collection($phone),__('messages.phone_all'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhoneStoreRequest $request)
    {
        $phone = Phone::create([
            'name' => $request->name,
            'model' => $request->model,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'user');
        }
        $phone->images()->create([
          'image'=> $imagePath,
        ]); 
        return $this->success( new PhoneResource($phone->load('user.images','images','category.images',)),__('messages.phone_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $phone = Phone::findOrFail($id);
       return $this->success( new PhoneResource($phone->load('user.images','images','category.images','comments')),__('messages.phone_show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PhoneUpdateRequestRequest $request, string $id)
    {
        $phone = Phone::findOrFail($id);
        $phone = Phone::findOrFail($id);
        if(Auth::id() !== $phone->user_id){
            return $this->error(__('messages.phone_notfound'));
        }
        $phone->name = $request->name;
        $phone->model = $request->model;
        $phone->price = $request->price;
        $phone->description = $request->description;
        $phone->user_id = Auth::id();
        $phone->category_id = $request->category_id;
        $phone->save();
        return $this->success( new PhoneResource($phone->load('user.images','images','category.images')),__('messages.phone_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $phone = Phone::findOrFail($id);
       $phone->delete();
       return $this->success([],__('messages.deleted'));
    }
}
