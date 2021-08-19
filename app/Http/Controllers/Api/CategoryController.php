<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\GerenalApi;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use GerenalApi;

    public function index()
    {
        $categories = Category::get_category()->active()->get();

        return $this->sendResponse(true, 'show all categories', $categories, 200);

//        return $this->sendResponse('categories', $categories);
    }

    public function store(Request $request)
    {

        $category = Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'active' => $request->active,
        ]);

        $category->save();

//        $category = new CategoryResource($category);

        return $this->sendResponse(true, 'add new category', $category, 200);

    }

    public function update(Request $request)
    {

        $category = Category::get_category()->where('id', $request->id)->first();

        if (!$category) {
            return $this->sendResponse(false, 'category not found', '', 404);
        }
        $updateCategory = $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'active' => $request->active,
            ]);

        $category = new CategoryResource($category);


        return $this->sendResponse(true, 'update success', $category, 200);

    }

    public function show(Request $request)
    {

        $category = Category::get_category()->where('id', $request->id)->first();

        $category = new CategoryResource($category);

        if (!$category) {
            return $this->sendResponse(false, 'category not found', '', 404);
        }

        return $this->sendResponse(true, 'show success', $category, 200);

    }

    public function destroy(Request $request)
    {

        $category = Category::where('id', $request->id)->delete();

        if (!$category) {
            return $this->sendResponse(false, 'category not found', '', 404);
        }

        return $this->sendResponse(true, 'delete successfully', $category, 200);

    }

    public function changeStatus(Request $request)
    {

        $category = Category::where('id', $request->id)
            ->update(['active' => $request->active]);

        if (!$category) {
            return $this->sendResponse(false, 'category not found', '', 404);
        }

        return $this->sendResponse(true, 'change active success', $category, 200);

    }
}
