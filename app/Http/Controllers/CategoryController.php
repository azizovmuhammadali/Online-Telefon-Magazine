<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('images','phones.images')->paginate(10);
        return $this->success(CategoryResource::collection($categories), __("messages.category_all"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        if (!auth()->check() || auth()->user()->status !== 'admin') {
            return $this->error(__('messages.admin'), 403); 
        }
        $category = Category::create([
            "title" => $request->title,
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'categories');
        }
        $category->images()->create([
            'image'=> $imagePath,
          ]); 
        return $this->success([new CategoryResource($category->load('images'))], __('messages.category_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return $this->success([new CategoryResource($category->load('images','phones.images'))], __('messages.category_show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($category->image) {
                $this->deleteImage($category->image);
            }
            $category->image = $this->uploadImage($request->file('image'), 'categories');
        }
        $category->title = $request->title ?? $category->title;
        $category->save();

        return $this->success(
            [new CategoryResource($category->load('images'))],
            __('messages.category_updated')
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->success([], __('messages.category_deleted'), 204);
    }
}
