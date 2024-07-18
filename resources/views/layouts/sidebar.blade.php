   <!--start sidebar-->
   <aside class="sidebar-wrapper" data-simplebar="true">
       <div class="sidebar-header">
           <div class="logo-icon">
               <img src="{{ URL::asset('build/images/logo-indoneptune.png') }}" class="logo-img" alt="">
           </div>
           <div class="logo-name flex-grow-1">
               <span class="mb-0 fw-semibold">PT.INDONEPTUNE</span>
           </div>
           <div class="sidebar-close">
               <span class="material-icons-outlined">close</span>
           </div>
       </div>
       <div class="sidebar-nav">
           <!--navigation-->
           <ul class="metismenu" id="sidenav">
               <li>
                   <a href="{{ url('/dashboard') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">other_houses</i>
                       </div>
                       <div class="menu-title">Dashboard</div>
                   </a>
               </li>

               <li class="menu-label">data master</li>

               <li>
                   <a href="{{ url('/master/user') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">person_outline</i>
                       </div>
                       <div class="menu-title">Data User</div>
                   </a>
               </li>
               <li>
                   <a href="{{ url('/master/bahanbaku') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">view_in_ar</i>
                       </div>
                       <div class="menu-title">Data Bahan Baku</div>
                   </a>
               </li>
               <li>
                   <a href="{{ url('/master/departemen') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">maps_home_work</i>
                       </div>
                       <div class="menu-title">Data Departemen</div>
                   </a>
               </li>
               <li>
                   <a href="{{ url('/master/supplier') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">person_3</i>
                       </div>
                       <div class="menu-title">Data Supplier</div>
                   </a>
               </li>

               <li class="menu-label">Manajemen</li>

               <li>
                   <a href="{{ url('/manajemen/permintaan') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">note_add</i>
                       </div>
                       <div class="menu-title">Permintaan</div>
                   </a>
               </li>
               <li>
                   <a href="{{ url('/manajemen/pembelian') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">receipt_long</i>
                       </div>
                       <div class="menu-title">Pembelian</div>
                   </a>
               </li>

               <li>
                   <a href="{{ url('/pembelian') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">receipt_long</i>
                       </div>
                       <div class="menu-title">Pembelian</div>
                   </a>
               </li>

               <li class="menu-label">Laporan</li>

               <li>
                   <a href="{{ url('/permintaan') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">bookmarks</i>
                       </div>
                       <div class="menu-title">Permintaan</div>
                   </a>
               </li>
               <li>
                   <a href="{{ url('/pembelian') }}">
                       <div class="parent-icon"><i class="material-icons-outlined">collections_bookmark</i>
                       </div>
                       <div class="menu-title">Pembelian</div>
                   </a>
               </li>
           </ul>

           <!--end navigation-->
       </div>
   </aside>
   <!--end sidebar-->
