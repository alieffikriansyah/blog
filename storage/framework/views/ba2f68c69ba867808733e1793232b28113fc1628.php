

<?php $__env->startSection('content'); ?>

<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Jabatan</h4>
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
                    <th>Nama Jabatan</th>
                    <th>Nilai Bonus Gaji Jabatan</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                <?php $__currentLoopData = $jabatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i); ?></td>
                    <td><?php echo e($jab->nama_jabatan); ?></td>
                    <td><?php echo e($jab->nilai_bonus_gaji); ?>%</td>
                    <td style="text-align:center;">
                    <button type="button" class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="<?php echo e($jab->id_jabatan); ?>"> <i class="fa fa-edit"></i> Ubah</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light btn-delete" data-id="<?php echo e($jab->id_jabatan); ?>"> <i class="fa fa-trash"></i> Hapus</button>
                    </td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
      <h5 class="modal-title">Tambah Data Jabatan Baru</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form method="POST" name="tbhJabatan" action="<?php echo e(route('jabatan.tambah')); ?>">
              <?php echo e(csrf_field()); ?>

              <div class="form-group">
                  <label for="input-1">Nama Jabatan<span style="color: #ff5252;">*</span></label>
                  <input type="text" class="form-control" id="input-1" required name="nama_jabatan" placeholder="Nama Jabatan....">
              </div>

              <div class="form-group">
                  <label for="input-2">Nilai Bonus Gaji Jabatan<span style="color: #ff5252;">*</span></label>
                  <input type="text"  min="0" step="0.01" class="form-control" id="input-2" required name="nilai_bonus_gaji" placeholder="Nilai Bonus Gaji Jabatan....">
              </div>

              <small style="color: #ff5252;">* Wajib Diisi</small>
              <div class="btn-group float-sm-right mt-2">
                  <button onclick="validateForm('ubhJabatan','nama_jabatan,nilai_bonus_gaji')" type="submit" class="btn btn-success px-5">Simpan</button>
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
      <h5 class="modal-title">Ubah Data Jabatan</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form method="POST" name="ubhJabatan" action="<?php echo e(route('jabatan.ubah')); ?>">
              <?php echo e(csrf_field()); ?>

              <input type="hidden" name="id_ubah">
              <div class="form-group">
                  <label for="input-11">Nama Jabatan<span style="color: #ff5252;">*</span></label>
                  <input type="text" class="form-control" required id="input-11" name="nama_jabatan_ubah" placeholder="Nama Jabatan....">
              </div>
              <div class="form-group">
                  <label for="input-12">Nilai Bonus Gaji Jabatan<span style="color: #ff5252;">*</span></label>
                  <input type="number" min="0" step="0.01" class="form-control" required id="input-12" name="nilai_bonus_gaji_ubah" placeholder="Nilai Bonus Gaji Jabatan....">
              </div>
              <small style="color: #ff5252;">* Wajib Diisi</small>
              <div class="btn-group float-sm-right mt-2">
                  <button onclick="validateForm('ubhJabatan','nama_jabatan_ubah,nilai_bonus_gaji_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
              </div>
          </form>
      </div>
  </div>
  </div>
</div>
<!-- End Modal -->
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('script'); ?>
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

function ubah($id_jabatan) {
    $.ajax({
        url: "<?php echo e(url('get_ubah_jabatan')); ?>/"+$id_jabatan,
        type: 'get',
        dataType: 'json',
        success: function(res){
            $('input[name*="id_ubah"]').val(res['id_jabatan']);
            $('input[name*="nama_jabatan_ubah"]').val(res['nama_jabatan']);
            $('input[name*="nilai_bonus_gaji_ubah"]').val(res['nilai_bonus_gaji']);
        }
    });
}

$( ".btn-edit" ).each(function(index) {
    $(this).on("click", function(){
       ubah($(this).data('id'));
    });
});

function hapus($id_jabatan){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="<?php echo e(url('hapus_jabatan')); ?>/"+$id_jabatan;
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
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SMT 10\TA\Program\cobabaru\blog\resources\views/jabatan.blade.php ENDPATH**/ ?>