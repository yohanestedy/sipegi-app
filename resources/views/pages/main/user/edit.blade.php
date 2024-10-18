@extends('layout.main', ['title' => 'Edit User'])

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">

                    <h3>Edit Data Petugas</h3>
                    <p class="text-subtitle text-muted">
                        Isi form untuk mengedit akun petugas.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">User Management</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Data User
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="first-name-horizontal">Nama</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="text" id="first-name-horizontal"
                                            class="form-control form-control-lg" name="name" placeholder="Nama">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="contact-info-horizontal">Posyandu</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <select class="form-select">
                                            <option value="">--Pilih Posyandu--</option>
                                            <option value="">Posyandu 1</option>
                                            <option value="">Posyandu 2</option>
                                            <option value="">Posyandu 3</option>
                                            <option value="">Posyandu 4</option>
                                            <option value="">Posyandu 5</option>
                                            <option value="">Posyandu 6</option>


                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email-horizontal">Username</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="text" id="email-horizontal" class="form-control form-control-lg"
                                            name="username" placeholder="Username">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="password-horizontal">Password</label>
                                    </div>
                                    <div class="col-md-9 form-group mb-3">
                                        <input type="password" id="password-horizontal" class="form-control form-control-lg"
                                            name="password" placeholder="Password">
                                    </div>

                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-3 mb-1">Simpan</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
