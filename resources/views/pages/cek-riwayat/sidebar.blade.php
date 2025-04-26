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
                <li class="sidebar-item {{ Route::is('riwayat.show') ? 'active' : '' }}">
                    <a href="{{ route('riwayat.show') }}" class="sidebar-link">
                        <i class="fa-duotone fa-solid fa-grid-2 fa-lg"></i>
                        <span>Riwayat</span>
                    </a>
                </li>


                {{-- Info --}}
                {{-- <li class="sidebar-item">
                    <a href="index.html" class="sidebar-link">
                        <i class="fa-duotone fa-solid fa-circle-info fa-lg"></i>
                        <span>Info</span>
                    </a>
                </li> --}}


            </ul>
        </div>



        <style>
            /* Default styling for larger screens */
            .logout-container {
                position: sticky;
                bottom: 0;
                width: 100%;
                background-color: #f8f9fa;
                padding: 1rem;
                height: auto;
                /* Default height */
            }

            /* Styling for mobile screens (max-width 768px) */
            @media (max-width: 768px) {
                .logout-container {
                    height: 20vh;
                    /* Untuk Iphone */
                }
            }

            @media (max-width: 360px) {
                .logout-container {
                    height: 17vh;
                    /* Apply 15vh height for entry-level Android devices */
                }
            }
        </style>

        <!-- Logout Button -->
        <div class="logout-container">
            <form id="logout-form" action="{{ route('riwayat.keluar') }}" method="GET" style="display: inline;">
                @csrf
                <div class="row">
                    {{-- <div class="col-7">
                        <label> <small>Login sebagai :</small></label>

                    </div> --}}
                    <div class="col-5">
                        <a type="submit" class="btn btn-danger w-65 swal-logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </a>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
