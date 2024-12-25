<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $this->success([CategoryResource::collection($categories)],__("messages.category_all"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'categories');
        }
        $category = Category::create([
            "title"=> $request->title,
            'image' => $imagePath,
        ]);
        return $this->success([new CategoryResource($category)],__('messages.category_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return $this->success([new CategoryResource($category)],__('messages.category_show'));
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
            [new CategoryResource($category)],
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
        return $this->success([],__('messages.category_deleted'),204);
    }
}
