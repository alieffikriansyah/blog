<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('home')); ?>">
          <i class="typcn typcn-device-desktop menu-icon"></i>
          <span class="menu-title">Dashboard</span>
          
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="typcn typcn-user-add-outline menu-icon"></i>
          <span class="menu-title">Struktur</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            
            <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('karyawan')); ?>"> Daftar Karyawan</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('departemen')); ?>"> Departemen </a></li>
            <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('jabatan')); ?>"> Jabatan</a></li>
      

          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
          <i class="typcn typcn-compass menu-icon"></i>
          <span class="menu-title">Kehadiran</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('absensi')); ?>">Absensi</a></li>
             <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('pengajuanCuti')); ?>">Pengajuan Cuti</a></li>
          </ul>
        </div>
      </li>
       
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="typcn typcn-film menu-icon"></i>
          <span class="menu-title">Penilaian Kinerja </span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('sanksi')); ?>">Sanksi</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('kriteria')); ?>">Kriteria</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('indikator')); ?>">Indikator</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('form_penilaian')); ?>">Form Penilaian</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo e(route('penilaian')); ?>">Penilaian</a></li>
            
          </ul>
        </div>
      </li>
    </li>
 
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
          <i class="typcn typcn-chart-pie-outline menu-icon"></i>
          <span class="menu-title">Penjualan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="charts">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">Penjulan Saat ini</a></li>
          </ul>
        </div>
      </li>

     
    
    </ul>
  </nav><?php /**PATH D:\SMT 10\TA\Program\cobabaru\blog\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>