@extends('layouts.dashboard')

@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Kriteria</h4>
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
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach($kriteria as $krit)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$krit->nama_kriteria}}</td>
                   
                    <td style="text-align:center;">
                    <button type="button"  class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="{{$krit->id_kriteria}}"> Ubah</button>
                    <button type="button"  class="btn btn-danger waves-effect waves-light btn-delete" data-id="{{$krit->id_kriteria}}"> Hapus</button>
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
      <h5 class="modal-title">Tambah Data Kriteria Baru</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form method="POST" name="tbhKriteria" action="{{ route('kriteria.tambah') }}">
              {{ csrf_field() }}
              <div class="form-group">
                  <label for="input-1">Nama Kriteria<span style="color: #ff5252;">*</span></label>
                  <input type="text" class="form-control" id="input-1" required name="nama_kriteria" placeholder="Nama Kriteria....">
              </div>

              <small style="color: #ff5252;">* Wajib Diisi</small>
              <div class="btn-group float-sm-right mt-2">
                  <button onclick="validateForm('tbhKriteria','nama_kriteria')" type="submit" class="btn btn-success px-5">Simpan</button>
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
        <h5 class="modal-title">Ubah Data Kriteria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="ubhDepartemen" action="{{ route('kriteria.ubah') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id_kriteria_ubah">
                <div class="form-group">
                    <label for="input-11">Nama Kriteria<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-11" name="nama_kriteria_ubah" placeholder="Nama Kriteria....">
                </div>
                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhkriteria','nama_kriteria_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
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
//   $('#default-datatable').DataTable();

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

  function ubah($id_kriteria) {
      $.ajax({
          url: "{{ url('get_ubah_kriteria') }}/"+$id_kriteria,
          type: 'get',
          dataType: 'json',
          success: function(res){
            // alert($re);
            
              $('input[name*="id_kriteria_ubah"]').val($id_kriteria);
              $('input[name*="nama_kriteria_ubah"]').val(res['nama_kriteria']);
          }
      });
  }


  function hapus($id_kriteria){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="{{url('hapus_kriteria')}}/"+$id_kriteria;
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
     
</script>
@endsection