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
                <a href="#" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Data</span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Role</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($user as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->role_id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->photo }}</td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Modeal Tambah User --}}
    <div class="modal fade" id="user-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Form
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function add() {
            $
        }
    </script>
@endsection
