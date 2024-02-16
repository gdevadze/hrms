@extends('layouts.app')
@section('title','უფლებები')
@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">

                        <div class="iq-card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <button type="submit" onclick="window.location.href = '{{ url('/roles/create') }}'" class="btn light btn-primary mb-2"><i
                                    class="fa fa-plus mr-2" aria-hidden="true"></i>დამატება
                            </button>
                            <div class="table-responsive">
                                <table class="table" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>სახელი</th>
                                        <th width="280px">ქმედება</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                            <!--<a class="btn btn-info shadow btn-xs sharp mr-1" href="{{ url(currentLocale().'/roles/'.$role->id.'/show') }}"><i class="fa fa-eye"></i></a>-->
                                            <!--{{--                                            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>--}}-->
                                                @can('role-edit')
                                                    <a class="btn btn-primary shadow btn-xs sharp mr-1" href="{{ url('/roles/'.$role->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                                    {{--                                                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>--}}
                                                @endcan
                                                @can('role-delete')
                                                    <button type="submit" onclick="deleteUser({{ $role->id }})" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>სახელი</th>
                                        <th width="280px">ქმედება</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

{{--    <div class="main-content">--}}
{{--        <!-- Start row -->--}}
{{--        <div class="row">--}}
{{--            <!-- Start col -->--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="card m-b-30">--}}
{{--                    <div class="card-header">--}}
{{--                        @if ($message = Session::get('success'))--}}
{{--                            <div class="alert alert-success alert-block">--}}
{{--                                <button type="button" class="close" data-dismiss="alert">×</button>--}}
{{--                                <strong>{{ $message }}</strong>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <button type="submit" onclick="window.location.href = '{{ url('/roles/create') }}'" class="btn light btn-primary mb-2"><i--}}
{{--                                class="fa fa-plus mr-2" aria-hidden="true"></i>დამატება--}}
{{--                        </button>--}}

{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        --}}{{--                    <h6 class="card-subtitle">With DataTables you can alter the ordering characteristics of the table at initialisation time.</h6>--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table table-bordered">--}}
{{--                                <tr>--}}
{{--                                    <th>#</th>--}}
{{--                                    <th>სახელი</th>--}}
{{--                                    <th width="280px">ქმედება</th>--}}
{{--                                </tr>--}}
{{--                                @foreach ($roles as $key => $role)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $key+1 }}</td>--}}
{{--                                        <td>{{ $role->name }}</td>--}}
{{--                                        <td>--}}
{{--                                            <!--<a class="btn btn-info shadow btn-xs sharp mr-1" href="{{ url(currentLocale().'/roles/'.$role->id.'/show') }}"><i class="fa fa-eye"></i></a>-->--}}
{{--<!----}}{{--                                            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>--}}{{---->--}}
{{--                                            @can('role-edit')--}}
{{--                                                <a class="btn btn-primary shadow btn-xs sharp mr-1" href="{{ url(currentLocale().'/roles/'.$role->id.'/edit') }}"><i class="fa fa-edit"></i></a>--}}
{{--                                                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>--}}
{{--                                            @endcan--}}
{{--                                            @can('role-delete')--}}
{{--                                                <button type="submit" onclick="deleteUser({{ $role->id }})" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>--}}
{{--                                            @endcan--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            </table>--}}


{{--                            {!! $roles->render() !!}--}}
{{--                            --}}{{--                            {!! $data->render() !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- End col -->--}}
{{--            <!-- Start col -->--}}
{{--            <!-- End col -->--}}
{{--        </div>--}}
{{--        <!-- End row -->--}}
{{--    </div>--}}
    <script>
        function deleteUser(id) {
            Swal.fire({
                title: 'ნამდვილად გსურთ როლის წაშლა?',
                text: "",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'დიახ!',
                cancelButtonText: 'არა!',
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $('.swal2-confirm').html('<i class="fa fa-spinner fa-spin mr-1"></i>');
                        $.ajax({
                            url: "{{ url(currentLocale().'/roles/delete_role') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': id
                            },
                        })
                            .done(function (response) {
                                if (response.status === 1) {
                                    Swal.fire({
                                        title: 'წარმატებული!',
                                        text: "როლი წარმატებით წაიშალა",
                                        icon: 'success',
                                        showCancelButton: false
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload()
                                        }
                                    })
                                } else {
                                    Swal.fire('შეცდომა!', 'სცადეთ მოგვიანებით', 'error');
                                }
                            })
                            .fail(function () {
                                Swal.fire('შეცდომა!', 'სცადეთ მოგვიანებით', 'error');
                            });
                    });
                },
                allowOutsideClick: true
            });
        }
    </script>
@endsection
