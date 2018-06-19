<?php

/**
 * 
 * @author Sam Achola <sam.achola@live.com>
 * 
 */
namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

/**
 * Categories controllers class to handle all
 * category functions.
 * 
 * @category Controller
 */
class CategoriesController extends Controller
{
    /**
     * Request instance
     * 
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * New controller instance
     * 
     * @param Request $request - Request object
     * 
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a new category
     * 
     * @return {Object}
     */
    public function createCategory()
    {
        $this->validate($this->request, Categories::$rules);

        $newCategory = Categories::create(
            [
                'name' => $this->request->name,
                'description' => $this->request->description
            ]
        );
        return response()->json($newCategory, 201);
    }

    /**
     * Get all categories
     * 
     * @return [Array] - An list of all categories
     */
    public function getAllCategories()
    {
        $categories = Categories::all();

        return response($categories, 200);
    }

    /**
     * Update Single Category
     * 
     * @param integer $id - Category ID
     * 
     * @return {Object}
     */
    public function updateCategory($id)
    {
        $this->validate($this->request, Categories::$rules);
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message'=> 'Category not found'], 400);
        }

        $category->name = $this->request->name;
        $category->description = $this->request->description;

        $category->save();

        return response()->json($category, 201);

    }

    /**
     * Delete single category.
     * 
     * @param integer $id - Category ID
     * 
     * @return {Object}
     */
    public function deleteCategory($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 400);
        }

        $category->delete();
        return response()->json(['message' => 'Category successfully deleted'], 201);
    }

}