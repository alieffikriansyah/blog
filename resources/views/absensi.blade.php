@extends('layouts.dashboard')

@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="page-title">Presensi <br> Bulan : {{$months}} <br> Tahun : {{$years}}</h4>
            <p class="card-description">
                Add class <code>.table-hover </code>
            </p>
            {{-- <div class="btn-group float-sm-right">
            <button type="button" class="btn btn-suQccess waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
        </div> --}}
            <div class="table-responsive">
                @if (!Auth::user()->karyawan)
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
                @endif
                

                <table id="default-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Tanggal</th>
                            <th>Jumlah presensi</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($arrDays as $day)
                        <tr>
                            <td>{{$i}}</td>
                            {{-- <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $day)}}</td> --}}
                            {{-- <td>{{ \Carbon\Carbon::now('Y-m-d H:i:s', $day)}}</td> --}}
                            <td>{{$day}}</td>
                            <td>{{count($allAbsenPerDay[$i-1])}}</td>
                            <td style="text-align:center;">
                                <button type="button"  data-day="{{$day}}" data-arr="{{ $arrTimes[$i-1] }}"
                                    class="btn btn-warning waves-effect waves-light btn-absen" data-toggle="modal"
                                    data-target="#modalabsen"> <i class="fa fa-edit"></i> Detail</button>
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
{{-- modal --}}
<div class="modal fade" id="modalabsen">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Absen Data Absensi</h5> -->
                <div class="row pt-2 pb-3">
                    <div class="col-sm-9 pt-1">
                        <h4 class="page-title">presensi Data presensi</h4>
                    </div>
                    <div class="col-sm-3">
                        <div class="btn-group float-sm-right">
                            <!-- TAMPILKAN BUTTON TAMBAH KALAU SUDAH ABSEN -- START -->
                            @if (Auth::user()->karyawan && !$alreadyAbsen)
                                <button id="button-tambah-absen" type="button"
                                    class="btn btn-success waves-effect waves-light m-1" data-toggle="modal"
                                    data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
                            @endif
                            @if (!Auth::user()->karyawan)
                                <button id="button-tambah-absen" type="button"
                                    class="btn btn-success waves-effect waves-light m-1" data-toggle="modal"
                                    data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
                            @endif
                            <!-- TAMPILKAN BUTTON TAMBAH KALAU SUDAH ABSEN -- END -->
                        </div>
                        <!-- LOG PRESENSI -- START -->
                        {{-- @if (!Auth::user()->karyawan)
                        <div class="btn-group float-sm-right">
                            <button id="button-log-absen" type="button"  data-day="{{$day}}" 
                                class="btn btn-info waves-effect waves-light m-1" data-toggle="modal"
                                data-target="#modallog"> <i class="fa fa fa-plus"></i> Log presensi</button>
                        </div>
                        @endif --}}
                        <!-- LOG PRESENSI -- END -->
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="background: #e9edf1 !important;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="default-datatable-absen" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Karyawan</th>
                                                <th>Tanggal dan Waktu presensi</th>
                                                <th>Tipe Presensi</th>
                                                <th>Keterangan Presensi</th>
                                                <th>Status Hari</th>
                                                {{-- <th>Keterangan Cuti</th> --}}
                                                @if (!Auth::user()->karyawan)
                                                <th style="text-align:center;">Action</th>
                                                @endif
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
                <h5 class="modal-title">Tambah Data presensi Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhAbsen" action="{{ route('absensi.tambah') }}">
                    {{ csrf_field() }}
                    <!-- karyawan -->
                    <div class="form-group">
                        <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan" @if (!Auth::user()->admin)
                            readonly
                        @endif required>
                            @if (Auth::user()->admin)
                            @foreach ($karyawan as $d)
                            <option value="{{ $d->id_karyawan }}">{{ $d->user->name }}</option>
                            @endforeach
                            @else 
                            <option value="{{ Auth::user()->karyawan->id_karyawan }}">{{ Auth::user()->name }}</option>
                            @endif
                           
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Absensi<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="tipe_absensi"@if (!Auth::user()->admin)
                            readonly
                        @endif required>
                        @if (Auth::user()->admin)
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="telat">Telat</option>
                            <option value="bolos">Bolos</option>
                            <option value="cuti">Cuti</option>
                            @else 
                            <option value="hadir">Hadir</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-11">Keterangan Absensi</label>
                        <input type="text" class="form-control" id="input-12" name="keterangan_absensi"
                            placeholder="Keterangan Absensi....">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Tanggal dan Waktu Absensi<span style="color: #ff5252;">*</span></label>
                        <input type="datetime-local" id="input-1" name="tanggaldanwaktu_absensi" class="form-control" value="<?php echo (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i'); ?>" required readonly>
                    </div>

                    @if (!Auth::user()->karyawan)
                        <div class="form-group">
                            <label>Status Hari<span style="color: #ff5252;">*</span></label>
                            <select class="form-control" name="status_hari">
                                <option value="masuk">Masuk</option>
                                <option value="libur">Libur</option>
                            </select>
                        </div>
                    @endif

                    {{-- <div class="form-group">
                        <label for="input-11">Keterangan Cuti</label>
                        <input type="text" class="form-control" id="input-12" name="keterangan_cuti"
                            placeholder="Keterangan Cuti....">
                    </div> --}}

                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button
                            onclick="validateForm('ubhAbsensi', 'karyawan', 'tipe_absensi', 'tanggaldanwaktu_absensi', 'tipe_absensi')"
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
                <h5 class="modal-title">Ubah Data Absen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="ubhAbsen" action="{{ route('absensi.ubah') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan_ubah" required>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Absensi<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="tipe_absensi_ubah" required>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-11">Keterangan Absensi<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-12" name="keterangan_absensi_ubah"
                            placeholder="Keterangan Absensi....">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Tanggal dan Waktu Absensi<span style="color: #ff5252;">*</span></label>
                        <input type="datetime-local" id="input-1" name="tanggaldanwaktu_absensi_ubah" class="form-control" value="<?php echo (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i'); ?>" required readonly>
                            
                    </div>

                    @if (!Auth::user()->karyawan)
                        <div class="form-group">
                            <label>Status Hari<span style="color: #ff5252;">*</span></label>
                            <select class="form-control" name="status_hari_ubah" required>

                            </select>
                        </div>
                    @endif

                    <input type="hidden" name="id_ubah">
                    {{-- <div class="form-group">
                        <label for="input-11">Keterangan Cuti<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-12" name="keterangan_cuti_ubah"
                            placeholder="Keterangan Cuti....">
                    </div> --}}

                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button onclick="validateForm('ubhAbsen', 'waktu_Absen_ubah','keterangan_Absen_ubah')"
                            type="submit" class="btn btn-warning px-5">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modallog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form >
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="default-datatable-log" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Karyawan</th>
                                                    <th>Status Kehadiran</th>
                                                    <th>Tanggal & Waktu kehadiran</th>
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
                    {{-- <div class="btn-group float-sm-right mt-2">
                        <button onclick="validateForm('ubhPenilaian', 'karyawan', 'tanggaldanwaktu_absensi ')" type="submit"
                            class="btn btn-success px-5">Update</button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

@endsection
@section('script')
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
    // $('#default-datatable').DataTable();
    // $('#default-datatable-absen').DataTable();

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

    function absen($id_absensi) {
        $.ajax({
            url: "{{ url('get_ubah_absensi') }}/" + $id_absensi,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $('input[name*="id_absensi_absen"]').val(res['id_absensi']);
                $('input[name*="nama_absensi_absen"]').val(res['nama_absensi']);
            }
        });
    }

    
    $(".btn-absen").each(function (index) {
        $(this).on("click", function () {
            getAbsen($(this).data('day'), $(this).data('arr'));
            getLogAbsen($(this).data('day'), $(this).data('arr'));
        })
    });


    function getAbsen($day, $time) {
        $.ajax({
            url: "{{ url('get_absen_absensi') }}/" + $day,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('#default-datatable-absen tbody tr').remove();
                data.forEach(item => {
                    $('#default-datatable-absen tbody').append(
                        `<tr>
                        <td>${item.name}</td>
                        <td>${item.tanggaldanwaktu_absensi}</td>
                        <td>${item.tipe_absensi}</td>
                        <td>${item.keterangan_absensi}</td>
                        <td>${item.status_hari}</td>
                        @if (!Auth::user()->karyawan)
                        <td>
                           
                            <button type="button" onclick="ubahAbsen('{{ '${item.id_absensi}' }}')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalubah"> <i class="fa fa-edit"></i> Ubah</button>
                                            <button type="button" onclick="hapusAbsen('{{ '${item.id_absensi}' }}')" class="btn btn-danger waves-effect waves-light"> <i class="fa fa-trash"></i> Hapus</button>
                             
                        </td>
                        @endif  

                    </tr>`
                    )
                });
                console.log('TIME >>>>', $time);
                console.log('day >>>>', $day);
                var dateOffset = (24 * 60 * 60 * 1000) * 1; //1 days
                const currentDate = new Date();
                currentDate.setDate(currentDate.getDate() + 1);
                currentDate.setTime(currentDate.getTime() - dateOffset);
                const selectedDate = new Date($time);
                console.log('currentDate >>>>', currentDate);
                console.log('selectedDate >>>>', selectedDate);
                console.log('Format >>>>', new Date(currentDate).toDateString());

                // DISABLE BUTTON - START
//                 if (new Date(currentDate).toDateString()
//  == new Date(selectedDate).toDateString()) {
//                     $("#button-tambah-absen").attr("disabled", false);
//                 } else {
//                     $("#button-tambah-absen").attr("disabled", true);
//                 }
                // DISABLE BUTTON - END
                console.log($time);
            },
            error: function (err) {
                console.log('error', err);
            }
        });
    }

    function getLogAbsen($day, $time) {
        $.ajax({
            url: "{{ url('get_log_absensi') }}/" + $day,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('#default-datatable-log tbody tr').remove();
                data.forEach(item => {
                    $('#default-datatable-log tbody').append(
                        `<tr>
                        <td>${item.name}</td>
                        <td>${item.tipe_absensi}</td>
                        <td>${item.tanggaldanwaktu_absensi}</td>
                    </tr>`
                    )
                });
            },
            error: function (err) {
                console.log('error', err);
            }
        });
    }

    function ubahAbsen($id_absensi) {
        console.log('debug ubahAbsen >>>>', $id_absensi);
        $.ajax({
            url: "{{ url('get_ubah_absensi') }}/" + $id_absensi,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $('input[name*="id_ubah"]').val(res['id_absensi']);
                $('input[name*="keterangan_absensi_ubah"]').val(res['keterangan_absensi']);
                // $('input[name*="keterangan_cuti_ubah"]').val(res['keterangan_cuti']);

                for (let $i = 0; $i < res['karyawan'].length; $i++) {
                    if (res['karyawan'][$i]['id_karyawan'] == res['karyawan_id_karyawan']) {
                        $('select[name*="karyawan_ubah"]').append('<option selected value="' + res[
                                'karyawan'][$i]['id_karyawan'] + '">' + res['karyawan'][$i]['name'] +
                            '</option>');
                    } else {
                        $('select[name*="karyawan_ubah"]').append('<option value="' + res['karyawan'][$i][
                            'id_karyawan'
                        ] + '">' + res['karyawan'][$i]['name'] + '</option>');
                    }
                }

                $('select[name*="tipe_absensi_ubah"]').html('');
                const status_tipe_absensis = ['hadir', 'izin', 'telat', 'bolos', 'cuti'];
                for (let $i = 0; $i < status_tipe_absensis.length; $i++) {
                    if (status_tipe_absensis[$i] == res['tipe_absensi']) {
                        $('select[name*="tipe_absensi_ubah"]').append('<option selected value="' + res[
                            'tipe_absensi'] + '">' + res['tipe_absensi'] + '</option>');
                    } else {
                        $('select[name*="tipe_absensi_ubah"]').append('<option value="' +
                            status_tipe_absensis[$i] + '">' + status_tipe_absensis[$i] + '</option>');
                    }
                }

                $('select[name*="status_hari_ubah"]').html('');
                const status_haris = ['masuk', 'libur'];
                for (let $i = 0; $i < status_haris.length; $i++) {
                    if (status_haris[$i] == res['tipe_absensi']) {
                        $('select[name*="status_hari_ubah"]').append('<option selected value="' + res[
                            'status_hari'] + '">' + res['status_hari'] + '</option>');
                    } else {
                        $('select[name*="status_hari_ubah"]').append('<option value="' + status_haris[$i] +
                            '">' + status_haris[$i] + '</option>');
                    }
                }
            }
        });
    }

    function hapusAbsen($id_absensi) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{url('hapus_absensi')}}/" + $id_absensi;
                pageloader();
            }
        });
    }


    function hapus($id_absensi) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{url('hapus_absensi')}}/" + $id_absensi;
            }
                pageloader();        });
    }

    function changePage() {
        var $year = $('#year').find(":selected").val();
        var month = $('#month').find(":selected").val();
        // console.log('DEBUGGG >>', $year, month);
        var url = "{{ route('absensi') }}";

        $.ajax({
            url,
            data: {
                date: `${$year}-${month}`,
            },
            type: 'get',
            success: function (res) {
                console.log('sucess = ', this.url);
                window.location.href = this.url;
                pageloader();            }
        });
    }

</script>
@endsection
