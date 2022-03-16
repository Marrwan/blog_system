


@extends('layouts.backend.app')

@section('title', 'Tag')

@push('css')

    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>
            <a href="{{route('admin.tag.create')}}" class="btn btn-primary waves-effect ">
                <i class="material-icons">add</i>
                <span>
                    Add New Tag
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
                        ALL TAGS
                        <span class="badge bg-info">{{$tags->count()}}</span>
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

                                @foreach($tags as $key=>$tag)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$tag->name}}</td>
                                        <td>{{$tag->posts->count()}}</td>
                                        <td>{{$tag->created_at}}</td>
                                        <td>{{$tag->updated_at}}</td>
                                        <td class="text-center">
                                            <a class=" waves-effect" href="{{route('admin.tag.edit', $tag->id)}}"><i class="material-icons">edit</i></a>
                                            <button onclick="deleteTag({{$tag->id}})" style="border: none; background: none" class=" waves-effect"  type="submit" ><i class="material-icons " style="color: red">delete</i></button>

                                            <form id="delete-form-{{$tag->id}}" style="display: none" method="POST" action="{{route('admin.tag.destroy', $tag->id)}}">
                                               @method('DELETE')
                                                @csrf
                                            </form>

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


        function deleteTag(id){
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

