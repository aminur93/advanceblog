<table class="table table-bordered">
    <thead>
    <tr>
        <th>Action</th>
        <th>Category Name</th>
        <th>Post Count</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['categories.destroy',$category->id] ]) !!}
                <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>

                <button onclick="return confirm('Are you sure want to delete!!')" type="submit" class="btn btn-xs btn-danger">
                    <i class="fa fa-times"></i>
                </button>

                {!! Form::close() !!}

            </td>
            <td>{{ $category->title }}</td>
            <td>{{ $category->posts->count() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>