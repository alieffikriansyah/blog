@extends('layouts.dashboard')

@section('content')
<!--Data Tables -->
<link href="assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
  <link href="assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">


@if (!Auth::user()->karyawan)
<div class="row pt-2 pb-3">
    <div class="col-sm-9 pt-2">
        <h4 class="page-title">Dashboard</h4>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p class="text-primary mb-3">Total Karyawan Saat Ini <span class="float-right" id="span_karyawan"></span></p>
                <h3 class="mb-0 pb-0 text-primary text-center" id="span_total_karyawan">{{ $total_karyawan }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p class="text-primary mb-3">Departemen Saat Ini <span class="float-right" id="span_departemen"></span></p>
                <h3 class="mb-0 pb-0 text-primary text-center" id="span_total_departemen">{{ $total_departemen }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p class="text-primary mb-3">Total Sanksi bulan ini <span class="float-right" id="span_sanksi"></span></p>
                <h3 class="mb-0 pb-0 text-primary text-center" id="span_total_sanksi">{{ $total_sanksi }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="text-primary mb-3">Presensi hari ini <span class="float-right" id="span_penjualan"></span></p>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="default-datatable-absen" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5px;">No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Tanggal dan Waktu Presensi</th>
                                                        <th>Tipe Presensi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i=1; @endphp
                                                    @foreach($absenPerDay as $absen)
                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td>{{$absen->name}}</td>
                                                        <td>{{$absen->tanggaldanwaktu_absensi}}</td>
                                                        <td>{{$absen->tipe_absensi}}</td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                    @endforeach
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
        <div class="card">
            <div class="card-body">
                <p class="text-primary mb-3">Sanksi bulan ini <span class="float-right" id="span_penjualan"></span></p>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="default-datatable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width:5px;">No</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Tanggal Sanksi</th>
                                                    <th>Keterangan Sanksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @foreach($sanksiPerMonth as $jab)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$jab->name}}</td>
                                                    <td>{{$jab->waktu_sanksi}}</td>
                                                    <td>{{$jab->keterangan_sanksi}}</td>
                                                </tr>
                                                @php $i++; @endphp
                                                @endforeach
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

    <div class="col-xl-15">
        <div class="card">
            <div class="card-body">
                <p class="text-primary mb-3">Daftar karyawan yang cuti bulan ini <span class="float-right" id="span_absensi"></span></p>      
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="default-datatable-cuti-bulan-ini" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width:5px;">No</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Tanggal Mulai Cuti</th>
                                                    <th>Tanggal Selesai Cuti</th>
                                                    <th>Keterangan Cuti</th>
                                                    <th>Status Cuti</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @foreach($cutiPerMonth as $cuti)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$cuti->name}}</td>
                                                    <td>{{$cuti->tanggal_mulai_cuti}}</td>
                                                    <td>{{$cuti->tanggal_selesai_cuti}}</td>
                                                    <td>{{$cuti->keterangan_cuti}}</td>
                                                    <td>{{$cuti->status_cuti}}</td>
                                                </tr>
                                                @php $i++; @endphp
                                                @endforeach
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
</div>
<div class="col-xl-15">
    <div class="card">
<div class="col-xl-15 grid-margin stretch-card flex-column">
    <h5 class="mb-2 text-titlecase mb-4">Total Penjualan per Bulan</h5>
    <canvas id="myChart" height="25%" width="100%"></canvas>
</div>
    </div>
</div>

@endif


@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
//   $('#default-datatable').DataTable();
// $('#default-datatable').DataTable();
    // $('#default-datatable-absen').DataTable();
    // $('#default-datatable-karyawan-terbaik').DataTable();
    // $('#default-datatable-cuti-bulan-ini').DataTable();

    var labels =  [];
    var dataPenjualan =  [];

    $.ajax({
          url: "{{ url('getPenjualanPerBulan') }}",
          type: 'get',
          dataType: 'json',
          success: function(res){
            console.log("test >>>>>>>>>>>>>" , res);
            console.log("tests >>>>>>>>>>>>>" , res['labels']);
            labels = res['labels'];
            dataPenjualan = res['data'];

            const data = {
                labels:   labels,
                datasets: [{
                label: 'Total Penjualan',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: dataPenjualan,
                }]
            };
        
            const config = {
                type: 'line',
                data: data,
                options: {}
            };
        
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
          },
          error: function(err) {
            console.log("err >>>", err);
          }
      });
    
  
      

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

  function ubah($id_departemen) {
      $.ajax({
          url: "{{ url('get_ubah_departemen') }}/"+$id_departemen,
          type: 'get',
          dataType: 'json',
          success: function(res){
            // alert($re);
            
              $('id_departemen').val($id_departemen);
              $('input[name*="nama_departemen_ubah"]').val(res['nama_departemen']);
          }
      });
  }


  function hapus($id_departemen){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="{{url('hapus_departemen')}}/"+$id_departemen;
            pageloader();
        } 
    });
}

  $( ".btn-edit" ).each(function(index) {
    $(this).on("click", function(){
       ubah($(this).data('id'));
    });
});

$( ".btn-delete" ).each(function(index) {
    $(this).on("click", function(){
       hapus($(this).data('id'));
    });
});

// function hapus($id_departemen){
//     Swal.fire({ 
//       title: "Apakah anda yakin?",
//       text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
//       icon: "warning",
//       buttons: true,
//       dangerMode: true,
//       }).then((result) => {
//           if (result.isConfirmed) {
//             //   pageloader();
//               console.log('test');
//               $.ajax({
                    
//                 url: "{{'hapus_departemen'}}/"+$id_departemen;
//                 type: "DELETE"
//                 cache: false;
//                 data: {
//                         "_token": token
//                     },
//                     success:function(response){
//                         Swal.fire({
//                             type: 'success',
//                             icon: 'success',
//                             title: `${response.message}`,
//                             showConfirmButton: false,
//                             timer: 3000
//                     });

//                     $(`#index_${$id_departemen}`).remove();
//                  }
//               })
//           } 
//       });
//   }

//   function hapus($id_departemen){
//     Swal.fire({
//             title: 'Apakah Kamu Yakin?',
//             text: "ingin menghapus data ini!",
//             icon: 'warning',
//             showCancelButton: true,
//             cancelButtonText: 'TIDAK',
//             confirmButtonText: 'YA, HAPUS!'
//         }).then((result) => {
//             if (result.isConfirmed) {

//                 console.log('test');

//                 //fetch to delete data
//                 $.ajax({

//                     url: `/posts/${post_id}`,
//                     type: "DELETE",
//                     cache: false,
//                     data: {
//                         "_token": token
//                     },
//                     success:function(response){ 

//                         //show success message
//                         Swal.fire({
//                             type: 'success',
//                             icon: 'success',
//                             title: `${response.message}`,
//                             showConfirmButton: false,
//                             timer: 3000
//                         });

//                         //remove post on table
//                         $(`#index_${post_id}`).remove();
//                     }
//                 });

                
//         )}
                
//             }

//   }
   
  
</script>
@endsection