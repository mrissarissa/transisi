mappings = JSON.parse($('#mappings').val());
update_mappings = JSON.parse($('#update_mappings').val());

$(document).ready( function (){ 
    $('#roleTable').DataTable({
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        pageLength:100,
        deferRender:true,
        ajax: {
            type: 'GET',
            url: '/role/data',
        },
        columns: [
            {data: 'id', name: 'id',searchable:true,visible:false,orderable:false},
            {data: 'display_name', name: 'display_name',searchable:true,orderable:true},
            {data: 'description', name: 'description',searchable:true,orderable:true},
            {data: 'action', name: 'action',searchable:true,orderable:true},
        ]
    });

    var dtable = $('#roleTable').dataTable().api();
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

    $('#insert_role').submit(function (event){
        event.preventDefault();
        var name = $('#name').val();
        
        if(!name){
            $("#alert_warning").trigger("click", 'Nama wajib diisi');
            return false
        }
        
        $('#insertRoleModal').modal('hide');
        bootbox.confirm("Apakah anda yakin akan menyimpan data ini ?.", function (result) {
            if(result){
                $.ajax({
                    type: "POST",
                    url: $('#insert_role').attr('action'),
                    data: $('#insert_role').serialize(),
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
                        $('#insertRoleModal').modal('hide');
                        $('#insert_role').trigger("reset");
                        $('#roleTable').DataTable().ajax.reload();
                        $("#alert_success").trigger("click", 'Data Berhasil disimpan');
                    },
                    error: function (response) {
                        $.unblockUI();
                        if (response.status == 422) $("#alert_warning").trigger("click",response.responseJSON);
                        $('#insertRoleModal').modal();
                    }
                });
            }
        });
    });
    
    $('#update_role').submit(function (event){
        event.preventDefault();
        var name = $('#update_name').val();
        
        if(!name){
            $("#alert_warning").trigger("click", 'Nama wajib diisi');
            return false
        }
        
        $('#updateRoleModal').modal('hide');
        bootbox.confirm("Apakah anda yakin akan menyimpan data ini ?.", function (result) {
            if(result){
                $.ajax({
                    type: "PUT",
                    url: $('#update_role').attr('action'),
                    data: $('#update_role').serialize(),
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
                        $('#updateRoleModal').modal('hide');
                        $('#update_role').trigger("reset");
                        $('#roleTable').DataTable().ajax.reload();
                        $("#alert_success").trigger("click", 'Data Berhasil disimpan');
                    },
                    error: function (response) {
                        $.unblockUI();
                        if (response.status == 422) $("#alert_warning").trigger("click",response.responseJSON);
                        $('#updateRoleModal').modal();
                    }
                });
            }
        });
    });
    render();
});

$('#submit_button').on('click',function(){
    $('#update_role').trigger('submit');
});

$('#select_permission').on('change',function()
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

var url_permission_role = $('#url_permission_role').attr('href');

$('#update_select_permission').on('change',function()
{
    var role_id = $('#role_id').val();    
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
                url: '/role/store/permission',
                data: {
                    permission_id: value,
                    role_id: role_id
                }
            })
            .done(function () {
                $('#permissionTable').DataTable().ajax.reload();
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
            $('#permissionTable').DataTable().destroy();
            $('#permissionTable tbody').empty();
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
        var permissions = response.permissions;
        $('#update_role').attr('action', response.url_update);
        $('#role_id').val(response.id);
        $('#update_name').val(response.name);
        $('#update_description').val(response.description);

        for (idx in permissions) 
        {
            var data = permissions[idx];
            var input = {
                'id': data.id,
                'name': data.display_name
            };
            update_mappings.push(input);
        }
        
        renderUpdate();
        $('#updateRoleModal').modal();

        $('#permissionTable').DataTable({
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
                url: response.url_permission_role,
            },
            columns: [
                {data: 'id', name: 'id',searchable:true,visible:false,orderable:false},
                {data: 'display_name', name: 'display_name',searchable:true,orderable:true},
                {data: 'action', name: 'action',searchable:false,orderable:false},
            ]
        });

        var dtable2 = $('#permissionTable').dataTable().api();
        $(".dataTables_filter input")
            .unbind() // Unbind previous default bindings
            .bind("keyup", function (e) { // Bind our desired behavior
                // If the user pressed ENTER, search
                if (e.keyCode == 13) {
                    // Call the API search function
                    console.log(this.value);
                    dtable2.search(this.value).draw();
                }
                // Ensure we clear the search if they backspace far enough
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
        $('#roleTable').DataTable().ajax.reload();
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
        $('#permissionTable').DataTable().ajax.reload();
        renderUpdate();
    });
}

function render() 
{
    getIndex();
    $('#mappings').val(JSON.stringify(mappings));

    var tmpl = $('#permission_table').html();
    Mustache.parse(tmpl);
    var data = { item: mappings };
    var html = Mustache.render(tmpl, data);
    $('#role_permission').html(html);
    bind();
}

function renderUpdate() 
{
    getIndexUpdate();
    $('#update_mappings').val(JSON.stringify(update_mappings));

    var tmpl = $('#update_permission_table').html();
    Mustache.parse(tmpl);
    var data = { item: update_mappings };
    var html = Mustache.render(tmpl, data);
    $('#update_role_permission').html(html);
    bindUpdate();
}

function bind() 
{
    $('.btn-delete-item').on('click', deleteItem);
}

function bindUpdate() 
{
    $('.btn-delete-item-update').on('click', deleteItemUpdate);
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

function deleteItemUpdate() 
{
    var i = parseInt($(this).data('id'), 10);
    update_mappings.splice(i, 1);
    renderUpdate();
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