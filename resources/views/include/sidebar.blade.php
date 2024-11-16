<div id="sidebar">
    <div class="sidebar-wrapper active">

        {{-- SIDEBAR HEADER --}}
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">

                {{-- LOGO --}}
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/static/images/logo/sipegi-logo.svg') }}"
                            style="width: 90%; height: auto;" alt="Logo"></a>
                </div>

                {{-- LIGHT/DARK THEME --}}
                {{-- <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <i class="fa-regular fa-sun-bright fa-2xs"></i>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
                        <label class="form-check-label"></label>
                    </div>
                    <i class="fa-regular fa-moon-stars fa-2xs"></i>
                </div> --}}

                {{-- Toogle X medium-small view --}}
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        {{-- SIDEBAR MENU --}}
        <div class="sidebar-menu" style="margin-bottom: auto; min-height: 100vh">
            <ul class="menu" style="margin-top: -1rem;">
                <li class="sidebar-title">Menu</li>

                {{-- Dashboard --}}
                <li class="sidebar-item {{ Route::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="sidebar-link">
                        <i class="fa-duotone fa-solid fa-grid-2 fa-lg"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Master Data --}}
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="fa-duotone fa-solid fa-folders fa-lg"></i>
                        <span>Master Data</span>
                    </a>

                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="{{ route('masterdata.listposyandu') }}" class="submenu-link">Daftar Posyandu</a>
                        </li>

                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Standar Pertumbuhan Anak</a>
                        </li>

                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Ambang Batas Status Gizi Anak</a>
                        </li>
                    </ul>
                </li>

                {{-- Orangtua --}}
                <li class="sidebar-item {{ Route::is('orangtua.*') ? 'active' : '' }}">
                    <a href="{{ route('orangtua.index') }}" class="sidebar-link">
                        <i class="fa-duotone fa-solid fa-person-breastfeeding fa-lg"></i>
                        <span>Orangtua</span>
                    </a>
                </li>

                {{-- Balita --}}
                <li class="sidebar-item {{ Route::is('balita.*') ? 'active' : '' }} ">
                    <a href="{{ route('balita.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-children fa-lg"></i>
                        <span>Balita</span>
                    </a>
                </li>
                {{-- User Management --}}
                @if (Auth::user()->role == 'super_admin')
                    <li class="sidebar-item {{ Route::is('user.*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="sidebar-link">
                            {{-- <i class="fa-duotone fa-solid fa-users"></i> --}}
                            <i class="fa-duotone fa-solid fa-user-gear fa-lg" style="--fa-secondary-opacity: 0.5;"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                @endif

                {{-- Laporan --}}
                <li class="sidebar-item">
                    <a href="index.html" class="sidebar-link">
                        {{-- <i class="fa-duotone fa-solid fa-users"></i> --}}
                        <i class="fa-duotone fa-solid fa-file-circle-check fa-lg"></i>
                        <span>Laporan</span>
                    </a>
                </li>

                {{-- Info --}}
                <li class="sidebar-item">
                    <a href="index.html" class="sidebar-link">
                        <i class="fa-duotone fa-solid fa-circle-info fa-lg"></i>
                        <span>Info</span>
                    </a>
                </li>


            </ul>
        </div>

        <!-- Logout Button -->
        <div class="logout-container"
            style="position: sticky; bottom: 0; width: 100%; background-color: #f8f9fa; padding: 1rem;">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <div class="row">
                    <div class="col-7">
                        <label> <small>Login sebagai :</small></label>
                        <label>{{ auth()->user()->name }}</label>

                    </div>
                    <div class="col-5"><a type="submit" class="btn btn-danger w-65 swal-logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
