@extends('layouts.dashboard')

@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Penjualan</h4>
        <p class="card-description">
          Add class <code>.table-hover</code>
        </p>
        @if (!Auth::user()->karyawan)
        <div class="btn-group float-sm-right">
            <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
        </div>
        @endif
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width:5px;">No</th>
                    <th>Nama Karyawan</th>
                    <th>Jenis Mobil</th>
                    <th>Merk</th>
                    <th>Unit</th>
                    <th>Harga</th>
                    <th>Tanggal Penjualan</th>
        @if (!Auth::user()->karyawan)
        <th style="text-align:center;">Action</th>
        @endif
                </tr>
            </thead>
                @php $i=1; @endphp
                @foreach($penjualan as $penj)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$penj->karyawan->user->name}}</td>
                    <td>{{$penj->jenis_mobil}}</td>
                    <td>{{$penj->merk}}</td>
                    <td>{{$penj->unit}}</td>
                    <td>{{$penj->harga}}</td>
                    <td>{{$penj->tanggal_penjualan}}</td>
        @if (!Auth::user()->karyawan)
        <td style="text-align:center;">
                    <button type="button"  class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="{{$penj->id_penjualan}}"> Ubah</button>
                    <button type="button"  class="btn btn-danger waves-effect waves-light btn-delete" data-id="{{$penj->id_penjualan}}"> Hapus</button>
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
        <h5 class="modal-title">Tambah Data Penjualan Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhPenjualan" action="{{ route('penjualan.tambah') }}">
                {{ csrf_field() }}
                <!-- karyawan -->
                <div class="form-group">
                    <label>Karyawan yang menjual<span style="color: #ff5252;">*</span></label>
                    <select class="form-control" name="karyawan" required>
                        @foreach ($karyawan as $d)
                            <option value="{{ $d->id_karyawan }}">{{ $d->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="input-1">Tanggal Penjualan<span style="color: #ff5252;">*</span></label>
                    <input type="datetime-local" class="form-control" id="input-1" required name="tanggal_penjualan" placeholder="yyyy-mm-dd">
                </div>

                <div class="form-group">
                    <label for="input-2">Jenis Mobil<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-2" required name="jenis_mobil" placeholder="jenis mobil....">
                </div>

                <div class="form-group">
                    <label for="input-2">Merk<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-2" required name="merk" placeholder="merk....">
                </div>

                <div class="form-group">
                    <label for="input-2">Harga<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-2" required name="harga" placeholder="harga....">
                </div>

                <div class="form-group">
                    <label for="input-2">Unit<span style="color: #ff5252;">*</span></label>
                    <input type="number" class="form-control" id="input-2" required name="unit" placeholder="unit....">
                </div>                

                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('tbhPenjual','tanggal_penjualan', 'jenis_mobil','merk','harga','unit')" type="submit" class="btn btn-success px-5">Simpan</button>
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
        <h5 class="modal-title">Ubah Data penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="ubhPenjualan" action="{{ route('penjualan.ubah') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan_ubah" required>
                        
                        </select>
                </div>
        
                <input type="hidden" name="id_penjualan_ubah">
                <div class="form-group">
                    <label for="input-11">Tanggal Penjualan<span style="color: #ff5252;">*</span></label>
                    <input type="datetime-local" class="form-control" required id="input-11" name="tanggal_penjualan_ubah" placeholder="yyyy-mm-dd">
                </div>

                <div class="form-group">
                    <label for="input-12">Jenis Mobil<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-12" name="jenis_mobil_ubah" placeholder="jenis mobil....">
                </div>
                <div class="form-group">
                    <label for="input-12">Merk<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-12" name="merk_ubah" placeholder="merk....">
                </div>
                <div class="form-group">
                    <label for="input-12">Unit<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-12" name="unit_ubah" placeholder="unit....">
                </div>
                <div class="form-group">
                    <label for="input-12">Harga<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-12" name="harga_ubah" placeholder="harga....">
                </div>
                
                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhPenjualan', 'tanggal_penjualan_ubah','jenis_mobil_ubah','merk_ubah','unit_ubah','harga_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
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

    function ubah($id_penjualan) {
        $.ajax({
            url: "{{ url('get_ubah_penjualan') }}/"+$id_penjualan,
            type: 'get',
            dataType: 'json',
            success: function(res){
                $('input[name*="id_penjualan_ubah"]').val(res['id_penjualan']);
                $('input[name*="jenis_mobil_ubah"]').val(res['jenis_mobil']);
                $('input[name*="merk_ubah"]').val(res['merk']);
                $('input[name*="unit_ubah"]').val(res['unit']);
                $('input[name*="harga_ubah"]').val(res['harga']);
                $('input[name*="tanggal_penjualan_ubah"]').val(res['tanggal_penjualan']);
                $('select[name*="karyawan_ubah"]').html('');
                
                for (let $i=0; $i<res['karyawan'].length; $i++) {
                    for (let $j=0; $j<res['user'].length; $j++) {
                        if(res['karyawan'][$i]['user_id_user']==res['user'][$j]['id']){
                            if(res['karyawan'][$i]['id_karyawan']==res['karyawan_id_karyawan']){
                                $('select[name*="karyawan_ubah"]').append('<option selected value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['user'][$j]['name']+'</option>'); 
                            }else{
                                $('select[name*="karyawan_ubah"]').append('<option value="'+res['karyawan'][$i]['id_karyawan']+'">'+res['user'][$j]['name']+'</option>'); 
                            
                            }
                        }
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
function hapus($id_penjualan){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="{{url('hapus_penjualan')}}/"+$id_penjualan;
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