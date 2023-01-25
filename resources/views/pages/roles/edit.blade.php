@extends('layouts.app')


@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::model($role, ['method' => 'PATCH','url' => ['/roles/'.$role->id.'/update']]) !!}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <strong>სახელი:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <strong>უფლებები:</strong>
                            <br/>
                            @foreach($permission as $key => $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                    {{ str_replace('-',' ',ucfirst($value->name)) }}</label>
                                <br/>
                            @endforeach
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">განახლება</button>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
