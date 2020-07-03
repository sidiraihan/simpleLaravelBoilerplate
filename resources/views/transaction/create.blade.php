@extends('layouts.app')

@section('content')
<div class="container-fluid">

<div class="row align-items-center justify-content-center">
<a style="margin: 19px;" href="{{ route('transaction.index')}}" class="btn btn-secondary">< Back</a>

<div class="card">
 <div class="card-header">
    <h2>Create Transaction</h2>

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
      <form method="post" action="{{ route('transaction.store') }}">
          @csrf
          <div class="form-group">    
              <label for="first_name">Member:</label>
              <select name="member" required class="custom-select" id="inputGroupSelect01">
                @foreach($members as $member)
                  <option value="{{$member->id}}">{{$member->Name}}</option>
                @endforeach
              </select>
          </div>
          <div class="form-group">    
              <label for="transaction_date">Transaction Date:</label>
              <input required class="date form-control" name="transaction_date" type="date">
          </div>
          <div class="form-group">    
              <label for="first_name">Description:</label>
              <select name="description" required class="custom-select" id="inputGroupSelect01">
                <option value="Setor Tunai">Setor Tunai</option>
                <option value="Tarik Tunai">Tarik Tunai</option>
                <option value="Beli Pulsa">Beli Pulsa</option>
                <option value="Bayar Listrik">Bayar Listrik</option>
              </select>
          </div>
          <div class="form-group">    
              <label for="first_name">Amount:</label>
              <input type="number" class="form-control" name="amount" required></input>
          </div>
          <div class="form-group">    
              <label for="first_name">Debit Credit Status:</label>
              <select name="status" required class="custom-select" id="inputGroupSelect01">
                <option value="D">Debit</option>
                <option value="C">Credit</option>
              </select>
          </div>
        
          <button type="submit" class="btn btn-primary btn-block">Add Transaction</button>
      </form>
      </div>
  </div>
</div>
</div>
</div>
</div>
@endsection


