@extends('layouts.dashboard')

@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Sanksi</h4>
        <p class="card-description">
          Add class <code>.table-hover</code>
        </p>
        <div class="btn-group float-sm-right">
            <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width:5px;">No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal Sanksi</th>
                    <th>Keterangan Sanksi</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
                @php $i=1; @endphp
                @foreach($sanksi as $sank)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$sank->karyawan->nama}}</td>
                    <td>{{$sank->waktu_sanksi}}</td>
                    <td>{{$sank->keterangan_sanksi}}</td>
                    <td style="text-align:center;">
                    <button type="button"  class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="{{$sank->id_sanksi}}"> Ubah</button>
                    <button type="button"  class="btn btn-danger waves-effect waves-light btn-delete" data-id="{{$sank->id_sanksi}}"> Hapus</button>
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
        <h5 class="modal-title">Tambah Data Sanksi Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhSanksi" action="{{ route('sanksi.tambah') }}">
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
                    <label for="input-1">Tanggal Sanksi<span style="color: #ff5252;">*</span></label>
                    <input type="datetime-local" class="form-control" id="input-1" required name="waktu_sanksi" placeholder="yyyy-mm-dd">
                </div>

                <div class="form-group">
                    <label for="input-2">Keterangan Sanksi<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-2" required name="keterangan_sanksi" placeholder="Keterangan Sanksi....">
                </div>

                

                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhSanksi','waktu_sanksi', 'keterangan_sanksi')" type="submit" class="btn btn-success px-5">Simpan</button>
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
            <form method="POST" name="ubhSanksi" action="{{ route('sanksi.ubah') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan_ubah" required>
                        
                        </select>
                </div>
        
                <div class="form-group">
                    <label for="input-11">Waktu Sanksi<span style="color: #ff5252;">*</span></label>
                    <input type="datetime-local" class="form-control" required id="input-11" name="waktu_sanksi_ubah" placeholder="yyyy-mm-dd">
                </div>

                <input type="hidden" name="id_sanksi_ubah">
                <div class="form-group">
                    <label for="input-12">Keterangan Sanksi<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-12" name="keterangan_sanksi_ubah" placeholder="Keterangan Sanksi....">
                </div>
                
                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhSanksi', 'waktu_sanksi_ubah','keterangan_sanksi_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
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
$(document).ready(function() {
    // var minEl = $('#min');
    // var maxEl = $('#max');
 
    // Custom range filtering function
    // $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    //     var min = parseInt(minEl.val(), 10);
    //     var max = parseInt(maxEl.val(), 10);
    //     var age = parseFloat(data[3]) || 0; // use data for the age column
 
    //     if (
    //         (isNaN(min) && isNaN(max)) ||
    //         (isNaN(min) && age <= max) ||
    //         (min <= age && isNaN(max)) ||
    //         (min <= age && age <= max)
    //     ) {
    //         return true;
    //     }
 
    //     return false;
    // });

    // var table = $('#default-datatable').DataTable();

    // // Changes to the inputs will trigger a redraw to update the table
    // minEl.on('input', function () {
    //     table.draw();
    // });
    // maxEl.on('input', function () {
    //     table.draw();
    // });

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

    function ubah($id_sanksi) {
        $.ajax({
            url: "{{ url('get_ubah_sanksi') }}/"+$id_sanksi,
            type: 'get',
            dataType: 'json',
            success: function(res){
                $('input[name*="id_sanksi_ubah"]').val(res['id_sanksi']);
                $('input[name*="keterangan_sanksi_ubah"]').val(res['keterangan_sanksi']);
                $('input[name*="waktu_sanksi_ubah"]').val(res['waktu_sanksi']);
                $('select[name*="karyawan_ubah"]').html('');
                for (let $i=0; $i<res['karyawan'].length; $i++) {
                    if(res['karyawan'][$i]['id_karyawan']==res['karyawan_id_karyawan']){
                        $('select[name*="karyawan_ubah"]').append('<option selected value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['karyawan'][$i]['nama']+'</option>');    
                    }else{
                        $('select[name*="karyawan_ubah"]').append('<option value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['karyawan'][$i]['nama']+'</option>');    
                    }
                }
            }
        });
    }
    $( ".btn-delete" ).each(function(index) {
    $(this).on("click", function(){
       hapus($(this).data('id'));
    // alert('ok');
    });
});
function hapus($id_sanksi){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="{{url('hapus_sanksi')}}/"+$id_sanksi;
            pageloader();
        } 
    });
}

    // //DATEPICKER
    // $('#month_selector').datepicker({
    // "onSelect": function (date) {
    //     console.log(date)
    //     minDateFilter = new Date(date.getFullYear(), date.getMonth(), 1).getTime()
    //     maxDateFilter = new Date(date.getFullYear(), date.getMonth() + 1, 0).getTime()
    //     dataTable.draw()
    // }
    // }).keyup(function () {
    //     minDateFilter = new Date(this.value.getFullYear(), this.value.getMonth(), 1).getTime()
    //     maxDateFilter = new Date(this.value.getFullYear(), this.value.getMonth() + 1, 0).getTime()
    //     dataTable.draw()
    // })

    // // Date range filter
    // minDateFilter = "";
    // maxDateFilter = "";

    // $.fn.dataTableExt.afnFiltering.push(
    //     function(oSettings, aData, iDataIndex) {
    //     if (typeof aData._date == 'undefined') {
    //         aData._date = new Date(aData[0]).getTime();
    //     }

    //     if (minDateFilter && !isNaN(minDateFilter)) {
    //         if (aData._date < minDateFilter) {
    //         return false;
    //         }
    //     }

    //     if (maxDateFilter && !isNaN(maxDateFilter)) {
    //         if (aData._date > maxDateFilter) {
    //         return false;
    //         }
    //     }

    //     return true;
    //     }
    // )
    $( ".btn-edit" ).each(function(index) {
    $(this).on("click", function(){
       ubah($(this).data('id'));
    });
});



})

</script>
@endsection