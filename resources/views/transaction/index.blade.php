@extends('layouts.app')

@section('content')


<div class="container-fluid">

<div class="row justify-content-center">
<div class="col-sm-12">

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
      <button type="button" class="close" data-dismiss="alert">×</button> 
    </div>
  @endif
</div>
</div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Transaction Information     <a style="margin: 19px;" href="{{ route('transaction.create')}}" class="btn btn-primary">Add Transaction</a> <a style="margin: 19px;" href="report/member" class="btn btn-primary">Create Report</a></div>
                <div class="card-body">
                <table id="memberTable" class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>AccountId</td>
          <td>TransactionDate</td>
          <td>Description</td>
          <td>DebitCreditStatus</td>
          <td>Amount</td>
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">



$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#memberTable').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        autoWidth: false, // This parameter must be set to false
        ajax: "{{ route('transaction.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'AccountId', name: 'accountId' },
            { data: 'TransactionDate', name: 'transactionDate' },
            { data: 'Description', name: 'description' },
            { data: 'DebitCreditStatus', name: 'debitCreditStatus' },
            { data: 'Amount', name: 'amount' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    //delete binding
    // $(document).on('click','.rm-transaction',function(){
    //     var id = $(this).data('id');
    //     var name = $(this).data('name');
    //     swal({
    //     title: "Are you sure?",
    //     text: "you are going to remove "+name,
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //     })
    //     .then((willDelete) => {
    //     if (willDelete) {

    //         $.ajax(
    //             {
    //             url: "member/"+id, 
    //             type: 'DELETE',
    //             data: {
    //                 id: id
    //             },
    //             success: function (response){
    //                 $('#memberTable').DataTable().ajax.reload() ;
    //                 swal("Removed", {
    //                 icon: "success",
    //                 timer: 800,
    //                 });
    //             }
    //         });
    //     }
    //     });
    // });

    //swal("Hello world!");

});
</script>
@endpush