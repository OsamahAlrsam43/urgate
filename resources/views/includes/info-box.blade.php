@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert m-alert m-alert--default alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@elseif(session()->has('fail'))
    <div class="alert m-alert m-alert--default alert-danger" role="alert">
        {{ session()->get('fail') }}
    </div>
@elseif(session()->has('success'))
    <div class="alert m-alert m-alert--default alert-success" role="alert">
        {{session()->get('success') }}
    </div>
@endif