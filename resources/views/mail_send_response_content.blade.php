@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@elseif(isset($status))
    <div class="alert alert-success">
        {{ $status }}
    </div>
@endif