@extends('layouts.dashboard')
@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">Absensi <br> Bulan : {{$months}}  <br> Tahun : {{$years}}</h4>
        <p class="card-description">
          Add class <code>.table-hover</code>
        </p>
        <div class="btn-group float-sm-right">
            <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
        </div>
        <div class="table-responsive">
            <h4>Pilih Bulan dan Tahun </h4>
            <select id="month" name="month">
                    <option value="">Select Month</option>
                        <?php
                            $selected_month = $months; //current month
                            for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                $selected = $selected_month == $i_month ? ' selected' : '';
                                echo '<option value="'.$i_month.'"'.$selected.'>('.$i_month.') '. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
                            }
                        ?>
                </select>

                <select id="year" name="year">
                    <option value="">Select Year</option>
                    <?php 
                        $year_start  = 1940;
                        $year_end = 2200; // current Year
                        $selected_year = $years; // current Year

                        for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                            $selected = $selected_year == $i_year ? ' selected' : '';
                            echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                        }
                    ?>
                </select>
                <button type="button" onclick="changePage()">Pilih </button>

                <table id="default-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal Mulai Pengajuan Cuti</th>
                            <th>Tanggal Selesai Pengajuan Cuti</th>
                            <th>Keterangan Cuti</th>
                            <th>Status Cuti</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($PengajuanCuti as $cuti)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$cuti->karyawan->nama}}</td>
                            <td>{{$cuti->tanggal_mulai_cuti}}</td>
                            <td>{{$cuti->tanggal_mulai_cuti}}</td>
                            <td>{{$cuti->keterangan_cuti}}</td>
                            <td>{{$cuti->status_cuti}}</td>
                            <td style="text-align:center;">
                            <button type="button" onclick="terima('{{ $cuti->idpengajuan_cuti }}')" class="btn btn-success waves-effect waves-light"> <i class="fa fa-edit"></i> Terima</button>
                            <button type="button" onclick="tolak('{{ $cuti->idpengajuan_cuti }}')" class="btn btn-danger waves-effect waves-light"> <i class="fa fa-edit"></i> Tolak</button>
                            <!-- <button type="button" onclick="getAbsen('{{ $i }}')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalabsen"> <i class="fa fa-edit"></i> Update</button> -->
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
<div class="modal fade" id="modalabsen">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
        <!-- <h5 class="modal-title">Absen Data PengajuanCuti</h5> -->
        <div class="row pt-2 pb-3">
            <div class="col-sm-9 pt-1">
                <h4 class="page-title">Absen Data PengajuanCuti</h4>
            </div>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
                </div>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="background: #343536 !important;">
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable-absen" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal dan Waktu PengajuanCuti</th>
                                    <th>Tipe PengajuanCuti</th>
                                    <th>Keterangan PengajuanCuti</th>
                                    <th>Status Hari</th>
                                    <th>Keterangan Cuti</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- HOW TO MAKE THIS AJAX -->
                                <!-- WILL BE HANDLED AJAX DONE hehe -->
                            </tbody>
                        </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="modaltambah">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Tambah Data Pengajuan Cuti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhAbsen" action="{{ route('pengajuanCuti.tambah') }}">
                {{ csrf_field() }}
                <!-- karyawan -->
                <div class="form-group">
                    <label>Karyawan<span style="color: #ff5252;">*</span></label>
                    <select class="form-control" name="karyawan" required>
                        @foreach ($karyawan as $d)
                            <option value="{{ $d->id_karyawan }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="input-1">Tanggal Mulai Cuti<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-1" required name="tanggal_mulai_cuti" placeholder="yyyy-mm-dd hh:mm:ss" value="<?php echo date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label for="input-1">Tanggal Selesai Cuti<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-1" required name="tanggal_selesai_cuti" placeholder="yyyy-mm-dd hh:mm:ss" value="<?php echo date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label for="input-11">Keterangan Cuti</label>
                    <input type="text" class="form-control" id="input-12" name="keterangan_cuti" placeholder="Keterangan Cuti....">
                </div>

                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhPengajuanCuti', 'karyawan', 'tanggal_cuti')" type="submit" class="btn btn-success px-5">Simpan</button>
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
        <h5 class="modal-title">Ubah Data Absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="ubhAbsen" action="{{ route('pengajuanCuti.ubah') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan_ubah" required>
                        
                        </select>
                </div>

                <div class="form-group">
                    <label>Tipe PengajuanCuti<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="tipe_pengajuanCuti_ubah" required>
                        
                        </select>
                </div>

                <div class="form-group">
                    <label for="input-11">Keterangan PengajuanCuti<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-12" name="keterangan_pengajuanCuti_ubah" placeholder="Keterangan PengajuanCuti....">
                </div>
        
                <div class="form-group">
                    <label for="input-1">Tanggal dan Waktu PengajuanCuti<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-1" required readonly name="tanggaldanwaktu_pengajuanCuti_ubah" placeholder="yyyy-mm-dd hh:mm:ss">
                </div>

                <div class="form-group">
                    <label>Status Hari<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="status_hari_ubah" required>
                        
                        </select>
                </div>

                <input type="hidden" name="id_ubah">
                <div class="form-group">
                    <label for="input-11">Keterangan Cuti<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-12" name="keterangan_cuti_ubah" placeholder="Keterangan Cuti....">
                </div>
                
                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhAbsen', 'waktu_Absen_ubah','keterangan_Absen_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<!-- End Modal -->
