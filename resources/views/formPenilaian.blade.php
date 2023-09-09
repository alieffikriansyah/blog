@extends('layouts.dashboard')
@section('content')
<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Penilaian</h4>
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
                        <th>Nama Form Penilaian</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($formPenilaian as $fp)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$fp->nama_form_penilaian}}</td>
                        <td style="text-align:center;">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-edit-detil" data-toggle="modal" data-target="#modaldetil" data-id="{{$fp->idform_penilaian}}" > <i class="fa fa-plus"></i>Detil Form</button>
                        <button type="button" class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="{{$fp->idform_penilaian}}"> <i class="fa fa-edit"></i> Ubah</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light btn-delete" data-id="{{$fp->idform_penilaian}}"> <i class="fa fa-trash"></i> Hapus</button>
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
        <h5 class="modal-title">Tambah Data Form Penilaian Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhFormPenilaian" action="{{ route('form_penilaian.tambah') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="input-1">Nama Form Penilaian<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" id="input-1" required name="nama_form_penilaian" placeholder="Nama Form Penilaian....">
                </div>

                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('tbhFormPenilaian','nama_form_penilaian')" type="submit" class="btn btn-success px-5">Simpan</button>
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
        <h5 class="modal-title">Ubah Data Form Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="ubhFormPenilaian" action="{{ route('form_penilaian.ubah') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id_form_penilaian_ubah">
                <div class="form-group">
                    <label for="input-11">Nama Form Penilaian<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required id="input-11" name="nama_form_penilaian_ubah" placeholder="Nama Form Penilaian....">
                </div>
                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhFormPenilaian','nama_form_penilaian_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="modaldetil">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detil Form Penilaian</h5>
            <div class="col-sm-3">
                <div class="btn-group float-sm-right">
                    <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambahdetil"> <i class="fa fa fa-plus"></i> Tambah Indikator</button>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="background: #e3e8ec !important;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="default-datatable-detil-form" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Kriteria</th>
                                        <th>Nama Indikator</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                             
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

<div class="modal fade" id="modaltambahdetil">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Tambah Detil Form Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhDetilFormPenilaian" action="{{ route('detil_form_penilaian.tambah') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id_form_penilaian_tambah">
                <div class="form-group">
                    <label>Indikator<span style="color: #ff5252;">*</span></label>
                    <select class="form-control" name="indikator" required>
                        @foreach ($indikator as $d)
                            <option value="{{ $d->id_indikator }}">{{ $d->nama_kriteria }} - {{ $d->nama_indikator }}</option>
                        @endforeach
                    </select>
                </div>

                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhFormPenilaian','indikator')" type="submit" class="btn btn-success px-5">Simpan</button>
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
{{-- <script src="asset/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/jszip.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
<script src="asset/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script> --}}

<script>
//   $('#default-datatable').DataTable();
//   $('#default-datatable-detil-form').DataTable();
$(document).ready(function() {
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
  $( ".btn-edit" ).each(function(index) {
    $(this).on("click", function(){
       ubah($(this).data('id'));
        // alert('oke');
    });
});
  function ubah($idform_penilaian) {
      $.ajax({
          url: "{{ url('get_ubah_form_penilaian') }}/"+$idform_penilaian,
          type: 'get',
          dataType: 'json',
          success: function(res){
              $('input[name*="id_form_penilaian_ubah"]').val($idform_penilaian);
              $('input[name*="nama_form_penilaian_ubah"]').val(res['nama_form_penilaian']);
          }
      });
  }
  $( ".btn-delete" ).each(function(index) {
    $(this).on("click", function(){
       hapus($(this).data('id'));
     
  
    });
});
function hapus($idform_penilaian){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="{{url('hapus_form_penilaian')}}/"+$idform_penilaian;
            pageloader();
        } 
    });
}
  $( ".btn-edit-detil" ).each(function(index) {
    $(this).on("click", function(){
       getDetil($(this).data('id'));
    });
});


  function getDetil($idform_penilaian) {
    $('#default-datatable-detil-form tbody tr').remove();
      $.ajax({
          url: "{{ url('get_ubah_detil_form_penilaian') }}/"+$idform_penilaian,
          type: 'get',
          dataType: 'json',
          success: function(data){
            // console.log('data ', data);
            data.forEach(item => {
                $('#default-datatable-detil-form tbody').append(
                    `<tr>
                        <td>${item.nama_kriteria}</td>
                        <td>${item.nama_indikator}</td>
                        <td><button data-id='{{ '${item.id_detil_form_penilaian}' }}'" class="btn btn-danger waves-effect waves-light btn-delete-detil"> <i class="fa fa-trash"></i> Hapus</button></td>

                    </tr>`
                )
            });
              $('input[name*="id_form_penilaian_tambah"]').val($idform_penilaian);
              $( ".btn-delete-detil" ).each(function(index) {
    $(this).on("click", function(){
       hapusDetil($(this).data('id'));
   
    });
});
          },
          error : function(err) {
              console.log('error', err);
          }
      });

      
  }
  
  function hapusDetil($id_detil_form_penilaian){
      swal({ 
      title: "Apakah anda yakin ingin menghapus detil form?",
      text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      }).then((willDelete) => {
          if (willDelete) {
              window.location.href="{{url('hapus_detil_form_penilaian')}}/"+$id_detil_form_penilaian;
              pageloader();
          } 
      });
  }

})
</script>
@endsection