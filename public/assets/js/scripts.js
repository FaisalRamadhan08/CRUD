function add() {
    // $('#UserForm').reset();

    $('#user-modal').modal('show');
}

// Edit User
function editUser(id) {
    $.ajax({
        type: "POST",
        url: "/edit",
        data: {id: id},
        dataType: 'json',
        success: function(res){
            console.log(res);
            $('#UserModal').html('Edit User');
            $('#user-modal').modal('show');
            $('#id').val(res.id);
            // $('#role_id').val(res.role_name);
            $('#name').val(res.name);
            $('#phone').val(res.phone);
            $('#email').val(res.email);
            $('#address').val(res.address);
            // $('#photo').val(res.photo);
        }
    })
}

$(document).ready( function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#ajax-crud-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/user",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'role_name', name: 'role_name'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
            {data: 'photo', name: 'photo'},
            {data: 'status_action', name: 'status_action', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
    });
});

$('#UserForm').submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);

    // Reset error messages
    $('.text-danger').remove();
    $('.form-control').removeClass('is-invalid');

    $.ajax({
        type:'POST',
        url: "/store",
        // url: "{{ route('users.store') }}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            console.log('Success: ',data);
            // let oTable = $('#ajax-crud-datatable').DataTable();
            // oTable.draw(false);
            $('#user-modal').modal('hide');
            $('#UserForm')[0].reset();
            $('#ajax-crud-datatable').DataTable().ajax.reload();

            // Tampilkan popup berhasil
            let isUpdate = $('#id').val() !== "";

            Swal.fire({
                title: 'Berhasil!',
                text: isUpdate ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 2000,
                timerProgressBar: true
            });

        },
        // error: (xhr) => {
        //     console.error('STATUS',xhr.status);
        //     console.error('RESPONSE',xhr.responseText);
        // },

        // error: function (xhr) {
        //     if (xhr.status === 422) {
        //         let errors = xhr.responseJSON.errors;
        //         $.each(errors, function (key, value) {
        //             let input = $('#' + key);
        //             input.addClass('is-invalid');
        //             input.after('<span class="text-danger">' + value[0] + '</span>');
        //         });
        //     }
        // }
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
        
                $('.is-invalid').removeClass('is-invalid');
                $('.text-danger').remove();
        
                
                $.each(errors, function (key, value) {
                    let input = $('#' + key);
                    input.addClass('is-invalid');
                    input.after('<span class="text-danger">' + value[0] + '</span>');
                });
        
            
            } else {
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    text: 'Ada masalah saat memproses data, silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
        
    });
});

$('#user-modal').on('show.bs.modal', function () {
    // Reset form
    $('#UserForm')[0].reset();

    // Hapus error
    $('.text-danger').remove();
    $('.form-control').removeClass('is-invalid');
});



function deleteUser(id) {
    
    Swal.fire({
        title: 'Apakah Anda yakin',
        text: "Ingin menghapus Data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/user/${id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil dihapus.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                   
                    $('#ajax-crud-datatable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menghapus data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error(xhr.responseText);
                }
            });
        } else {
            
            Swal.fire({
                title: 'Dibatalkan',
                text: 'Penghapusan data dibatalkan.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    });
}


function detailUser(id) {
    window.location.href = '/user/detail/' + id;
}

function toggleStatus(userId) {
    Swal.fire({
        title: 'Apakah Anda yakin',
        text: "Ingin mengubah status user ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ubah',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/user/toggle-status/' + userId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status berhasil diubah menjadi ' + response.status,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#ajax-crud-datatable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengubah status.',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengubah status user.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}







