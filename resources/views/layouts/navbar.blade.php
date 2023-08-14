<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{route('home')}}">
          <i class="typcn typcn-device-desktop menu-icon"></i>
          <span class="menu-title">Dashboard</span>
          {{-- <div class="badge badge-danger">new</div> --}}
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
            {{-- <li class="{{ route::is('karyawan') ? 'active' : '' }}"><a href="{{route('karyawan')}}"><i class="zmdi zmdi-dot-circle-alt"></i> Karyawan</a></li> --}}
            <li class="nav-item"> <a class="nav-link" href="{{route('karyawan')}}"> Daftar Karyawan</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('departemen')}}"> Departemen </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('jabatan')}}"> Jabatan</a></li>
      

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
            <li class="nav-item"> <a class="nav-link" href="{{route('absensi')}}">Absensi</a></li>
             <li class="nav-item"> <a class="nav-link" href="{{route('pengajuanCuti')}}">Pengajuan Cuti</a></li>
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
            <li class="nav-item"><a class="nav-link" href="{{route('sanksi')}}">Sanksi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('kriteria')}}">Kriteria</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('indikator')}}">Indikator</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('form_penilaian')}}">Form Penilaian</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('penilaian')}}">Penilaian</a></li>
            {{-- <li class="nav-item"><a class="nav-link" href="{{route('penghargaan')}}">Penghargaan</a></li> --}}
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
  </nav>