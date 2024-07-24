<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
        ]);
        $attributeNames = [
            'title' => 'Category Name',

        ];
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $cat = Category::create([
                'name' => $request->title,
            ]);

            if ($cat) {

                return back()->with('success', 'Category added succefully');
            } else {

                return back()->with('error', 'Thera is an error has occured');
            }
        }
    }

    public function edit(Category $cat)
    {
        $category = Category::find($cat->id);
        return view('edit_cat', compact('category'));
    }

    public function update(Request $request, Category $cat)
    {
        $update = $cat->update([
            'name' => $request->title,
        ]);
        if ($update) {

            return back()->with('success', 'Category Updated succefully');
        } else {

            return back()->with('error', 'Thera is an error has occured');
        }
    }

    public function destroy(Category $cat)
    {
        $delete = $cat->delete();
        if ($delete) {
            $tasks = Task::where('category_id', $cat->id)->delete();

            return back()->with('success', 'Category deleted succefully');
        } else {

            return back()->with('error', 'Thera is an error has occured');
        }
    }
}
