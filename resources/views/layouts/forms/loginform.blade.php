<div class="card w-25">
    <div class="card-header">
        {{$head}}
    </div>
    <div class="card-body">

        <form action="{{$route}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="float-left">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@mail.com" required>
                {!!$errors->first('email','<span class="error">:message</span>')!!}
            </div>

            <div class="form-group">
                <label for="password" class="float-left">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <input type="submit" class="btn btn-lg btn-success" value="Login">
        </form>

    </div>
</div>