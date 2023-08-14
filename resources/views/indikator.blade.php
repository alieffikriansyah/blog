@extends('layouts.dashboard')

@section('content')

<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Indikator</h4>
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
                    <th>Nama Kriteria</th>
                    <th>Nama Indikator</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach($indikator as $ind)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$ind->kriteria->nama_kriteria}}</td>
                    <td>{{$ind->nama_indikator}}</td>
                    <td style="text-align:center;">
                    <button type="button" class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="{{$ind->id_indikator}}"> <i class="fa fa-edit"></i>{{$ind->id_indikator}} Ubah</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light btn-delete" data-id="{{$ind->id_indikator}}"> <i class="fa fa-trash"></i> Hapus</button>
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
        <h5 class="modal-title">Tambah Data Indikator Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhIndikator" action="{{ route('indikator.tambah') }}">
                {{ csrf_field() }}
           

                <!-- kriteria -->
                <div class="form-group">
                    <label>Kriteria<span style="color: #ff5252;">*</span></label>
                    <select class="form-control" name="kriteria" required>
                        @foreach ($kriteria as $d)
                            <option value="{{ $d->id_kriteria }}">{{ $d->nama_kriteria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="input-1">Nama Indikator<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-1" required name="nama_indikator" placeholder="Nama Indikator....">
                </div>

                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('tbhIndikator','nama_indikator')" type="submit" class="btn btn-success px-5">Simpan</button>
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
      <h5 class="modal-title">Ubah Data Indikator</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <form method="POST" name="ubhIndikator" action="{{ route('indikator.ubah') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id_indikator_ubah">
            <div class="form-group">
                <label>Kriteria<span style="color: #ff5252;">*</span></label>
                    <select class="form-control" name="kriteria_ubah" required>
                    </select>
            </div>
            <div class="form-group">
                <label for="input-11">Nama Indikator<span style="color: #ff5252;">*</span></label>
                <input type="text" class="form-control" required id="input-11" name="nama_indikator_ubah" placeholder="Nama Indikator....">
            </div>
            
            <small style="color: #ff5252;">* Wajib Diisi</small>
            <div class="btn-group float-sm-right mt-2">
                <button onclick="validateForm('ubhIndikator','nama_indikator_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
            </div>
        </form>
    </div>
  </div>
  </div>
</div>
<!-- End Modal -->
  @endsection
  @section('script')
  <script>
$(document).ready(function() {
    // $('#default-datatable').DataTable();

function validateForm($formx, $inpux){

    $inputs = $inpux.split(',');
    $valid = true;

    console.log($inputs);
    console.log($inpux);
    console.log($formx);

    for (let i = 0; i < $inputs.length; i++) {
        console.log(i);
        console.log($inputs[i]);
        console.log($(`input[name*="${$inputs[i]}"]`).val());
        


        $isi = $(`input[name*="${$inputs[i]}"]`).val();
        
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

function ubah($id_indikator) {
    $.ajax({
        url: "{{ url('get_ubah_indikator') }}/"+$id_indikator,
        type: 'get',
        dataType: 'json',
        success: function(res){
                $('input[name*="id_indikator_ubah"]').val($id_indikator);
                $('input[name*="nama_indikator_ubah"]').val(res['nama_indikator']);
                $('select[name*="kriteria_ubah"]').html('');
                for (let $i=0; $i<res['kriteria'].length; $i++) {
                    if(res['kriteria'][$i]['id_kriteria']==res['kriteria_id_kriteria']){
                        $('select[name*="kriteria_ubah"]').append('<option selected value="'+res['kriteria'][$i]['id_kriteria']+'">'+res['kriteria'][$i]['nama_kriteria']+'</option>');    
                    }else{
                        $('select[name*="kriteria_ubah"]').append('<option value="'+res['kriteria'][$i]['id_kriteria']+'">'+res['kriteria'][$i]['nama_kriteria']+'</option>');    
                    }
                }
            }
    });
}

$( ".btn-edit" ).each(function(index) {
    $(this).on("click", function(){
       ubah($(this).data('id'));
    });
});

function hapus($id_indikator){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="{{url('hapus_indikator')}}/"+$id_indikator;
            pageloader();
        } 
    });
}

$( ".btn-delete" ).each(function(index) {
    $(this).on("click", function(){
       hapus($(this).data('id'));
    });
});

    
})
   
</script>
  @endsection