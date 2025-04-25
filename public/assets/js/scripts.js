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
            // {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
    });
});

$('#UserForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);

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
            let oTable = $('#ajax-crud-datatable').DataTable();
            oTable.draw(false);
            $('#UserForm')[0].reset();
            $('#user-modal').modal('hide');
            $('#userTable').DataTable().ajax.reload();
        },
        error: (xhr) => {
            console.error('STATUS',xhr.status);
            console.error('RESPONSE',xhr.responseText);
        },
    })
});
