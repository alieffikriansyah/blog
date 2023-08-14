@extends('layouts.dashboard')
@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Penilaian Kinerja Karyawan <br> Tahun {{$years}} <br> Bulan {{$months}}</h4>
            <p class="card-description">
                Add class <code>.table-hover</code>
            </p>
            <div class="btn-group float-sm-right">
                <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal"
                    data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
            </div>
            <div class="table-responsive">
                <select id="month" name="month">
                    <option value="">Select Month</option>
                    <?php
                        $selected_month = date('m'); //current month
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
                    $selected_year = date('Y'); // current Year

                    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                        $selected = $selected_year == $i_year ? ' selected' : '';
                        echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                    }
                ?>
                </select>
                <button type="button" onclick="changePage()">Button</button>
                <table id="default-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Nama Form</th>
                            <th>Tanggal Penilaian</th>
                            <th>Periode</th>
                            <th>Skor</th>
                            <th>Nama Penilai</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @forelse($penilaian as $p)
                        @if (isset($p->karyawan))
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$p->karyawan->nama}}</td>
                            <td>{{$p->karyawan->departemen->nama_departemen}}</td>
                            <td>{{$p->karyawan->jabatan->nama_jabatan}}</td>
                            <td>{{$p->formPenilaian->nama_form_penilaian}}</td>
                            <td>{{$p->waktu_penilaian}}</td>
                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $p->periode_penilaian)->format('F')}}
                            </td>
                            <td>{{$p->nilai_skor}}</td>
                            <td>{{$p->nama_penilai}}</td>
                            <td style="text-align:center;">
                                <button class="btn btn-success waves-effect waves-light btn-detil" data-toggle="modal"
                                    data-target="#modalnilai" data-idform="{{$p->formPenilaian->idform_penilaian}}"
                                    data-id="{{$p->id_penilaian}}"> <i class="fa fa-plus"></i> Nilai</button>
                                {{-- <button type="button" class="btn btn-warning waves-effect waves-light btn-edit"  data-toggle="modal" data-target="#modalubah" data-id="{{ $p->id_penilaian }}">
                                <i class="fa fa-edit"></i> Update</button> --}}
                                <button type="button" onclick="hapus('{{ $p->id_penilaian }}')"
                                    class="btn btn-danger waves-effect waves-light"> <i class="fa fa-trash"></i>
                                    Hapus</button>
                                <!-- <button type="button" onclick="getAbsen('{{ $i }}')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalabsen"> <i class="fa fa-edit"></i> Update</button> -->
                            </td>
                        </tr>
                        @else
                        {{-- {{dd($penilaian)}} --}}
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$p->nama}}</td>
                            <td>{{$p->nama_departemen}}</td>
                            <td>{{$p->nama_jabatan}}</td>
                            <td>{{$p->nama_form_penilaian}}</td>
                            <td>{{$p->waktu_penilaian}}</td>
                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $p->periode_penilaian)->format('F')}}
                            </td>
                            <td>{{$p->nilai_skor}}</td>
                            <td>{{$p->nama_penilai}}</td>
                            <td style="text-align:center;">
                                <button class="btn btn-success waves-effect waves-light btn-detil" data-toggle="modal"
                                    data-target="#modalnilai" data-idform="{{$p->form_penilaian_idtable1}}"
                                    data-id="{{$p->id_penilaian}}"> <i class="fa fa-plus"></i> Nilai</button>
                                {{-- <button type="button" class="btn btn-warning waves-effect waves-light btn-edit"  data-toggle="modal" data-target="#modalubah" data-id="{{ $p->id_penilaian }}">
                                <i class="fa fa-edit"></i> Update</button> --}}
                                <button type="button" onclick="hapus('{{ $p->id_penilaian }}')"
                                    class="btn btn-danger waves-effect waves-light"> <i class="fa fa-trash"></i>
                                    Hapus</button>
                                <!-- <button type="button" onclick="getAbsen('{{ $i }}')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalabsen"> <i class="fa fa-edit"></i> Update</button> -->
                            </td>
                        </tr>
                        @endif
                        @php $i++; @endphp
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="modaltambah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhAbsen" action="{{ route('penilaian.tambah') }}">
                    {{ csrf_field() }}
                    <!-- karyawan -->
                    <div class="form-group">
                        <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan" required>
                            @foreach ($karyawan as $d)
                            <option value="{{ $d->id_karyawan }}">{{ $d->nama_departemen }} - {{ $d->nama_jabatan }} -
                                {{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="input-1">Tanggal Penilaian<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required name="waktu_penilaian"
                            placeholder="yyyy-mm-dd hh:mm:ss" value="<?php echo date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Periode Penilaian<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required name="periode_penilaian"
                            placeholder="yyyy-mm-dd hh:mm:ss" value="<?php echo date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label for="input-11">Nama Penilai<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-12" required name="nama_penilai"
                            placeholder="Nama Penilai...." value="Admin">
                    </div>

                    <div class="form-group">
                        <label>Form Penilaian<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="idform_penilaian" onchange="getDetilFormPenilaians(this)"
                            required>
                            <option disabled selected value> -- Pilih Form Penilaian -- </option>
                            @foreach ($formPenilaian as $d)
                            <option value="{{ $d->idform_penilaian }}">{{ $d->nama_form_penilaian }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="nilai_skor" value="0">
                    </div>

                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button onclick="validateForm('ubhPenilaian', 'karyawan', 'waktu_penilaian')" type="submit"
                            class="btn btn-success px-5">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalubah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhAbsen" action="{{ route('penilaian.ubah') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_penilaian">
                    <!-- karyawan -->
                    <div class="form-group">
                        <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan" required>
                            @foreach ($karyawan as $d)
                            <option value="{{ $d->id_karyawan }}">{{ $d->nama_departemen }} - {{ $d->nama_jabatan }} -
                                {{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="input-1">Tanggal Penilaian<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required name="waktu_penilaian"
                            placeholder="yyyy-mm-dd hh:mm:ss" value="<?php echo date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Periode Penilaian<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required name="periode_penilaian"
                            placeholder="yyyy-mm-dd hh:mm:ss" value="<?php echo date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label for="input-11">Nama Penilai<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-12" required name="nama_penilai"
                            placeholder="Nama Penilai...." value="Admin">
                    </div>

                    <div class="form-group">
                        <label>Form Penilaian<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="idform_penilaian" onchange="getDetilFormPenilaians(this)"
                            required>
                            <option disabled selected value> -- Pilih Form Penilaian -- </option>
                            @foreach ($formPenilaian as $d)
                            <option value="{{ $d->idform_penilaian }}">{{ $d->nama_form_penilaian }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="nilai_skor" value="0">
                    </div>

                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button onclick="validateForm('ubhPenilaian', 'karyawan', 'waktu_penilaian')" type="submit"
                            class="btn btn-success px-5">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal fade" id="modalubah">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Ubah Data Absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="ubhAbsen" action="{{ route('penilaian.ubah') }}">
{{ csrf_field() }}
<div class="form-group">
    <label>Karyawan<span style="color: #ff5252;">*</span></label>
    <select class="form-control" name="karyawan_ubah" required>

    </select>
</div>

<div class="form-group">
    <label>Tipe Penilaian<span style="color: #ff5252;">*</span></label>
    <select class="form-control" name="tipe_penilaian_ubah" required>

    </select>
</div>

<div class="form-group">
    <label for="input-11">Keterangan Penilaian<span style="color: #ff5252;">*</span></label>
    <input type="text" class="form-control" id="input-12" name="keterangan_penilaian_ubah"
        placeholder="Keterangan Penilaian....">
</div>

<div class="form-group">
    <label for="input-1">Tanggal dan Waktu Penilaian<span style="color: #ff5252;">*</span></label>
    <input type="text" class="form-control" id="input-1" required readonly name="tanggaldanwaktu_penilaian_ubah"
        placeholder="yyyy-mm-dd hh:mm:ss">
</div>

<div class="form-group">
    <label>Status Hari<span style="color: #ff5252;">*</span></label>
    <select class="form-control" name="status_hari_ubah" required>

    </select>
</div>

<input type="hidden" name="id_ubah">
<div class="form-group">
    <label for="input-11">Keterangan Cuti<span style="color: #ff5252;">*</span></label>
    <input type="text" class="form-control" id="input-12" name="keterangan_penilaian_ubah"
        placeholder="Keterangan Cuti....">
</div>

<small style="color: #ff5252;">* Wajib Diisi</small>
<div class="btn-group float-sm-right mt-2">
    <button onclick="validateForm('ubhAbsen', 'waktu_Absen_ubah','keterangan_Absen_ubah')" type="submit"
        class="btn btn-warning px-5">Ubah</button>
</div>
</form>
</div>
</div>
</div>
</div> --}}

<div class="modal fade" id="modalnilai">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhAbsen" action="{{ route('penilaian.ubahNilai') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="id_form_penilaian_nilai">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id_penilaian_nilai">
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="default-datatable-detil-form" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Kriteria</th>
                                                    <th>Indikator</th>
                                                    <th>Nilai</th>
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
                    <div class="btn-group float-sm-right mt-2">
                        <button onclick="validateForm('ubhPenilaian', 'karyawan', 'waktu_penilaian')" type="submit"
                            class="btn btn-success px-5">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

@endsection
@section ('script')

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

    $(".btn-edit").each(function (index) {
        $(this).on("click", function () {
            ubah($(this).data('id'));
            // alert('oke');
        });
    });

    function ubah($id_penilaian) {
        $.ajax({
            url: "{{ url('get_ubah_penilaian') }}/" + $id_penilaian,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res)
                $('input[name="id_penilaian"]').val($id_penilaian);
                $('input[name="waktu_penilaian"]').val(res.nama_form_penilaian);
                $('input[name="periode_penilaian"]').val(res.nama_form_penilaian);
                $('input[name="nama_penilai"]').val(res.nama_form_penilaian);
                //   $('input[name="nama_form_penilaian_ubah"]').val(res['nama_form_penilaian']);
            }
        });
    }

    function absen($id_penilaian) {
        $.ajax({
            url: "{{ url('get_ubah_penilaian') }}/" + $id_penilaian,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $('input[name*="id_penilaian_absen"]').val(res['id_penilaian']);
                $('input[name*="nama_penilaian_absen"]').val(res['nama_penilaian']);
            }
        });
    }

    // function getAbsen($day, $time) {
    //     $.ajax({
    //         url: "{{ url('get_absen_penilaian') }}/"+$day,
    //         type: 'get',
    //         dataType: 'json',
    //         success : function(data) {
    //             var table = $('#default-datatable-absen').DataTable({
    //                 destroy: true,
    //                 data,
    //                 columns: [
    //                     { "data": "nama" },
    //                     { "data": "tanggaldanwaktu_penilaian" },
    //                     { "data": "tipe_penilaian" },
    //                     { "data": "keterangan_penilaian" },
    //                     { "data": "status_hari" },
    //                     { "data": "keterangan_penilaian" },
    //                     {
    //                         sortable: false,
    //                         "data": null,
    //                         "render": function ( data, type, full, meta ) {
    //                             var penilaian = data.id_penilaian;
    //                             var actionWidget  = `<button type="button" onclick="ubahAbsen('{{ '${penilaian}' }}')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalubah"> <i class="fa fa-edit"></i> Ubah</button>
    //                                         <button type="button" onclick="hapusAbsen('{{ '${penilaian}' }}')" class="btn btn-danger waves-effect waves-light"> <i class="fa fa-trash"></i> Hapus</button>`;
    //                             return actionWidget;
    //                         },
    //                         "targets": -1
    //                     },
    //                 ],
    //             });
    //             console.log('TIME >>>>', $time);
    //             $('input[name*="tanggaldanwaktu_penilaian"]').val($time);
    //         },
    //         error : function(err) {
    //             console.log('error', err);
    //         }
    //     });
    // }



    function hapus($id_penilaian) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "{{url('hapus_penilaian')}}/" + $id_penilaian;
                pageloader();
            }
        });
    }

    // function tolak($id_tolak){
    //     swal({ 
    //     title: "Apakah anda yakin?",
    //     text: "Ingin menolak pengajuan penilaian ini?",
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //     }).then((willDelete) => {
    //         if (willDelete) {
    //             console.log($id_tolak);

    //             window.location.href="{{url('tolak_penilaian')}}/"+$id_tolak;
    //             pageloader();
    //         } 
    //     });
    // }

    // function terima($id_terima){
    //     swal({ 
    //     title: "Apakah anda yakin?",
    //     text: "Ingin menerima pengajuan penilaian ini?",
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //     }).then((willDelete) => {
    //         if (willDelete) {
    //             pageloader();
    //             window.location.href="{{url('terima_penilaian')}}/"+$id_terima;
    //         } 
    //     });
    // }

    function getDetilFormPenilaians(selectObject) {
        var value = selectObject.value;
        console.log(value);
    }

    function getDetil($id_form_penilaian, $id_penilaian) {
        $('#default-datatable-detil-form tbody tr').remove();
        $.ajax({
            url: "{{ url('get_ubah_detil_form_penilaian') }}/" + $id_form_penilaian,
            type: 'get',
            dataType: 'json',
            success: function (data) {

                data.forEach(item => {
                    $('#default-datatable-detil-form tbody').append(
                        `<tr>
                        <td>${item.nama_kriteria}</td>
                        <td>${item.nama_indikator}</td>
                        <td>
                            <div class="form-group">
                                     <label for="input-${item.id_detil_form_penilaian}">Nilai<span style="color: #ff5252;">*</span></label>
                                    <input type="text" class="form-control" id="input-${item.id_detil_form_penilaian}" name="nilai_detail${item.id_detil_form_penilaian}" placeholder="1-5 ....">
                                </div>    
                        </td>

                    </tr>`
                    )
                });

                $('input[name*="id_penilaian_nilai"]').val($id_penilaian);
                $('input[name*="id_form_penilaian_nilai"]').val($id_form_penilaian);
            },
            error: function (err) {
                console.log('error', err);
            }
        });
    }

    $(".btn-detil").each(function (index) {
        $(this).on("click", function () {
            getDetil($(this).data('idform'), $(this).data('id'));
        })
    });

    function getDetilFormPenilaian($id_form_penilaian) {
        $.ajax({
            url: "{{ url('get_ubah_detil_form_penilaian') }}/" + $id_form_penilaian,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                console.log(res);
                // $('input[name*="id_ubah"]').val(res['id_penilaian']);
                // $('input[name*="keterangan_penilaian_ubah"]').val(res['keterangan_penilaian']);
                // $('input[name*="keterangan_penilaian_ubah"]').val(res['keterangan_penilaian']);

                // for (let $i=0; $i<res['karyawan'].length; $i++) {
                //     if(res['karyawan'][$i]['id_karyawan']==res['karyawan_id_karyawan']){
                //         $('select[name*="karyawan_ubah"]').append('<option selected value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['karyawan'][$i]['nama']+'</option>');    
                //     }else{
                //         $('select[name*="karyawan_ubah"]').append('<option value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['karyawan'][$i]['nama']+'</option>');    
                //     }
                // }

                // $('select[name*="tipe_penilaian_ubah"]').html('');
                // const status_tipe_penilaians = ['hadir', 'izin', 'telat', 'bolos', 'penilaian'];
                // for (let $i=0; $i<status_tipe_penilaians.length; $i++) {
                //     if(status_tipe_penilaians[$i]==res['tipe_penilaian']){
                //         $('select[name*="tipe_penilaian_ubah"]').append('<option selected value="'+res['tipe_penilaian']+'">'+res['tipe_penilaian']+'</option>');
                //     }else{
                //         $('select[name*="tipe_penilaian_ubah"]').append('<option value="'+status_tipe_penilaians[$i]+'">'+status_tipe_penilaians[$i]+'</option>');
                //     }
                // }

                // $('select[name*="status_hari_ubah"]').html('');
                // const status_haris = ['masuk', 'libur'];
                // for (let $i=0; $i<status_haris.length; $i++) {
                //     if(status_haris[$i]==res['tipe_penilaian']){
                //         $('select[name*="status_hari_ubah"]').append('<option selected value="'+res['status_hari']+'">'+res['status_hari']+'</option>');
                //     }else{
                //         $('select[name*="status_hari_ubah"]').append('<option value="'+status_haris[$i]+'">'+status_haris[$i]+'</option>');
                //     }
                // }
            }
        });
    }

    function changePage() {
        var $year = $('#year').find(":selected").val();
        var $month = $('#month').find(":selected").val();
        // console.log('DEBUGGG >>', $year, month);
        var url = "{{ route('penilaian.with.date') }}";

        $.ajax({
            url,
            data: {
                date: `${$year}-${$month}`,
            },
            type: 'get',
            success: function (res) {
                console.log('sucess = ', this.url);
                window.location.href = this.url;
                pageloader();
            }
        });
    }

</script>
@endsection
