function editPriority(tableName, primary, id, action) {
    // Validate action parameter
    if (action !== 'plus' && action !== 'minus') {
        console.error('Invalid action parameter. Use "plus" or "minus".');
        return;
    }
    // Make AJAX request to edit priority
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'POST',
        url: '/admin/edit_priority', // Replace with your server-side script URL
        data: {
            tableName: tableName,
            primary: primary,
            id: id,
            action: action,
            _token: csrfToken
        },
        success: function (response) {
            if (response.success) {
                window.location.reload();
            } else {
                swal('It is the Top priority!');
            }
        },
        error: function () {
            console.error('An error occurred while editing priority. Please try again later.');
        }
    });
}

// function editVisibility(tableName, column, id) {
//     var csrfToken = $('meta[name="csrf-token"]').attr('content');
//     $.ajax({
//         type: 'POST',
//         url: 'update_status', // Replace with your server-side script URL
//         data: {
//             tableName: tableName,
//             column: column,
//             id: id,
//             _token: csrfToken,
//         },
//         success: function (response) {
//             if (response.trim() === 'success') {
//                 window.location.reload();

//             } else {
//                 swal('Fail', response);
//             }
//         },
//         error: function () {
//             console.error('An error occurred while editing priority. Please try again later.');
//         }
//     });
// }
function updateRecordStatus(tableName, primaryKey, id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/admin/update_status',
        method: 'POST',
        data: {
            _token: csrfToken,
            tableName: tableName,
            primaryKey: primaryKey,
            id: id
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                    location.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update status!'
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Update status error:', error);
            swal({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating status!'
            });
        }
    });
}