<div class="card w-25">
    <div class="card-header">
        {{$head}}
    </div>
    <div class="card-body">

        <form action="{{$route}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="float-left">Name</label>
                <input type="text" name="name" class="form-control {{$errors->has('name') ? ' is-invalid' : ''}}" value="{{old('name')}}" placeholder="name" required autofocus>
                {!!$errors->first('name','<span class="error invalid-feedback">:message</span>')!!}
            </div>

            <div class="form-group">
                <label for="email" class="float-left">Email</label>
                <input type="email" name="email" class="form-control {{$errors->has('email') ? ' is-invalid' : ''}}" value="{{old('email')}}" placeholder="email@mail.com" required>
                {!!$errors->first('email','<span class="error invalid-feedback">:message</span>')!!}
            </div>

            <div class="form-group">
                <label for="password" class="float-left">Password</label>
                <input type="password" name="password" class="form-control {{$errors->has('password') ? ' is-invalid' : ''}}" value="{{old('email')}}" required>
                {!!$errors->first('password','<span class="error invalid-feedback">:message</span>')!!}
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="float-left {{$errors->has('password') ? ' is-invalid' : ''}}" value="{{old('email')}}">Password Confirm</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <input type="submit" class="btn btn-lg btn-success" value="Login">
        </form>

    </div>
</div>