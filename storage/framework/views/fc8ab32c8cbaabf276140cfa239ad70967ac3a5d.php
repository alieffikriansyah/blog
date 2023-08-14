

<?php $__env->startSection('content'); ?>
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
                <?php $i=1; ?>
                <?php $__currentLoopData = $sanksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i); ?></td>
                    <td><?php echo e($sank->karyawan->nama); ?></td>
                    <td><?php echo e($sank->waktu_sanksi); ?></td>
                    <td><?php echo e($sank->keterangan_sanksi); ?></td>
                    <td style="text-align:center;">
                    <button type="button"  class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="<?php echo e($sank->id_sanksi); ?>"> Ubah</button>
                    <button type="button"  class="btn btn-danger waves-effect waves-light btn-delete" data-id="<?php echo e($sank->id_sanksi); ?>"> Hapus</button>
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
        <h5 class="modal-title">Tambah Data Sanksi Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="tbhSanksi" action="<?php echo e(route('sanksi.tambah')); ?>">
                <?php echo e(csrf_field()); ?>

                <!-- karyawan -->
                <div class="form-group">
                    <label>Karyawan<span style="color: #ff5252;">*</span></label>
                    <select class="form-control" name="karyawan" required>
                        <?php $__currentLoopData = $karyawan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($d->id_karyawan); ?>"><?php echo e($d->nama); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <form method="POST" name="ubhSanksi" action="<?php echo e(route('sanksi.ubah')); ?>">
                <?php echo e(csrf_field()); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!--Data Tables js-->
  

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
            url: "<?php echo e(url('get_ubah_sanksi')); ?>/"+$id_sanksi,
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
            window.location.href="<?php echo e(url('hapus_sanksi')); ?>/"+$id_sanksi;
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SMT 10\TA\Program\cobabaru\blog\resources\views/sanksi.blade.php ENDPATH**/ ?>