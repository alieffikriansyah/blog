@extends('layouts.dashboard')

@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="page-title">Sanksi <br> Bulan : {{$months}} <br> Tahun : {{$years}}</h4>
            <p class="card-description">
                Add class <code>.table-hover </code>
            </p>
            {{-- <div class="btn-group float-sm-right">
        <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
    </div> --}}
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
                                <th>Nama Karyawan</th>
                                <th>Foto</th>
                                <th>Tanggal Sanksi</th>
                                <th>Keterangan Sanksi</th>
                                @if (!Auth::user()->karyawan)
                                {{-- <th>pelapor</th> --}}
                                <th style="text-align:center;">Action</th>
                                @endif
                            </tr>
                        </thead>
                        @php $i=1; @endphp
                        @foreach($sanksi as $sank)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$sank->karyawan->user->name}}</td>
                            <td style="text-align:center;"><img style="border-radius: 0; width: 200px; height: 200px;"
                                    src="{{asset('gallery/' . $sank->foto)}}"></td>

                            <td>{{$sank->waktu_sanksi}}</td>
                            <td>{{$sank->keterangan_sanksi}}</td>
                             @if (!Auth::user()->karyawan)
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-warning waves-effect waves-light btn-edit"
                                    data-toggle="modal" data-target="#modalubah" data-id="{{$sank->id_sanksi}}">
                                    Ubah</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-delete"
                                    data-id="{{$sank->id_sanksi}}"> Hapus</button>
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
                    <h5 class="modal-title">Tambah Data Sanksi Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" name="tbhSanksi" action="{{ route('sanksi.tambah') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!-- karyawan -->
                        <div class="form-group">
                            <label>Karyawan<span style="color: #ff5252;">*</span></label>
                            <select class="form-control" name="karyawan" required>
                                @foreach ($karyawan as $d)
                                <option value="{{ $d->id_karyawan }}">{{ $d->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>foto<span style="color: #ff5252;">*</span></label>
                            <input type="file" name="foto" class="dropify" required>
                        </div>
                        <div class="form-group">
                            <label for="input-1">Tanggal Sanksi<span style="color: #ff5252;">*</span></label>
                            <input type="datetime-local" class="form-control" id="input-1" required name="waktu_sanksi"
                                placeholder="yyyy-mm-dd">
                        </div>

                        <div class="form-group">
                            <label for="input-2">Keterangan Sanksi<span style="color: #ff5252;">*</span></label>
                            <input type="text" class="form-control" id="input-2" required name="keterangan_sanksi"
                                placeholder="Keterangan Sanksi....">
                        </div>
{{--                     
                        @if (!Auth::user()->karyawan)
                        <div class="form-group">
                            <label>Pelapor<span style="color: #ff5252;">*</span></label>
                            <select class="form-control" name="user"@if (Auth::user()->admin)
                                readonly
                            @endif required>
                                @foreach ($user as $j)
                                <option value="{{ $j->id }}">{{ $j->name }}</option>
                                @endforeach

                        </div>
                        @endif --}}
                        <small style="color: #ff5252;">* Wajib Diisi</small>
                        <div class="btn-group float-sm-right mt-2">
                            <button onclick="validateForm('tbhSanksi','foto','waktu_sanksi', 'keterangan_sanksi')"
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
                    <h5 class="modal-title">Ubah Data Sanksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" name="ubhSanksi" action="{{ route('sanksi.ubah') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Karyawan<span style="color: #ff5252;">*</span></label>
                            <select class="form-control" name="karyawan_ubah" required>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>foto<span style="color: #ff5252;">*</span></label>
                            <input type="file" name="foto" id="gambar_ubah" class="dropify" required>
                        </div>
                        <div class="form-group">
                            <label for="input-11">Waktu Sanksi<span style="color: #ff5252;">*</span></label>
                            <input type="datetime-local" class="form-control" required id="input-11"
                                name="waktu_sanksi_ubah" placeholder="yyyy-mm-dd">
                        </div>

                        <input type="hidden" name="id_sanksi_ubah">
                        <div class="form-group">
                            <label for="input-12">Keterangan Sanksi<span style="color: #ff5252;">*</span></label>
                            <input type="text" class="form-control" required id="input-12" name="keterangan_sanksi_ubah"
                                placeholder="Keterangan Sanksi....">
                        </div>
                        {{-- @if (!Auth::user()->karyawan)
                        <select class="form-control" name="user" required>


                            @foreach ($user as $j)
                            <option value="{{$j->id }}">{{ $j->name }}</option>

                            @endforeach

                        </select>
                        @endif --}}
                        <small style="color: #ff5252;">* Wajib Diisi</small>
                        <div class="btn-group float-sm-right mt-2">
                            <button
                                onclick="validateForm('ubhSanksi', 'gambar_ubah','waktu_sanksi_ubah','keterangan_sanksi_ubah')"
                                type="submit" class="btn btn-warning px-5">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        @endsection

        @section('script')
        <!--Data Tables js-->
        {{-- <script src="assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/bootstrap-datepicker.min.js"></script> --}}

        <script>
            $(document).ready(function () {


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
                        const fi = document.forms[$formx][$inputs[0]];
                        const fsize = fi.files[0].size;
                        const file = Math.round((fsize / 1024));

                        if (file > 2048) {
                            alert(
                                'File yang diupload terlalu besar, mohon ikuti petunjuk ukuran gambar yang ada');
                        } else {
                            document.forms[$formx].submit();
                            pageloader();
                        }

                    } else {
                        for (let i = 0; i < $inputs.length; i++) {
                            if (i != 0) {
                                $isi = document.forms[$formx][$inputs[i]].value;
                                if ($isi == "") {
                                    alert($inputs[i].toUpperCase() + " tidak boleh kosong!");
                                    $loader = false;
                                    return false;
                                }
                            }
                        }

                        if ($valid) {
                            if (document.forms[$formx][$inputs[0]].value != "") {
                                const fi = document.forms[$formx][$inputs[0]];
                                const fsize = fi.files[0].size;
                                const file = Math.round((fsize / 1024));

                                if (file > 2048) {
                                    alert(
                                        'File yang diupload terlalu besar, mohon ikuti petunjuk ukuran gambar yang ada'
                                    );
                                } else {
                                    document.forms[$formx].submit();
                                    pageloader();
                                }
                            } else {
                                document.forms[$formx].submit();
                                pageloader();
                            }
                        }

                        // if($valid){
                        //     pageloader();
                        // }

                    }
                }



                function changePage() {
                    var $year = $('#year').find(":selected").val();
                    var $month = $('#month').find(":selected").val();
                    // alert($year + $month);


                    console.log('DEBUGGG >>', $year, $month);

                    var url = "{{ route('sanksi') }}";

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
                            // alert('ok');
                        }
                    });
                }

                function ubah($id_sanksi) {
                    $.ajax({
                        url: "{{ url('get_ubah_sanksi') }}/" + $id_sanksi,
                        type: 'get',
                        dataType: 'json',
                        success: function (res) {
                            $('input[name*="id_sanksi_ubah"]').val(res['id_sanksi']);
                            $('input[name*="keterangan_sanksi_ubah"]').val(res[
                            'keterangan_sanksi']);
                            $('input[name*="waktu_sanksi_ubah"]').val(res['waktu_sanksi']);
                            $('select[name*="karyawan_ubah"]').html('');
                            for (let $i = 0; $i < res['karyawan'].length; $i++) {
                                for (let $j = 0; $j < res['user'].length; $j++) {
                                    if (res['karyawan'][$i]['user_id_user'] == res['user'][$j][
                                        'id']) {
                                        if (res['karyawan'][$i]['id_karyawan'] == res[
                                                'karyawan_id_karyawan']) {
                                            $('select[name*="karyawan_ubah"]').append(
                                                '<option selected value="' + res['karyawan'][$i]
                                                [
                                                    'id_karyawan'
                                                ] + '">' + res['user'][$j]['name'] + '</option>'
                                                );
                                        } else {
                                            $('select[name*="karyawan_ubah"]').append(
                                                '<option value="' +
                                                res['karyawan'][$i]['id_karyawan'] + '">' + res[
                                                    'user'][
                                                    $j
                                                ]['name'] + '</option>');

                                        }
                                    }
                                }
                            }
                            // $('select[name*="pelapor_ubah"]').html('');
                        }
                    });
                }
                $(".btn-delete").each(function (index) {
                    $(this).on("click", function () {
                        hapus($(this).data('id'));
                        alert('ok');
                    });
                });




                function hapus($id_sanksi) {
                    swal({
                        title: "Apakah anda yakin?",
                        text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            window.location.href = "{{url('hapus_sanksi')}}/" + $id_sanksi;
                            pageloader();
                        }
                    });
                }


                $(".btn-edit").each(function (index) {
                    $(this).on("click", function () {
                        ubah($(this).data('id'));
                    });
                });



            })

            function changePage() {
                    var $year = $('#year').find(":selected").val();
                    var $month = $('#month').find(":selected").val();
                    // alert($year + $month);


                    console.log('DEBUGGG >>', $year, $month);

                    var url = "{{ route('sanksi') }}";

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
                            // alert('ok');
                        }
                    });
                }

        </script>
        @endsection
