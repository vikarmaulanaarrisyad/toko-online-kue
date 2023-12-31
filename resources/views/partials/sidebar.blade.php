 <aside class="main-sidebar sidebar-light-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link bg-primary bg-light">

         <img src="{{ Storage::url($setting->logo_aplikasi ?? config('app.name')) }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">{{ $setting->nama_singkatan ?? config('app.name') }}</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 @if (auth()->user()->path_image == 'default.jpg')
                     <img src="{{ asset('assets/images/not.png') }}" class="img-circle elevation-2" alt="User Image">
                 @else
                     <img src="{{ Storage::url(auth()->user()->path_image ?? '') }}" class="img-circle elevation-2"
                         alt="User Image">
                 @endif
             </div>
             <div class="info">
                 <a href="javascript:void(0)" class="d-block">{{ auth()->user()->name }}</a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu"
                 data-accordion="false">

                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}"
                         class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>

                 @if (Auth()->user()->hasRole('admin'))
                     <li class="nav-item">
                         <a href="{{ route('satuan.index') }}"
                             class="nav-link {{ request()->is('satuan*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-list-alt"></i>
                             <p>
                                 Satuan Produk
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('kategori.index') }}"
                             class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-tags"></i>
                             <p>
                                 Kategori Produk
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('produk.index') }}"
                             class="nav-link {{ request()->is('produk*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-cube"></i>
                             <p>
                                 Produk
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">TRANSAKSI</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('dosen*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-check"></i>
                             <p>
                                 Konfirmasi Pesanan
                                 <span class="right badge badge-warning">0 New</span>
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('dosen*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-shopping-cart"></i>
                             <p>
                                 Pesanan
                                 <span class="right badge badge-success">0 New</span>
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">LAPORAN TRANSAKSI</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('kuisioner*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-file-pdf"></i>
                             <p>
                                 Report
                             </p>
                         </a>
                     </li>
                 @endif

                 @if (auth()->user()->hasRole('admin'))
                     <li class="nav-header">PENGATURAN APLIKASI</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('setting*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-cogs"></i>
                             <p>
                                 Setting
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">LAINYA</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-envelope"></i>
                             <p>
                                 Kontak Pesan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-comments"></i>
                             <p>
                                 Komentar
                             </p>
                         </a>
                     </li>
                 @endif
                 <li class="nav-header">MANAJEMEN AKUN</li>
                 <li class="nav-item">
                     <a href="" class="nav-link {{ request()->is('user/profile') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-user"></i>
                         <p>
                             Profil
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link {{ request()->is('user/profile/password') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-unlock"></i>
                         <p>
                             Ubah Password
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="javascript:void(0)" class="nav-link"
                         onclick="document.querySelector('#form-logout').submit()">
                         <i class="nav-icon fas fa-sign-in-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                     <form action="{{ route('logout') }}" method="post" id="form-logout">
                         @csrf
                     </form>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
