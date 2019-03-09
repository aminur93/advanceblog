@extends('layouts.backend.main')

@section('title','MyBlog | Edit Users')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>Edit Users</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li class="action">Edit Users</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                {!! Form::model($user, [
                   'method' => 'PUT',
                   'route' => ['users.update',$user->id],
                   'files' => TRUE,
                   'id' => 'category-form'
                 ]) !!}
                 @include('backend.users.form')
                {!! Form::close() !!}
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@include('backend.users.script')
