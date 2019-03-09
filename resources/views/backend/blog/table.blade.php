<table class="table table-bordered">
    <thead>
    <tr>
        <th>Action</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php $request = request();?>
    @foreach($posts as $post)
        <tr>
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy',$post->id] ]) !!}
                @if (check_user_permissions($request, "Blog@edit", $post->id))
                    <a href="{{ route('blog.edit',$post->id) }}" class="btn btn-xs btn-default">
                        <i class="fa fa-edit"></i>
                    </a>
                    @else

                    <a href="#" class="btn btn-xs btn-default" disabled="">
                        <i class="fa fa-edit"></i>
                    </a>
                @endif

                @if (check_user_permissions($request, "Blog@destroy", $post->id))
                    <button type="submit" class="btn btn-xs btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                    @else

                    <button class="btn btn-xs btn-danger" disabled>
                        <i class="fa fa-trash"></i>
                    </button>
                @endif

                {!! Form::close() !!}

            </td>
            <td>{{ str_limit($post->title,30) }}</td>
            <td>{{ $post->author->name }}</td>
            <td>{{ $post->category->title }}</td>
            <td>
                <abbr title="{{ $post->dateFormatted(true) }}">{{ $post->dateFormatted() }}</abbr> |
                {!! $post->publicationLabel()  !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>