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
                    <div class="card-header" style="background-color: rgba(172, 247, 172, 0.397)">
                        <h5 class="box-title text-capitalize">Edit Task : <b>{{ $task->title }}</b></h5>
                    </div>
                    <div class="row card-body">
                        <div class="col-12">
                            <form action="{{ route('update', ['task' => $task->id]) }}" method="POST" class="form-inline"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3 row">
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ $task->title }}" id="title">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label for="cat" class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" id="cat" name="cat">
                                                    <option value ="" selected>Choose...</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            @if ($task->category_id == $cat->id) selected @endif>
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cat')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <div class="row">
                                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" id="status" name="status">
                                                    <option value="" selected>Choose...</option>
                                                    <option value="Pending"
                                                        @if ($task->status == 'Pending') selected @endif>Pending</option>
                                                    <option value="Completed"
                                                        @if ($task->status == 'Completed') selected @endif>Completed</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <div class="row">
                                            <label for="title" class="col-sm-2 col-form-label">Due Date</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="due_date" class="form-control"
                                                    value="{{ $task->due_date }}" id="title">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3 row">
                                    <label for="desc" class="col-sm-1 col-form-label">Describtion</label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control" id="desc" name="desc"> {{ $task->description }}</textarea>
                                        @error('desc')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12  d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-success mt-10">Edit Task
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    @endsection