@endsection
@section('script')
<!--Data Tables js-->
  <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/app-script.js') }}"></script>
  <script src="{{ asset('assets/js/index.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
  <script src="{{ asset('assets/plugins/alerts-boxes/js/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/app-script.js') }}"></script>
  <script src="{{ asset('assets/js/index.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/notifications/js/notification-custom-script.js') }}"></script>
  <script src="{{ asset('assets/plugins/alerts-boxes/js/sweetalert.min.js') }}"></script> -->

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
    // $('#default-datatable-absen').DataTable();

    function validateForm($formx, $inpux){

        $inputs = $inpux.split(';');
        $valid = true;

        for (let i = 0; i < $inputs.length; i++) {
            
            $isi = document.forms[$formx][$inputs[i]].value;
            if ($isi == "") {
                alert($inputs[i].toUpperCase()+" tidak boleh kosong!");
                $loader = false;
                return false;
            }
        }

        if($valid){
            pageloader();
        }

    }

    function absen($id_pengajuanCuti) {
        $.ajax({
            url: "{{ url('get_ubah_pengajuanCuti') }}/"+$id_pengajuanCuti,
            type: 'get',
            dataType: 'json',
            success: function(res){
                $('input[name*="id_pengajuanCuti_absen"]').val(res['id_pengajuanCuti']);
                $('input[name*="nama_pengajuanCuti_absen"]').val(res['nama_pengajuanCuti']);
            }
        });
    }

    function getAbsen($day, $time) {
        $.ajax({
            url: "{{ url('get_absen_pengajuanCuti') }}/"+$day,
            type: 'get',
            dataType: 'json',
            success : function(data) {
                var table = $('#default-datatable-absen').DataTable({
                    destroy: true,
                    data,
                    columns: [
                        { "data": "nama" },
                        { "data": "tanggaldanwaktu_pengajuanCuti" },
                        { "data": "tipe_pengajuanCuti" },
                        { "data": "keterangan_pengajuanCuti" },
                        { "data": "status_hari" },
                        { "data": "keterangan_cuti" },
                        {
                            sortable: false,
                            "data": null,
                            "render": function ( data, type, full, meta ) {
                                var pengajuanCuti = data.id_pengajuanCuti;
                                var actionWidget  = `<button type="button" onclick="ubahAbsen('{{ '${pengajuanCuti}' }}')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalubah"> <i class="fa fa-edit"></i> Ubah</button>
                                            <button type="button" onclick="hapusAbsen('{{ '${pengajuanCuti}' }}')" class="btn btn-danger waves-effect waves-light"> <i class="fa fa-trash"></i> Hapus</button>`;
                                return actionWidget;
                            },
                            "targets": -1
                        },
                    ],
                });
                console.log('TIME >>>>', $time);
                $('input[name*="tanggaldanwaktu_pengajuanCuti"]').val($time);
            },
            error : function(err) {
                console.log('error', err);
            }
        });
    }

    function ubahAbsen($id_pengajuanCuti) {
        console.log('debug ubahAbsen >>>>',$id_pengajuanCuti);
        $.ajax({
            url: "{{ url('get_ubah_pengajuanCuti') }}/"+$id_pengajuanCuti,
            type: 'get',
            dataType: 'json',
            success: function(res){
                $('input[name*="id_ubah"]').val(res['id_pengajuanCuti']);
                $('input[name*="keterangan_pengajuanCuti_ubah"]').val(res['keterangan_pengajuanCuti']);
                $('input[name*="keterangan_cuti_ubah"]').val(res['keterangan_cuti']);

                for (let $i=0; $i<res['karyawan'].length; $i++) {
                    if(res['karyawan'][$i]['id_karyawan']==res['karyawan_id_karyawan']){
                        $('select[name*="karyawan_ubah"]').append('<option selected value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['karyawan'][$i]['nama']+'</option>');    
                    }else{
                        $('select[name*="karyawan_ubah"]').append('<option value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['karyawan'][$i]['nama']+'</option>');    
                    }
                }

                $('select[name*="tipe_pengajuanCuti_ubah"]').html('');
                const status_tipe_pengajuanCutis = ['hadir', 'izin', 'telat', 'bolos', 'cuti'];
                for (let $i=0; $i<status_tipe_pengajuanCutis.length; $i++) {
                    if(status_tipe_pengajuanCutis[$i]==res['tipe_pengajuanCuti']){
                        $('select[name*="tipe_pengajuanCuti_ubah"]').append('<option selected value="'+res['tipe_pengajuanCuti']+'">'+res['tipe_pengajuanCuti']+'</option>');
                    }else{
                        $('select[name*="tipe_pengajuanCuti_ubah"]').append('<option value="'+status_tipe_pengajuanCutis[$i]+'">'+status_tipe_pengajuanCutis[$i]+'</option>');
                    }
                }

                $('select[name*="status_hari_ubah"]').html('');
                const status_haris = ['masuk', 'libur'];
                for (let $i=0; $i<status_haris.length; $i++) {
                    if(status_haris[$i]==res['tipe_pengajuanCuti']){
                        $('select[name*="status_hari_ubah"]').append('<option selected value="'+res['status_hari']+'">'+res['status_hari']+'</option>');
                    }else{
                        $('select[name*="status_hari_ubah"]').append('<option value="'+status_haris[$i]+'">'+status_haris[$i]+'</option>');
                    }
                }
            }
        });
    }

    function hapusAbsen($id_pengajuanCuti){
        swal({ 
        title: "Apakah anda yakin?",
        text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href="{{url('hapus_pengajuanCuti')}}/"+$id_pengajuanCuti;
                pageloader();
            } 
        });
    }
    

    function hapus($id_pengajuanCuti){
        swal({ 
        title: "Apakah anda yakin?",
        text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href="{{url('hapus_pengajuanCuti')}}/"+$id_pengajuanCuti;
                pageloader();
            } 
        });
    }

    function tolak($id_tolak){
        swal({ 
        title: "Apakah anda yakin?",
        text: "Ingin menolak pengajuan cuti ini?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                console.log($id_tolak);
                window.location.href="{{url('tolak_pengajuanCuti')}}/"+$id_tolak;
                pageloader();
            } 
        });
    }

    function terima($id_terima){
        swal({ 
        title: "Apakah anda yakin?",
        text: "Ingin menerima pengajuan cuti ini?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href="{{url('terima_pengajuanCuti')}}/"+$id_terima;
                pageloader();
            } 
        });
    }

    function changePage(){
        var $year = $('#year').find(":selected").val();
        var month = $('#month').find(":selected").val();
        // console.log('DEBUGGG >>', $year, month);
        var url = "{{ route('pengajuanCuti.with.date') }}";

        $.ajax({
            url,
            data: {
                date: `${$year}-${month}`,
            },
            type: 'get',
            success: function(res){
                console.log('sucess = ', this.url);
                window.location.href=this.url;
                pageloader();
            }
        });
    }
</script>
@endsection