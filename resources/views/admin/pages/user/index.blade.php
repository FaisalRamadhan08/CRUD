@extends('admin.layouts.base')
@section('title', 'User')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data User</h1>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                {{-- <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6> --}}
                <a href="javascript:void(0)" class="btn btn-primary btn-icon-split" onclick="add()">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Data</span>
                </a>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="ajax-crud-datatable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Role</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>


    {{-- Modal Tambah User --}}
    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="UserForm" name="UserForm" class="form-horizontal" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="role_id" class="col-sm-2 control-label">Role</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-solid" name="role_id" id="role_id">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-12">
                                <input class="form-control form-control-solid" name="name" id="name" type="text"
                                    placeholder="Masukkan nama anda">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">No Telepon</label>
                            <div class="col-sm-12">
                                <input class="form-control form-control-solid" name="phone" id="phone" type="text"
                                    placeholder="Masukkan no telepon anda">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input class="form-control form-control-solid" name="email" id="email" type="email"
                                    placeholder="name@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-12">
                                <input class="form-control form-control-solid" name="address" id="address" type="text"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo" class="col-sm-2 control-label">Foto</label>
                            <div class="col-sm-12">
                                <input class="form-control form-control-solid" name="photo" id="photo" type="file">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                        </div>


                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


@endsection
