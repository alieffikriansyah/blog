@extends('layouts.dashboard')

@section('content')
<div class="row pt-2 pb-3">
    <div class="col-sm-9 pt-2">
        <h4 class="page-title">Log Admin</h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" style="background: #343536 !important;">
        <div class="card-body">
            <div class="table-responsive">
                <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:5px;">No</th>
                        <th>Nama</th>
                        <th>email</th>
                        <th style="text-align:center;">Login</th>
                        <th style="text-align:center;">Logout</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($log as $l)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$l->user->name}}</td>
                        <td>{{$l->user->email}}</td>
                        <td style="text-align:center;">{{$l->log_in}}</td>
                        <td style="text-align:center;">{{$l->log_out==null?'-':$l->log_out}}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!--Data Tables js-->
<script src="assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
<script src="assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

<script>
    $('#default-datatable').DataTable();
</script>
@endsection