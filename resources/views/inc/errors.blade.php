@if($errors->any())
    <div class="alert alert-danger alert-dismissable fade show" role="alert">
        @foreach($errors->all() as $error)
                <li @if(!$loop->first) class="mt-1" @endif>
                
                    @if($loop->first)
                        <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endif

                    <div class="d-inline">{{ $error }}</div>
                </li>
        @endforeach
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissable fade show" role="alert">
        <li>
            {{session('success')}}

            <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </li>
    </div>
@endif

<div id="js-errors">

</div>