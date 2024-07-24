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
                        <h5 class="box-title text-capitalize">Add New Category</h5>
                    </div>
                    <div class="row card-body">
                        <div class="col-12">
                            <form action="{{ route('store_cat') }}" method="POST" class="form-inline"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3 row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label for="title" class="col-sm-1 col-form-label">Name</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="title" class="form-control" value=""
                                                    id="title">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>





                                <div class="col-12  d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-success mt-10">Add Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">

                <table class="table text-center">
                    <thead>
                        <tr class="table-info">

                            <th scope="col">Name</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$categories->isEmpty())
                            @foreach ($categories as $cat)
                                <tr>
                                    <td>
                                        {{ $cat->name }}
                                    </td>
                                    <td>

                                        <a href="{{ route('edit_cat', $cat->id) }}">
                                            <i class="btn btn-icon btn-success fa-solid fa-pen"></i>
                                        </a>

                                        <a href="" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal1{{ $cat->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete">
                                            <i class="btn btn-icon btn-danger fa-solid fa-trash-can"></i>
                                        </a>
                                        {{-- popoup modal for delete --}}
                                        <div class="modal fade" id="exampleModal1{{ $cat->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Delete Category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this category ?
                                                    </div>
                                                    <div class="modal-footer text-end">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a type="button" href="{{ route('delete_cat', $cat->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- popoup modal for delete --}}



                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align: center">
                                    There are no tasks yet
                                </td>
                            </tr>
                        @endif



                    </tbody>
                </table>
            </div>

        </div>
    @endsection
