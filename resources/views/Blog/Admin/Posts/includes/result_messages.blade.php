@if($errors->any())
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $errorTxt)
                        <li> {{$errorTxt}} </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="alert alert-success" role="alert">

                {{session()->get('success')}}
            </div>
        </div>
    </div>
@endif
