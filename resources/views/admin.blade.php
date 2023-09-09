@extends('layouts.dashboard')

@section('content')

<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Admin</h4>
            <p class="card-description">
                 <code></code>
            </p>

            <div class="btn-group float-sm-right">
                <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal"
                    data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="text-align:center;">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($admin as $adm)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$adm->user->name}}</td>
                            <td>{{$adm->user->email}}</td>
                            <td>{{$adm->role}}</td>
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-warning waves-effect waves-light btn-edit"
                                    data-id="{{$adm->id_admin}}" data-toggle="modal" data-target="#modalubah"> <i
                                        class="fa fa-edit"></i> Ubah</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-delete"
                                    data-id="{{$adm->id_admin}}"> <i class="fa fa-trash"></i> Hapus</button>
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modaltambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Admin Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhadmin" action="{{ route('admin.tambah') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="input-1">Nama<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required name="nama"
                            placeholder="Nama....">
                    </div>

                    <div class="form-group">
                        <label for="input-11">Email<span style="color: #ff5252;">*</span></label>
                        <input type="email" class="form-control" id="input-11" required name="email"
                            placeholder="Email....">
                    </div>

                    <div class="form-group">
                        <label for="input-12">Password<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-12" required name="password"
                            placeholder="Password....">
                    </div>


                    <div class="form-group">
                        <label for="input-4">role<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-4" name="role"
                            value="Admin"required readonly>
                    </div>
                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button
                            onclick="validateForm('tbhadmin','nama', 'email', 'password',)"
                            type="submit" class="btn btn-success px-5">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalubah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="ubhAdmin" action="{{ route('admin.ubah') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_admin">
                    <div class="form-group">
                        <label for="input-11">Nama<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" required id="input-11" name="nama_ubah"
                            placeholder="Nama....">
                    </div>
                    <div class="form-group">
                        <label for="input-9">Email<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" required id="input-9" name="email_ubah"
                            placeholder="Email....">
                    </div>
                    <div class="form-group">
                        <label for="input-8">Password<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" required id="input-8" name="password_ubah"
                            placeholder="Password....">
                    </div>
                   
                    <div class="form-group">
                        <label for="input-11">role<span style="color: #ff5252;">*</span></label>
                        <select name="role" id="input-12" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="supeadmin">Superadmin</option>
                        </select>
                    </div>
                   
                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button
                            onclick="validateForm('ubhAdmin','nama_ubah', 'email_ubah', 'password_ubah')"
                            type="submit" class="btn btn-warning px-5">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

{{-- <script src="assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script> --}}
<script>
    //   $('#default-datatable').DataTable();

    function validateForm($formx, $inpux) {

        $inputs = $inpux.split(';');
        $valid = true;

        for (let i = 0; i < $inputs.length; i++) {

            $isi = document.forms[$formx][$inputs[i]].value;
            if ($isi == "") {
                alert($inputs[i].toUpperCase() + " tidak boleh kosong!");
                $loader = false;
                return false;
            }
        }

        if ($valid) {
            pageloader();
        }

    }

    function ubah($id_admin) {
        $.ajax({
            url: "{{ url('get_ubah_admin') }}/" + $id_admin,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                const data = res[0];
                console.log(data, data.user.name);
                // $('input[name*="id_karyawan').html('');
                // for (let $j=0; $j<res['user'].length; $j++) {
                //     if(res['id_karyawan']==res['user'][$j]['user_id_user']){
                //         $('select[name*="id_karyawan"]').append('<option selected value="'+res['user'][$j]['name']+'</option>');
                //     }else{
                //         $('select[name*="id_karyawan"]').append('<option value="'+res['user'][$j]['name']+'</option>'); 
                //     }
                // }
                $('input[name="id_admin"]').val($id_admin);
                $('input[name="nama_ubah"]').val(data.user.name);
                $('input[name="email_ubah"]').val(data.user.email);
                // $('input[name*="password_ubah"]').val(res['password']);
            }
        });
    }

    function hapus($id_admin) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{url('hapus_admin')}}/" + $id_admin;
                pageloader();
            }
        });
    }

    $(".btn-edit").each(function (index) {
        $(this).on("click", function () {
            ubah($(this).data('id'));
        });
    });

    $(".btn-delete").each(function (index) {
        $(this).on("click", function () {
            hapus($(this).data('id'));
        });
    });

</script>
@endsection
