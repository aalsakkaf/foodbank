<?php

namespace App\Http\Controllers;
use App\Status;
use App\FoodCategory;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    public function showAllStatus()
    {
       $all = Status::all();
        return view('status.index', ['all' => $all]);
    }
    public function createStatus()
    {
        return view('status.create');
    }

    public function storeStatus(Request $request)
    {
        $status = new Status;
        $status->name = $request->name;
        $status->save();

        return redirect()->route('status.index')->with('status', 'The category has been created!');
    }

    public function showStatus($id)
    {
        $status = Status::whereId($id)->firstOrFail();
        return view('status.singleStatus', ['status' => $status]);
    }

    public function editStatus($id)
    {
        $status = Status::whereId($id)->firstOrFail();
        return view('status.edit', ['status' => $status]);
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $status = Status::whereId($id)->firstOrFail();
        $status->name = $request->name;
        $status->save();
        return redirect()->route('status.index')->with('status', 'The status has been updated!');
    }

    public function destroyStatus($id)
    {
        Status::destroy($id);
        return redirect()->route('status.index')->with('status', 'The status has been deleted!');

    }

    public function showAllCategory()
    {
       $all = FoodCategory::all();
        return view('category.index', ['all' => $all]);
    }
    public function createCategory()
    {
        return view('category.create');
    }

    public function storeCategory(Request $request)
    {
        $category = new FoodCategory;
        $category->name = $request->name;
        //$category->user_id = $request->user()->id; // returns authenticated user id. 

        $category->save();

        return redirect()->route('category.index')->with('status', 'The category has been created!');
    }

    public function showCategory($id)
    {
        $category = FoodCategory::whereId($id)->firstOrFail();
        return view('category.singleCategory', ['status' => $category]);
    }

    public function editCategory($id)
    {
        $category = FoodCategory::whereId($id)->firstOrFail();
        return view('category.edit', compact('category')); 
    }

    public function updateCategory(Request $request)
    {
        $id = $request->id;
        $category = FoodCategory::whereId($id)->firstOrFail();
        $category->name = $request->name;
        //$category->user_id = $request->user()->id; // returns authenticated user id. 
        $category->save();
        return redirect('/category')->with('status', 'Category updated!');
    }

    public function destroyCategory($id)
    {
        FoodCategory::destroy($id);
        return redirect()->route('category.index')->with('status', 'The category has been deleted!');

    }
}
