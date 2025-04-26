@extends('admin.layouts.base')

@section('title', 'Detail User')

@section('content')
    <div class="container mt-4">
        <h3>Detail User</h3>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('photo/' . $user->photo) }}" width="100%" height="auto"
                    style="object-fit:cover; border-radius:10px;" alt="Foto User">
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ $user->role->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->address }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <a href="/user" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
