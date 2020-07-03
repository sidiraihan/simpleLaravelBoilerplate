@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="row align-items-center justify-content-center">
<div class="col-md-12">

<a style="margin: 19px;" href="{{ route('transaction.index')}}" class="btn btn-secondary">< Back</a>
@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
<div class="card">
 <div class="card-header">
    <h2>Create Report</h2>
    <form class="d-flex" method="post" action="/generate-report/member">
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
              <label for="transaction_date">Start Date:</label>
              <input required class="date form-control" name="transaction_date_start" type="date">
          </div>
          <div class="form-group">    
              <label for="transaction_date">End Date:</label>
              <input required class="date form-control" name="transaction_date_end" type="date">
          </div>
          <div class="form-group d-flex align-items-end container-fluid">    
          <button type="submit" class="btn btn-primary btn-block">Generate Report</button>
          </div>
      </form>
  <div>
   

    
    @if($transactions != '' )
        
    <div class="card-body">
    <table class="table table-striped">
    <thead>
        <tr>
          <td>TransactionDate</td>
          <td>Description</td>
          <td>Credit</td>
          <td>Debit</td>
        </tr>
    </thead>
    <tbody>
        @php
          $total_debit = 0;
          $total_credit = 0;
          $balances = 0;
          $name = '';
        @endphp

        @foreach($transactions as $report)

        @php
        $calc = $report->DebitCreditStatus == 'D' ? $total_debit = $report->Amount + $total_debit : 
                $total_credit = $report->Amount + $total_credit;
        $balances = $total_credit - $total_debit;  
        $name = $report->memberData['Name'];
        @endphp


        <tr>
            <td>{{$report->TransactionDate}}</td>
            <td>{{$report->Description}}</td>
            <td>{{$report->DebitCreditStatus == 'C' ? $report->Amount : '-'}}</td>
            <td>{{$report->DebitCreditStatus == 'D' ? $report->Amount : '-'}}</td>
        </tr>
        @endforeach
        <p>Hai {{$name}} Balance Akhir Anda {{$balances}}<p>

    </tbody>
  </table>

  
    @endif       
    
    
      </div>
  </div>
</div>
</div>
</div>
</div>
<div>
@endsection


