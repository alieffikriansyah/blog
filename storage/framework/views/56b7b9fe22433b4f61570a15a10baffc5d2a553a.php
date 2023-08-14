

<?php $__env->startSection('content'); ?>
<div class="col-lg grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="page-title">Absensi <br> Bulan : <?php echo e($months); ?> <br> Tahun : <?php echo e($years); ?></h4>
            <p class="card-description">
                Add class <code>.table-hover</code>
            </p>
            
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
                            <th>Tanggal</th>
                            <th>Jumlah Absensi</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        <?php $__currentLoopData = $arrDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($day); ?></td>
                            <td><?php echo e(count($allAbsenPerDay[$i-1])); ?></td>
                            <td style="text-align:center;">
                                <button type="button"  data-day="<?php echo e($day); ?>" data-arr="<?php echo e($arrTimes[$i-1]); ?>"
                                    class="btn btn-warning waves-effect waves-light btn-absen" data-toggle="modal"
                                    data-target="#modalabsen"> <i class="fa fa-edit"></i> Detail</button>
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

<div class="modal fade" id="modalabsen">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Absen Data Absensi</h5> -->
                <div class="row pt-2 pb-3">
                    <div class="col-sm-9 pt-1">
                        <h4 class="page-title">Absen Data Absensi</h4>
                    </div>
                    <div class="col-sm-3">
                        <div class="btn-group float-sm-right">
                            <button id="button-tambah-absen" type="button"
                                class="btn btn-success waves-effect waves-light m-1" data-toggle="modal"
                                data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="background: #e9edf1 !important;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="default-datatable-absen" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Karyawan</th>
                                                <th>Tanggal dan Waktu Absensi</th>
                                                <th>Tipe Absensi</th>
                                                <th>Keterangan Absensi</th>
                                                <th>Status Hari</th>
                                                
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- HOW TO MAKE THIS AJAX -->
                                            <!-- WILL BE HANDLED AJAX DONE hehe -->
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

