@extends('layouts.backend.app')

@section('title', 'Create')

@push('css')

@endpush

@section('content')

<div class="container-fluid">
    <div class="block-header">
        <h2></h2>
    </div>


    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ADD NEW CATEGORY

                    </h2>

                </div>
                <div class="body">
                    <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="name" name="name"  class="form-control">
                                <label class="form-label">Category Name</label>
                            </div>

                        </div>
                        <div class="form-group">
                            <input type="file" id="image" name="image"  class="form-control">
                            {{--                                <label class="form-label">Category Image</label>--}}
                        </div>

                        <br>
                        <a href="{{route('admin.category.index')}}" class="btn btn-danger m-t-15 waves-effect">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SAVE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->

    <!-- #END# Multi Column -->
</div>
@endsection

@push('js')

@endpush
