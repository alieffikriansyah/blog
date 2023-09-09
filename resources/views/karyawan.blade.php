@extends('layouts.dashboard')

@section('content')

<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Karyawan</h4>
            <p class="card-description">
                Add class <code>.table-hover</code>
            </p>
            @if (!Auth::user()->karyawan)
            <div class="btn-group float-sm-right">
                <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal"
                    data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Gaji Pokok</th>
                            <th style="text-align:center;">Status</th>
                            @if (!Auth::user()->karyawan)
                            <th style="text-align:center;">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($karyawan as $kat)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$kat->user->name}}</td>
                            <td>{{$kat->user->email}}</td>
                            <td>{{$kat->departemen->nama_departemen}}</td>
                            <td>{{$kat->jabatan->nama_jabatan}}</td>
                            <td>{{$kat->alamat}}</td>
                            <td>{{$kat->no_hp}}</td>
                            <td>{{$kat->gaji_pokok}}</td>
                            <td style="text-align:center;">{{$kat->status_karyawan}}</td>
                            @if (!Auth::user()->karyawan)
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-warning waves-effect waves-light btn-edit"
                                    data-id="{{$kat->id_karyawan}}" data-toggle="modal" data-target="#modalubah"> <i
                                        class="fa fa-edit"></i> Ubah</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-delete"
                                    data-id="{{$kat->id_karyawan}}"> <i class="fa fa-trash"></i> Hapus</button>
                            </td>
                        </tr>
                        @endif
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
                <h5 class="modal-title">Tambah Data Karyawan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhKaryawan" action="{{ route('karyawan.tambah') }}">
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

                    <!-- departemen -->
                    <div class="form-group">
                        <label>Departemen<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="departemen" required>
                            @foreach ($departemen as $d)
                            <option value="{{ $d->id_departemen }}">{{ $d->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- jabatan -->
                    <div class="form-group">
                        <label>Jabatan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="jabatan" required>
                            @foreach ($jabatan as $j)
                            <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-4">Alamat<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-4" required name="alamat"
                            placeholder="Alamat....">
                    </div>

                    <div class="form-group">
                        <label for="input-5">No. HP<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-5" required name="no_hp"
                            placeholder="No. HP....">
                    </div>

                    <div class="form-group">
                        <label for="input-6">Gaji Pokok<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-6" required name="gaji_pokok"
                            placeholder="Gaji Pokok....">
                    </div>

                    <div class="form-group">
                        <label for="tambahonoffswitch">Status<span style="color: #ff5252;">*</span></label>
                        <div class="onoffswitch">
                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="tambahonoffswitch"
                                tabindex="0" checked>
                            <label class="onoffswitch-label" for="tambahonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button
                            onclick="validateForm('ubhKaryawan','nama', 'departemen', 'jabatan', 'alamat', 'no_hp', 'gaji_pokok', 'status')"
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
                <h5 class="modal-title">Ubah Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="ubhKaryawan" action="{{ route('karyawan.ubah') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_karyawan">
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
                        <label>Departemen<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="departemen_ubah" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jabatan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="jabatan_ubah" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-11">Alamat<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" required id="input-12" name="alamat_ubah"
                            placeholder="Alamat....">
                    </div>
                    <div class="form-group">
                        <label for="input-11">No. HP<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" required id="input-13" name="no_hp_ubah"
                            placeholder="No.HP....">
                    </div>
                    <div class="form-group">
                        <label for="input-11">Gaji Pokok<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" required id="input-14" name="gaji_pokok_ubah"
                            placeholder="Gaji Pokok....">
                    </div>
                    <div class="form-group">
                        <label for="tambahonoffswitch">Status<span style="color: #ff5252;">*</span></label>
                        <div id="c_status"></div>
                    </div>
                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button
                            onclick="validateForm('ubhKaryawan','nama_ubah', 'departemen_ubah', 'jabatan_ubah', 'alamat_ubah', 'no_hp_ubah', 'gaji_pokok_ubah')"
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

    function ubah($id_karyawan) {
        $.ajax({
            url: "{{ url('get_ubah_karyawan') }}/" + $id_karyawan,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                // $('input[name*="id_karyawan').html('');
                // for (let $j=0; $j<res['user'].length; $j++) {
                //     if(res['id_karyawan']==res['user'][$j]['user_id_user']){
                //         $('select[name*="id_karyawan"]').append('<option selected value="'+res['user'][$j]['name']+'</option>');
                //     }else{
                //         $('select[name*="id_karyawan"]').append('<option value="'+res['user'][$j]['name']+'</option>'); 
                //     }
                // }
                $('input[name*="id_karyawan"]').val($id_karyawan);
                $('input[name*="nama_ubah"]').val(res['nama']);
                $('input[name*="email_ubah"]').val(res['email']);
                $('input[name*="password_ubah"]').val(res['password']);
                $('select[name*="departemen_ubah"]').html('');
                for (let $i = 0; $i < res['departemen'].length; $i++) {
                    if (res['departemen'][$i]['id_departemen'] == res['departemen_id_departemen']) {
                        $('select[name*="departemen_ubah"]').append('<option selected value="' + res[
                            'departemen'][$i]['id_departemen'] + '">' + res['departemen'][$i][
                            'nama_departemen'
                        ] + '</option>');
                    } else {
                        $('select[name*="departemen_ubah"]').append('<option value="' + res['departemen'][
                                $i]['id_departemen'] + '">' + res['departemen'][$i]['nama_departemen'] +
                            '</option>');
                    }
                }

                $('select[name*="jabatan_ubah"]').html('');
                for (let $i = 0; $i < res['jabatan'].length; $i++) {
                    if (res['jabatan'][$i] == res['jabatan_id_jabatan']) {
                        $('select[name*="jabatan_ubah"]').append('<option selected value="' + res['jabatan']
                            [$i]['id_jabatan'] + '">' + res['jabatan'][$i]['nama_jabatan'] + '</option>'
                            );
                    } else {
                        $('select[name*="jabatan_ubah"]').append('<option value="' + res['jabatan'][$i][
                            'id_jabatan'
                        ] + '">' + res['jabatan'][$i]['nama_jabatan'] + '</option>');
                    }
                }

                $('input[name*="alamat_ubah"]').val(res['alamat']);
                $('input[name*="no_hp_ubah"]').val(res['no_hp']);
                $('input[name*="gaji_pokok_ubah"]').val(res['gaji_pokok']);
                if (res['status_karyawan'] == 'Aktif') {
                    $('#c_status').html(
                        '<div class="onoffswitch"><input type="checkbox" name="status_ubah" class="onoffswitch-checkbox" id="ubahonoffswitch" tabindex="0" checked><label class="onoffswitch-label" for="ubahonoffswitch"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div>'
                        );
                    $('input[name*="status_ubah"]').attr('checked', true);
                } else {
                    $('#c_status').html(
                        '<div class="onoffswitch"><input type="checkbox" name="status_ubah" class="onoffswitch-checkbox" id="ubahonoffswitch" tabindex="0" checked><label class="onoffswitch-label" for="ubahonoffswitch"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div>'
                        );
                    $('input[name*="status_ubah"]').attr('checked', false);
                }
            }
        });
    }

    function hapus($id_karyawan) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{url('hapus_karyawan')}}/" + $id_karyawan;
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