<div class="modal fade" id="modaltambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Absensi Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="tbhAbsen" action="<?php echo e(route('absensi.tambah')); ?>">
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
                        <label>Tipe Absensi<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="tipe_absensi" required>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="telat">Telat</option>
                            <option value="bolos">Bolos</option>
                            <option value="cuti">Cuti</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-11">Keterangan Absensi</label>
                        <input type="text" class="form-control" id="input-12" name="keterangan_absensi"
                            placeholder="Keterangan Absensi....">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Tanggal dan Waktu Absensi<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required readonly
                            name="tanggaldanwaktu_absensi" placeholder="yyyy-mm-dd hh:mm:ss">
                    </div>

                    <div class="form-group">
                        <label>Status Hari<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="status_hari">
                            <option value="masuk">Masuk</option>
                            <option value="libur">Libur</option>
                        </select>
                    </div>

                    

                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button
                            onclick="validateForm('ubhAbsensi', 'karyawan', 'tipe_absensi', 'tanggaldanwaktu_absensi', 'tipe_absensi')"
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
                <h5 class="modal-title">Ubah Data Absen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="ubhAbsen" action="<?php echo e(route('absensi.ubah')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <label>Karyawan<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="karyawan_ubah" required>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Absensi<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="tipe_absensi_ubah" required>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-11">Keterangan Absensi<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-12" name="keterangan_absensi_ubah"
                            placeholder="Keterangan Absensi....">
                    </div>

                    <div class="form-group">
                        <label for="input-1">Tanggal dan Waktu Absensi<span style="color: #ff5252;">*</span></label>
                        <input type="text" class="form-control" id="input-1" required readonly
                            name="tanggaldanwaktu_absensi_ubah" placeholder="yyyy-mm-dd hh:mm:ss">
                    </div>

                    <div class="form-group">
                        <label>Status Hari<span style="color: #ff5252;">*</span></label>
                        <select class="form-control" name="status_hari_ubah" required>

                        </select>
                    </div>

                    <input type="hidden" name="id_ubah">
                    

                    <small style="color: #ff5252;">* Wajib Diisi</small>
                    <div class="btn-group float-sm-right mt-2">
                        <button onclick="validateForm('ubhAbsen', 'waktu_Absen_ubah','keterangan_Absen_ubah')"
                            type="submit" class="btn btn-warning px-5">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
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

    function absen($id_absensi) {
        $.ajax({
            url: "<?php echo e(url('get_ubah_absensi')); ?>/" + $id_absensi,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $('input[name*="id_absensi_absen"]').val(res['id_absensi']);
                $('input[name*="nama_absensi_absen"]').val(res['nama_absensi']);
            }
        });
    }

    
    $(".btn-absen").each(function (index) {
        $(this).on("click", function () {
            getAbsen($(this).data('day'), $(this).data('arr'));
        })
    });

    function getAbsen($day, $time) {
        $.ajax({
            url: "<?php echo e(url('get_absen_absensi')); ?>/" + $day,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('#default-datatable-absen tbody tr').remove();
                data.forEach(item => {
                    $('#default-datatable-absen tbody').append(
                        `<tr>
                        <td>${item.nama}</td>
                        <td>${item.tanggaldanwaktu_absensi}</td>
                        <td>${item.tipe_absensi}</td>
                        <td>${item.keterangan_absensi}</td>
                        <td>${item.status_hari}</td>
                        <td>
                            <button type="button" onclick="ubahAbsen('<?php echo e('${item.id_absensi}'); ?>')" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modalubah"> <i class="fa fa-edit"></i> Ubah</button>
                                            <button type="button" onclick="hapusAbsen('<?php echo e('${item.id_absensi}'); ?>')" class="btn btn-danger waves-effect waves-light"> <i class="fa fa-trash"></i> Hapus</button>    
                        </td>

                    </tr>`
                    )
                });
                console.log('TIME >>>>', $time);
                console.log('day >>>>', $day);
                var dateOffset = (24 * 60 * 60 * 1000) * 1; //1 days
                const currentDate = new Date();
                currentDate.setTime(currentDate.getTime() - dateOffset);
                const selectedDate = new Date($time);
                console.log('currentDate >>>>', currentDate);
                console.log('selectedDate >>>>', selectedDate);

                if (selectedDate < currentDate) {
                    console.log('test')
                    $("#button-tambah-absen").attr("disabled", true);
                } else {
                    $("#button-tambah-absen").attr("disabled", false);
                }
                $('input[name*="tanggaldanwaktu_absensi"]').val($time);
            },
            error: function (err) {
                console.log('error', err);
            }
        });
    }

    function ubahAbsen($id_absensi) {
        console.log('debug ubahAbsen >>>>', $id_absensi);
        $.ajax({
            url: "<?php echo e(url('get_ubah_absensi')); ?>/" + $id_absensi,
            type: 'get',
            dataType: 'json',
            success: function (res) {
                $('input[name*="id_ubah"]').val(res['id_absensi']);
                $('input[name*="keterangan_absensi_ubah"]').val(res['keterangan_absensi']);
                // $('input[name*="keterangan_cuti_ubah"]').val(res['keterangan_cuti']);

                for (let $i = 0; $i < res['karyawan'].length; $i++) {
                    if (res['karyawan'][$i]['id_karyawan'] == res['karyawan_id_karyawan']) {
                        $('select[name*="karyawan_ubah"]').append('<option selected value="' + res[
                                'karyawan'][$i]['id_karyawan'] + '">' + res['karyawan'][$i]['nama'] +
                            '</option>');
                    } else {
                        $('select[name*="karyawan_ubah"]').append('<option value="' + res['karyawan'][$i][
                            'id_karyawan'
                        ] + '">' + res['karyawan'][$i]['nama'] + '</option>');
                    }
                }

                $('select[name*="tipe_absensi_ubah"]').html('');
                const status_tipe_absensis = ['hadir', 'izin', 'telat', 'bolos', 'cuti'];
                for (let $i = 0; $i < status_tipe_absensis.length; $i++) {
                    if (status_tipe_absensis[$i] == res['tipe_absensi']) {
                        $('select[name*="tipe_absensi_ubah"]').append('<option selected value="' + res[
                            'tipe_absensi'] + '">' + res['tipe_absensi'] + '</option>');
                    } else {
                        $('select[name*="tipe_absensi_ubah"]').append('<option value="' +
                            status_tipe_absensis[$i] + '">' + status_tipe_absensis[$i] + '</option>');
                    }
                }

                $('select[name*="status_hari_ubah"]').html('');
                const status_haris = ['masuk', 'libur'];
                for (let $i = 0; $i < status_haris.length; $i++) {
                    if (status_haris[$i] == res['tipe_absensi']) {
                        $('select[name*="status_hari_ubah"]').append('<option selected value="' + res[
                            'status_hari'] + '">' + res['status_hari'] + '</option>');
                    } else {
                        $('select[name*="status_hari_ubah"]').append('<option value="' + status_haris[$i] +
                            '">' + status_haris[$i] + '</option>');
                    }
                }
            }
        });
    }

    function hapusAbsen($id_absensi) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "<?php echo e(url('hapus_absensi')); ?>/" + $id_absensi;
                pageloader();
            }
        });
    }


    function hapus($id_absensi) {
        swal({
            title: "Apakah anda yakin?",
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "<?php echo e(url('hapus_absensi')); ?>/" + $id_absensi;
            }
                pageloader();        });
    }

    function changePage() {
        var $year = $('#year').find(":selected").val();
        var month = $('#month').find(":selected").val();
        // console.log('DEBUGGG >>', $year, month);
        var url = "<?php echo e(route('absensi.with.date')); ?>";

        $.ajax({
            url,
            data: {
                date: `${$year}-${month}`,
            },
            type: 'get',
            success: function (res) {
                console.log('sucess = ', this.url);
                window.location.href = this.url;
                pageloader();            }
        });
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Arya\Downloads\cobabaru\cobabaru\blog\resources\views/absensi.blade.php ENDPATH**/ ?>