$(function() {
    let csrfToken = $('meta[name=csrf-token]').attr('content'),
        tableUsers = $('table#users');

    tableUsers.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'user/get',
            type: 'POST',
            headers: {
                'X-CSRF-Token': csrfToken,
            },
        },
        columns: [
            {data: 'name'},
            {data: 'city'},
            {data: 'skills'},
        ],
        columnDefs: [{
            targets: 3,
            data: null,
            defaultContent: '<button class="delete" title="Удалить">x</button>',
        }],
        language: {
            url: 'js/dataTables.Russion.json',
        },
    });

    $('button#add').on('click', function() {
        $.ajax({
            url: 'user/add',
            type: 'POST',
            headers: {
                'X-CSRF-Token': csrfToken,
            },
            success: function(data) {
                if (data.success) {
                    tableUsers.DataTable().draw();
                }
            }
        });
    });

    tableUsers.on( 'click', 'button.delete', function () {
        var data = tableUsers.DataTable().row($(this).closest('tr')).data(),
            rowId = data ? data.id : undefined;

        if (rowId && confirm('Вы уверены?')) {
            $.ajax({
                url: 'user/delete',
                type: 'POST',
                data: {id: rowId},
                headers: {
                    'X-CSRF-Token': csrfToken,
                },
                success: function (data) {
                    if (data.success) {
                        tableUsers.DataTable().draw();
                    }
                }
            });
        }
    });
});
