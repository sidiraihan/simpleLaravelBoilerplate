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
                <div class="card-header">Contact Information     <a style="margin: 19px;" href="{{ route('contacts.create')}}" class="btn btn-primary">Add contact</a></div>
                <div class="card-body">
                <table id="contactTable" class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Email</td>
          <td>Job Title</td>
          <td>City</td>
          <td>Country</td>
          <td>Owner</td>
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
    $('#contactTable').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        autoWidth: false, // This parameter must be set to false
        ajax: "{{ route('contacts.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'first_name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'job_title', name: 'job',},
            { data: 'city', name: 'city' },
            { data: 'country', name: 'country' },
            { data: 'owner', name: 'owner' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

});
</script>
@endpush