@if($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success" role="alert">
        <li>{{session('success')}}</li>
    </div>
@endif

<div id="js-errors">

</div>