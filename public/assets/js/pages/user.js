mappings = JSON.parse($('#mappings').val());
update_mappings = JSON.parse($('#update_mappings').val());

$(document).ready( function (){ 
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-warning'
    });

    $('#userTable').DataTable({
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        pageLength:100,
        deferRender:true,
        ajax: {
            type: 'GET',
            url: '/user/data',
        },
        columns: [
            {data: 'id', name: 'id',searchable:true,visible:false,orderable:false},
            {data: 'name', name: 'name',searchable:true,orderable:true},
            {data: 'email', name: 'email',searchable:true,orderable:true},
            {data: 'sex', name: 'sex',searchable:true,orderable:true},
            {data: 'factory_id', name: 'factory_id',searchable:true,orderable:true},
            {data: 'last_login_at', name: 'last_login_at',searchable:false,orderable:false},
            {data: 'action', name: 'action',searchable:false,orderable:false},
        ]
    });

    var dtable = $('#userTable').dataTable().api();
    $(".dataTables_filter input")
        .unbind() // Unbind previous default bindings
        .bind("keyup", function (e) { // Bind our desired behavior
            // If the user pressed ENTER, search
            if (e.keyCode == 13) {
                // Call the API search function
                dtable.search(this.value).draw();
            }
            // Ensure we clear the search if they backspace far enough
            if (this.value == "") {
                dtable.search("").draw();
            }
            return;
    });
    dtable.draw();

    $('#insert_user').submit(function (event){
        event.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var select_kelamin = $('#select_kelamin').val();
        var factory = $('#factory').val();
        var password = $('#password').val();
        
        if(!name){
            $("#alert_warning").trigger("click", 'Nama wajib diisi');
            return false;
        }

        if(!factory){
            $("#alert_warning").trigger("click", 'Factory wajib diisi');
            return false;
        }

        if(!email){
            $("#alert_warning").trigger("click", 'Email wajib diisi');
            return false;
        }
        
        if(!validateEmail(email)){
			$("#alert_info").trigger("click", 'Format email tidak valid.');
			return false;
        }

        if(!select_kelamin){
            $("#alert_warning").trigger("click", 'Jenis Kelamin wajib dipilih');
            return false
        }

        if(!password){
            $("#alert_warning").trigger("click", 'Password wajib diisi');
            return false
        }
        
        $('#insertUserModal').modal('hide');
        bootbox.confirm("Apakah anda yakin akan menyimpan data ini ?.", function (result) {
            if(result){
                $.ajax({
                    type: "POST",
                    url: $('#insert_user').attr('action'),
					data:new FormData($("#insert_user")[0]),
					processData: false,
					contentType: false,
                    beforeSend: function () {
                        $.blockUI({
                            message: '<i class="icon-spinner4 spinner"></i>',
                            overlayCSS: {
                                backgroundColor: '#fff',
                                opacity: 0.8,
                                cursor: 'wait'
                            },
                            css: {
                                border: 0,
                                padding: 0,
                                backgroundColor: 'transparent'
                            }
                        });
                    },
                    complete: function () {
                        $.unblockUI();
                    },
                    success: function () {
                        $('#insertUserModal').modal('hide');
                        $('#insert_user').trigger("reset");
                        $('#userTable').DataTable().ajax.reload();
                        $("#alert_success").trigger("click", 'Data Berhasil disimpan');
                    },
                    error: function (response) {
                        $.unblockUI();
                        
                        if (response.status == 422) $("#alert_warning").trigger("click",response.responseJSON);
                        $('#insertUserModal').modal();
                    }
                });
            }
        });
    });
    
    $('#update_user').submit(function (event){
        event.preventDefault();
        var name = $('#update_name').val();
        var email = $('#update_email').val();
        var select_kelamin = $('#update_select_kelamin').val();
        var password = $('#update_password').val();
        
        if(!name){
            $("#alert_warning").trigger("click", 'Nama wajib diisi');
            return false;
        }

        if(!email){
            $("#alert_warning").trigger("click", 'Email wajib diisi');
            return false;
        }

        
        if(!validateEmail(email)){
			$("#alert_info").trigger("click", 'Format email tidak valid.');
			return false;
        }

        if(!select_kelamin){
            $("#alert_warning").trigger("click", 'Jenis Kelamin wajib dipilih');
            return false
        }
        
        $('#updateUserModal').modal('hide');
        bootbox.confirm("Apakah anda yakin akan menyimpan data ini ?.", function (result) {
            if(result){
                $.ajax({
                    type: "POST",
                    url: $('#update_user').attr('action'),
					data:new FormData($("#update_user")[0]),
					processData: false,
					contentType: false,
                    beforeSend: function () {
                        $.blockUI({
                            message: '<i class="icon-spinner4 spinner"></i>',
                            overlayCSS: {
                                backgroundColor: '#fff',
                                opacity: 0.8,
                                cursor: 'wait'
                            },
                            css: {
                                border: 0,
                                padding: 0,
                                backgroundColor: 'transparent'
                            }
                        });
                    },
                    complete: function () {
                        $.unblockUI();
                    },
                    success: function (response) {
                        $('#updateUserModal').modal('hide');
                        $('#update_user').trigger("reset");
                        $('#userTable').DataTable().ajax.reload();
                        $("#alert_success").trigger("click", 'Data Berhasil disimpan');
                    },
                    error: function (response) {
                        $.unblockUI();
                        if (response.status == 422) $("#alert_warning").trigger("click",response.responseJSON);
                        $('#updateUserModal').modal();
                    }
                });
            }
        });
    });
    render();
});

