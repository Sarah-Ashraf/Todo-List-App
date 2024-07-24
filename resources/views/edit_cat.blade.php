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
                        <h5 class="box-title text-capitalize">Edit Category : <b>{{ $category->name }}</b></h5>
                    </div>
                    <div class="row card-body">
                        <div class="col-12">
                            <form action="{{ route('update_cat', ['cat' => $category->id]) }}" method="POST"
                                class="form-inline" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3 row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label for="title" class="col-sm-1 col-form-label">Name</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ $category->name }}" id="title">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>





                                <div class="col-12  d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-success mt-10">Edit Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endsection
