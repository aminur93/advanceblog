<div class="col-xs-6">
    <div class="box">
        <div class="box-body ">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {!! Form::label('name') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}

                @if ($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                {!! Form::label('slug') !!}
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}

                @if ($errors->has('slug'))
                    <span class="help-block">{{ $errors->first('slug') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('bio') ? 'has-error' : '' }}">
                {!! Form::label('bio') !!}
                {!! Form::textarea('bio', null, ['rows' => 6 ,'class' => 'form-control']) !!}

                @if ($errors->has('bio'))
                    <span class="help-block">{{ $errors->first('bio') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                {!! Form::label('role') !!}
                @if ($user->exists && ($user->id == $user->roles->first()->id) || isset($hideRoleDropdown))
                     {!! Form::hidden('role', $user->roles->first()->id) !!}
                    <p class="form-control-static">{{ $user->roles->first()->display_name }}</p>
                    @else
                    {!! Form::select('role', App\Role::pluck('display_name', 'id') , $user->exists ? $user->roles->first()->id : null , ['class' => 'form-control', 'placeholder' => 'Chose a role']) !!}
                @endif
                {!! Form::select('role', App\Role::pluck('display_name', 'id') , $user->exists ? $user->roles->first()->id : null , ['class' => 'form-control', 'placeholder' => 'Chose a role']) !!}

                @if ($errors->has('role'))
                    <span class="help-block">{{ $errors->first('role') }}</span>
                @endif
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">{{ $user->exists ? 'Update' : 'Save' }}</button>
            <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </div>
    <!-- /.box -->
</div>

<div class="col-xs-6">
    <div class="box">
        <div class="box-body">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::label('email') !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}

                @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::label('password') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}

                @if ($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                {!! Form::label('password_confirmation') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }} text-center">
                <br>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="/img/{{ $user->image }}" alt="...">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <div>
                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span> {!! Form::file('image') !!}</span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                </div>

                @if ($errors->has('image'))
                    <span class="help-block">{{ $errors->first('image') }}</span>
                @endif
            </div>
        </div>

    </div>
</div>