$('#submit_button').on('click',function(){
    $('#update_user').trigger('submit');
});

$('#select_role').on('change',function()
{
    var value = $(this).val();    
    var name = $(this).select2('data')[0].text;
    if(value)
    {
        var input = {
            'id': value,
            'name': name
        };

        var diff = checkItem(value);
        if (!diff) 
        {
            $("#alert_warning").trigger("click", name+' sudah di dipilih.');
            $(this).val('').trigger('change');
            return false;
        }

        if (name) mappings.push(input);
        
        render();
        $(this).val('').trigger('change');
    }
});

$('#update_select_role').on('change',function()
{
    var user_id = $('#user_id').val();    
    var value = $(this).val();    
    var name = $(this).select2('data')[0].text;
    

    if(value)
    {
        var input = {
            'id': value,
            'name': name
        };

        var diff = checkItemUpdate(value);
        if (!diff) 
        {
            $("#alert_warning").trigger("click", name+' sudah di dipilih.');
            $(this).val('').trigger('change');
            return false;
        }else
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '/user/store/role',
                data: {
                    role_id: value,
                    user_id: user_id
                }
            })
            .done(function () {
                $('#roleTable').DataTable().ajax.reload();
                if (name) update_mappings.push(input);
                renderUpdate();
               
            });
        }

        

        $(this).val('').trigger('change');
    }
});

function edit(url)
{
    $.ajax({
        type: "get",
        url: url,
        beforeSend: function () {
            update_mappings = [];
            $('#roleTable').DataTable().destroy();
            $('#roleTable tbody').empty();
            $.blockUI({
                message: '<i class="icon-spinner4 spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function () {
            $.unblockUI();

        }
    })
    .done(function (response) {
        var roles = response.roles;
        $('#update_user').attr('action', response.url_update);
        $('#user_id').val(response.id);
        $('#update_nik').val(response.nik);
        $('#update_name').val(response.name);
        $('#update_email').val(response.email);
        $("#update_select_kelamin").val(response.sex).trigger('change');

        for (idx in roles) 
        {
            var data = roles[idx];
            var input = {
                'id': data.id,
                'name': data.display_name
            };
            update_mappings.push(input);
        }
        
        renderUpdate();
        $('#updateUserModal').modal();

        $('#roleTable').DataTable({
            dom: 'Bfrtip',
            processing: true,
            serverSide: true,
            pageLength:10,
            scrollY:250,
            scroller:true,
            destroy:true,
            deferRender:true,
            bFilter:true,
            ajax: {
                type: 'GET',
                url: response.url_role_user,
            },
            columns: [
                {data: 'id', name: 'id',searchable:true,visible:false,orderable:false},
                {data: 'display_name', name: 'display_name',searchable:true,orderable:true},
                {data: 'action', name: 'action',searchable:false,orderable:false},
            ]
        });

        var dtable2 = $('#roleTable').dataTable().api();
        $(".dataTables_filter input")
            .unbind() // Unbind previous default bindings
            .bind("keyup", function (e) { // Bind our desired behavior
                if (e.keyCode == 13) {
                    // Call the API search function
                    dtable2.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable2.search("").draw();
                }
                return;
        });
        dtable2.draw();
       
    
        
    });
}

function hapus(url)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        type: "delete",
        url: url,
        beforeSend: function () {
            $.blockUI({
                message: '<i class="icon-spinner4 spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        },
        success: function () {
            $.unblockUI();
        },
        error: function () {
            $.unblockUI();
        }
    })
    .done(function () {
        $('#userTable').DataTable().ajax.reload();
        $("#alert_success").trigger("click", 'Data Berhasil hapus');
    });
}

function hapusModal(url)
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        type: "post",
        url: url,
        beforeSend: function () {
            update_mappings = [];
        },
        success: function (response) {
            var permissions = response;
            for (idx in permissions) 
            {
                var data = permissions[idx];
                var input = {
                    'id': data.id,
                    'name': data.display_name
                };
                update_mappings.push(input);
            }
            
            
        }
    })
    .done(function () {
        $('#roleTable').DataTable().ajax.reload();
        renderUpdate();
    });
}

function render() 
{
    getIndex();
    $('#mappings').val(JSON.stringify(mappings));

    var tmpl = $('#role_table').html();
    Mustache.parse(tmpl);
    var data = { item: mappings };
    var html = Mustache.render(tmpl, data);
    $('#user_role').html(html);
    bind();
}

function renderUpdate() 
{
    getIndexUpdate();
    $('#update_mappings').val(JSON.stringify(update_mappings));
}

function bind() 
{
    $('.btn-delete-item').on('click', deleteItem);
}

function getIndex() 
{
    for (idx in mappings) 
    {
        mappings[idx]['_id'] = idx;
        mappings[idx]['no'] = parseInt(idx) + 1;
    }
}

function getIndexUpdate() 
{
    for (idx in update_mappings) 
    {
        update_mappings[idx]['_id'] = idx;
        update_mappings[idx]['no'] = parseInt(idx) + 1;
    }
}

function deleteItem() 
{
    var i = parseInt($(this).data('id'), 10);

    mappings.splice(i, 1);
    render();
}

function checkItem(id) 
{
    for (var i in mappings) 
    {
        var data = mappings[i];
        
        if (data.id == id)
            return false;
    }

    return true;
}

function checkItemUpdate(id) 
{
    for (var i in update_mappings) 
    {
        var data = update_mappings[i];
        
        if (data.id == id)
            return false;
    }

    return true;
}

function validateEmail(email)
{
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}