<table class="table table-bordered">
    <thead>
    <tr>
        <th>Action</th>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Slug</th>
        <th>Bio</th>
        <th>Role</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy',$user->id] ]) !!}
                <a href="{{ route('users.edit',$user->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>

                <button onclick="return confirm('Are you sure want to delete!!')" type="submit" class="btn btn-xs btn-danger">
                    <i class="fa fa-times"></i>
                </button>

                <a href="{{ route('backend.users.confirm',$user->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></a>

                {!! Form::close() !!}

            </td>
            <td><img src="/img/{{ $user->image }}" alt=""></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->slug }}</td>
            <td>{{ substr($user->bio,0,20) }}</td>
            <td>{{ $user->roles->first()->display_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>