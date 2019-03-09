@extends('layouts.backend.main')

@section('title','MyBlog | Add New Catgeory')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Catgeory
                <small>Add new Category</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li><a href="{{ route('categories.index') }}">Category</a></li>
                <li class="action">Add new</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                {!! Form::model($category, [
                   'method' => 'post',
                   'route' => 'categories.store',
                   'id' => 'category-form'
                 ]) !!}
                 @include('backend.categories.form')
                {!! Form::close() !!}
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@include('backend.categories.script')
