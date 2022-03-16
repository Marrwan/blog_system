


@extends('layouts.backend.app')

@section('title', 'Category')

@push('css')

    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>
            <a href="{{route('admin.category.create')}}" class="btn btn-primary waves-effect ">
                <i class="material-icons">add</i>
                <span>
                    Add New Category
                </span>
            </a>
        </h2>
    </div>

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL CATEGORY
                        <span class="badge bg-info">{{$categories->count()}}</span>
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Post Count</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Post Count</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>

                                </tr>
                            </tfoot>
                            <tbody>

                                @foreach($categories as $key=>$category)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->posts->count()}}</td>
                                        <td>{{$category->created_at}}</td>
                                        <td>{{$category->updated_at}}</td>
                                        <td class="text-center">
                                            <a class=" waves-effect" href="{{route('admin.category.edit', $category->id)}}"><i class="material-icons">edit</i></a>
                                            <button onclick="deleteCategory({{$category->id}})" style="border: none; background: none" class=" waves-effect"  type="submit" ><i class="material-icons " style="color: red">delete</i></button>

                                            <form id="delete-form-{{$category->id}}" style="display: none" method="POST" action="{{route('admin.category.destroy', $category->id)}}">
                                               @method('DELETE')
                                                @csrf
                                            </form>

                                        </td>
                                        <td>
                                            <img class="img-thumbnail" src="{{asset('storage/category/'.$category->image)}}"/>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>
@endsection

@push('js')
     <!-- Jquery DataTable Plugin Js -->
     <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
     <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
     <script src="{{asset('assets/backend//js/pages/tables/jquery-datatable.js')}}"></script>
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>


        function deleteCategory(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById(`delete-form-${id}`).submit();
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Tag has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush

