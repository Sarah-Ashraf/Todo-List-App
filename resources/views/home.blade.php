@extends('layouts.app')

@section('content')
    <style>
        a {
            text-decoration: none;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background-color: rgba(172, 247, 172, 0.397)">
                        <h5 class="box-title text-capitalize mb-0">Search</h5>
                        <a href="{{ route('add') }}" class="btn btn-success">Add Task</a>
                    </div>

                    <div class="row card-body">
                        <div class="col-12 ">
                            <!-- Search Form -->
                            <form action="{{ route('search') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label for="sort">Search Tasks:</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search tasks..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="d-flex justify-content-end">

                                    <button type="submit" class="btn btn-success mt-2">Search</button>
                                </div>
                            </form>

                            <!-- Filter Form -->
                            <form action="{{ route('filter') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label for="status">Filter by Status:</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="">All</option>
                                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success mt-2">Filter</button>
                                </div>
                            </form>

                            <!-- Sort Form -->
                            <form action="{{ route('home') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label for="sort">Sort by:</label>
                                    <select id="sort" name="sort" class="form-select">
                                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                                            Title (A-Z)</option>
                                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                                            Title (Z-A)</option>
                                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date
                                            (Newest first)</option>
                                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>
                                            Date (Oldest first)</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success mt-2">Sort</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-6 table-responsive">
                <h4>Real Data</h4>
                <table id="tasksTable" class="table  text-center">
                    <thead>
                        <tr class="table-info">

                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$tasks->isEmpty())
                            @foreach ($tasks as $task)
                                <tr>

                                    <td>{{ $task->title }}</td>
                                    <td>
                                        @php
                                            if ($task->category_id) {
                                                echo $catName = App\Models\Category::where(
                                                    'id',
                                                    $task->category_id,
                                                )->first()->name;
                                            } else {
                                                echo '--';
                                            }
                                        @endphp
                                    </td>

                                    <td>{{ $task->description }}</td>
                                    <td>
                                        @if ($task->due_date)
                                            {{ $task->due_date }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>{{ $task->status }}</td>
                                    <td>

                                        <a href="{{ route('edit', $task->id) }}" title="Edit Task">
                                            <i class="btn btn-icon btn-success fa-solid fa-pen"></i>
                                        </a>

                                        <a href="" data-bs-toggle="modal" title="Delete Task"
                                            data-bs-target="#exampleModal1{{ $task->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                            <i class="btn btn-icon btn-danger fa-solid fa-trash-can"></i>
                                        </a>
                                        {{-- popoup modal for delete --}}
                                        <div class="modal fade" id="exampleModal1{{ $task->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Delete Task</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this task ?
                                                    </div>
                                                    <div class="modal-footer text-end">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a type="button" href="{{ route('delete', $task->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- popoup modal for delete --}}





                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align: center">
                                    There are no tasks yet
                                </td>
                            </tr>
                        @endif



                    </tbody>
                </table>

            </div>
            <div class="col-6 table-responsive">
                <h4>Trashed Data</h4>
                <table id="tasksTable" class="table text-center">
                    <thead>
                        <tr class="table-info">

                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$trashed->isEmpty())
                            @foreach ($trashed as $trash)
                                <tr>

                                    <td>{{ $trash->title }}</td>
                                    <td>
                                        @php
                                            if ($trash->category_id) {
                                                echo $catName = App\Models\Category::where(
                                                    'id',
                                                    $trash->category_id,
                                                )->first()->name;
                                            } else {
                                                echo '--';
                                            }
                                        @endphp
                                    </td>

                                    <td>{{ $trash->description }}</td>
                                    <td>
                                        @if ($trash->due_date)
                                            {{ $trash->due_date }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>{{ $trash->status }}</td>
                                    <td>


                                        {{-- popoup modal for delete --}}

                                        <!-- Restore Button Trigger -->
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal3{{ $trash->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Restore">
                                            <i class="btn btn-icon btn-info fa-solid fa-rotate"></i>
                                        </a>

                                        <!-- Popup Modal for Restore -->
                                        <div class="modal fade" id="exampleModal3{{ $trash->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel3" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel3">Restore Task</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to restore this task?
                                                    </div>
                                                    <div class="modal-footer text-end">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form action="{{ route('restore', ['task' => $trash->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-danger">Restore</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align: center">
                                    There are no tasks yet
                                </td>
                            </tr>
                        @endif



                    </tbody>
                </table>

            </div>

        </div>
    @endsection
