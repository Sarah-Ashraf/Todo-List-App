<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    break;
            }
        }

        $tasks = $query->get();
        $categories = Category::all();
        $trashed = Task::onlyTrashed()->get();

        return view('home', compact('tasks', 'categories', 'trashed'));
    }

    public function add()
    {
        // $tasks = Task::with('category')->paginate(10);
        // $trashed = Task::onlyTrashed()->paginate(10);
        $categories = Category::get();
        return view('add_task', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat' => 'required|string',
            'title' => 'required|string',
            'desc' => 'required|string',
            'status' => 'required|string',
        ]);
        $attributeNames = [
            'cat' => 'Category',
            'title' => 'Title',
            'desc' => 'Describtion',
            'status' => 'Status',

        ];
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $task = Task::create([
                'category_id' => $request->cat,
                'title' => $request->title,
                'description' => $request->desc,
                'status' => $request->status,
                'due_date' => $request->due_date,
            ]);

            if ($task) {

                return redirect('/home')->with('success', 'Task added succefully');
            } else {

                return back()->with('error', 'Thera is an error has occured');
            }
        }
    }

    public function edit(Task $task)
    {
        $task = Task::with('category')->find($task->id);
        $categories = Category::get();
        return view('edit_task', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $update = $task->update([
            'category_id' => $request->cat,
            'title' => $request->title,
            'description' => $request->desc,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);
        if ($update) {

            return back()->with('success', 'Task Updated succefully');
        } else {

            return back()->with('error', 'Thera is an error has occured');
        }
    }

    public function destroy(Task $task)
    {
        $delete = $task->delete();
        if ($delete) {

            return back()->with('success', 'Task deleted succefully');
        } else {

            return back()->with('error', 'Thera is an error has occured');
        }
    }

    public function restore(Task $task)
    {
        // $restore = $task->restore();
        // if ($restore) {

        //     return back()->with('success', 'Task resored succefully');
        // } else {

        //     return back()->with('error', 'Thera is an error has occured');
        // }

        // dd($task);
        $task = Task::withTrashed()->find($task->id);
        if ($task) {
            $task->restore();
            return redirect()->back()->with('success', 'Task restored successfully.');
        }

        return redirect()->back()->with('error', 'Task not found.');
    }

    // app/Http/Controllers/HomeController.php

    // app/Http/Controllers/HomeController.php

    public function filterTasks(Request $request)
    {
        $status = $request->input('status');
        $query = Task::query();

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->paginate(10); // 10 items per page
        $categories = Category::all();
        $trashed = Task::onlyTrashed()->get();
        return view('home', compact('tasks','trashed', 'categories'));
    }

    public function searchTasks(Request $request)
    {
        $searchTerm = $request->input('search');
        $query = Task::query();

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $tasks = $query->paginate(10); // 10 items per page
        $categories = Category::all();
        $trashed = Task::onlyTrashed()->get();

        return view('home', compact('tasks','trashed', 'categories'));
    }
}
