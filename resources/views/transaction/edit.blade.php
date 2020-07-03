@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="row align-items-center justify-content-center">
<a style="margin: 19px;" href="{{ route('member.index')}}" class="btn btn-secondary">< Back</a>

<div class="card">
    <div class="card-header">
        <h2>Update Member</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br /> 
        @endif
    </div>    
        <div class="card-body">
        <form method="post" action="{{ route('member.update', $member->id) }}">
            @method('PATCH') 
            @csrf
            <div class="form-group">

                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value={{ $member->Name }} />
            </div>

            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
    </div>
</div>
</div>
</div>
@endsection