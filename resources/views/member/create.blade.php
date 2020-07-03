@extends('layouts.app')

@section('content')
<div class="container-fluid">

<div class="row align-items-center justify-content-center">
<a style="margin: 19px;" href="{{ route('member.index')}}" class="btn btn-secondary">< Back</a>

<div class="card">
 <div class="card-header">
    <h2>Create Member</h2>

  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
    <div class="card-body">
      <form method="post" action="{{ route('member.store') }}">
          @csrf
          <div class="form-group">    
              <label for="first_name">Name:</label>
              <input type="text" class="form-control" name="name"/>
          </div>
        
          <button type="submit" class="btn btn-primary btn-block">Add Member</button>
      </form>
      </div>
  </div>
</div>
</div>
</div>
</div>
@endsection