@extends('layouts.dashboard')

@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="page-title">Penghargaan <br> Bulan : {{$months}} <br> Tahun : {{$years}}</h4>
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

                <table id="default-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5px;">No</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Bonus kehadiran, uang makan, dan transport</th>
                            <th>Jumlah Kehadiran</th>
                            <th>Nilai Sanksi</th>
                            <th>Jumlah Sanksi</th>
                            <th>Bonus Penilaian</th>
                            <th>Skor Penilaian</th>
                            <th>Bonus Penjualan</th>
                            <th>Jumlah Penjualan</th>
                            <th>Gaji Pokok</th>
                            <th>Bonus Gaji</th>
                            <th>Gaji Total</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1; @endphp
                        @foreach($result as $hasil)
                        <tr>
                            <td>{{$i}}</td>
                       
                            <td>{{$hasil->karyawan->name}}</td>
                            {{-- <td>{{$hasil->us}}</td> --}}
                           
                            <td>{{$hasil->karyawan->nama_departemen}}</td>
                            <td>{{$hasil->karyawan->nama_jabatan}}</td>
                            <td >
                                {{number_format($hasil->nilaiAbsen[0])}}
                            </td>
                            <td >
                                {{number_format($hasil->nilaiAbsen[1])}}
                            </td>
                            <td>{{$hasil->nilaiSanksi[0]}}%</td>
                            <td>{{$hasil->nilaiSanksi[1]}}</td>
                            <td>{{number_format($hasil->nilaiPenilaian[0])}}</td>
                            <td>{{number_format($hasil->nilaiPenilaian[1])}}</td>
                            <td>{{number_format($hasil->nilaiBonusPenjualan[0])}}</td>
                            <td>{{number_format($hasil->nilaiBonusPenjualan[1])}}</td>
                            <td>{{number_format($hasil->karyawan->gaji_pokok)}}</td>
                            <td>{{number_format(round($hasil->bonusGaji,0))}}</td>
                            <td>{{number_format($hasil->gajiTotal)}}</td>
                         
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


    function changePage() {
        var $year = $('#year').find(":selected").val();
        var $month = $('#month').find(":selected").val();
        // alert($year + $month);
    
    
        console.log('DEBUGGG >>', $year, $month);
        var url = "{{ route('penghargaan') }}";

        $.ajax({
            url,
            data: {
                date: `${$year}-${$month}`,
            },
            type: 'get',
            success: function (res) {
                // console.log('sucess = ', this.url);
                window.location.href = this.url;
                pageloader();
            }
        });
    }
   
    // $(".clickable-row").each(function (index) {
    //     $(this).on("click", function () {
    //         // ubah($(this).data("{{route('detailNilaiBonusKehadiran')}}"));
    //         var url = "{{route('detailNilaiBonusKehadiran')}}";
    //         window.location.href = this.url;
    //             pageloader();
    //     });
    // });


</script>
@endsection
