@extends('layouts.backend.main')

@section('title','MyBlog | Categories')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Categories
                <small>Display All Categories</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                <li class="action">All Categories</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header clearfix">
                            <div class="pull-left">
                                <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add New</a>
                            </div>
                            <div class="pull-right" style="padding: 7px 0px;">

                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            @include('backend.partials.message')

                            @if (! $categories->count())

                                <div class="alert alert-danger">
                                    <strong>No record found</strong>
                                </div>
                            @else
                                @include('backend.categories.table')
                            @endif
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <ul class="pagination no-margin">
                                    {{ $categories->appends( Request::query())->render() }}
                                </ul>
                            </div>

                            <div class="pull-right">
                                <small>{{ $categoriesCount }} {{ str_plural('Items',$categoriesCount) }}</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('js')
    <script type="text/javascript">
        $('ul.pagination').addClass('no-margin pagination-sm');
    </script>
    @endpush
