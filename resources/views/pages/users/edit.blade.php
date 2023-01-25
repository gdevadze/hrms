@extends('layouts.app')


@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">

                        <div class="iq-card-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                {!! Form::model($user, ['method' => 'PATCH','url' => ['/staff_info.blade/'.$user->id.'/update']]) !!}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <strong>სახელი:</strong>
                                        {!! Form::text('name', null, array('placeholder' => 'სახელი','class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <strong>გვარი:</strong>
                                        {!! Form::text('lastname', null, array('placeholder' => 'გვარი','class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <strong>მომხმარებლის სახელი:</strong>
                                        {!! Form::text('username', null, array('placeholder' => 'ელ. ფოსტა','class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <strong>მობილურის ნომერი:</strong>
                                        {!! Form::text('tel', null, array('placeholder' => 'ელ. ფოსტა','class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-6">
                                        <strong>პაროლი:</strong>
                                        {!! Form::password('password', array('placeholder' => 'პაროლი','class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-6">
                                        <strong>პაროლის დადასტურება:</strong>
                                        {!! Form::password('confirm-password', array('placeholder' => 'პაროლის დადასტურება','class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-12">
                                        <strong>პრივილეგია:</strong>
                                        {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary mb-2">განახლება</button>
                                    </div>

                                    {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
