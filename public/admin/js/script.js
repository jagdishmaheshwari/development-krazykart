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
// // Function to retrieve and display item details in the modal
// function showStockDetailsModal(itemId) {
//     // AJAX request to the server
//     $.ajax({
//         url: 'your-server-endpoint-url', // Replace with your server endpoint
//         type: 'POST',
//         data: {
//             item_id: itemId,
//             _token: token // Include CSRF token
//         },
//         success: function (response) {
//             // Update modal with retrieved item details
//             $('#categoryName').text(response.category_name);
//             $('#productName').text(response.product_name);
//             $('#price').text(response.price);
//             $('#mrp').text(response.mrp);
//             $('#color').text(response.color);
//             $('#sizeName').text(response.size_name);
//             $('#itemImage').attr('src', response.image_url);
//             $('#itemId').val(itemId);

//             // Show the modal
//             $('#addStockModal').modal('show');
//         },
//         error: function (xhr, status, error) {
//             console.error(xhr.responseText);
//             // Handle error
//         }
//     });
// }

// function basicConfirmPopup(message, callback) {
//     swal({
//         title: "Are you sure?",
//         text: message,
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "Yes, proceed!",
//         cancelButtonText: "No, cancel!",
//         closeOnConfirm: false,
//         closeOnCancel: true
//     }, function (isConfirm) {
//         if (isConfirm) {
//             callback(true);
//         } else {
//             callback(false);
//         }
//     });
// }
function basicConfirmPopup(message) {
    if (confirm(message)) {
        return true;
    } else {
        return false;
    }
}
function OpenPopupWindow(url, title, width = "1000", height = "700") {
    // Calculate the position of the popup to center it on the screen
    var left = (screen.width / 2) - (width / 2);
    var top = (screen.height / 2) - (height / 2);

    // Open the popup window
    var popupWindow = window.open(url, title, 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left);

    // Bring the popup to the front
    if (window.focus) {
        popupWindow.focus();
    }

    return popupWindow;
}
function showActionAlert(message, type = 'success', position = 'top-right') {
    return new Promise(function (resolve) {
        // Create the alert element
        const alertHtml = `
                <div class="alert alert-dismissible fade show position-fixed" wi style="z-index:10000000;width:400px" role="alert">
                 ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `; // <strong>Success!</strong>

        // Append the alert to the body
        $('body').append(alertHtml);

        // Select the newly added alert
        const $alert = $('.alert').last();

        switch (type) {
            case 'success':
                $alert.addClass('alert-success');
                break;
            case 'warning':
                $alert.addClass('alert-warning');
                break;
            case 'error':
            case 'danger':
                $alert.addClass('alert-danger');
                break;
        }

        // Apply positioning classes based on the position parameter
        switch (position) {
            case 'top-right':
                $alert.addClass('top-0 end-0 mt-3 me-3');
                break;
            case 'top-left':
                $alert.addClass('top-0 start-0 mt-3 ms-3');
                break;
            case 'top-center':
                $alert.addClass('top-0 start-50 translate-middle-x mt-3');
                break;
            case 'bottom-right':
                $alert.addClass('bottom-0 end-0 mb-3 me-3');
                break;
            case 'bottom-left':
                $alert.addClass('bottom-0 start-0 mb-3 ms-3');
                break;
            case 'bottom-center':
                $alert.addClass('bottom-0 start-50 translate-middle-x mb-3');
                break;
            default:
                $alert.addClass('top-0 end-0 mt-3 me-3'); // Default to top-right
        }
        sessionStorage.setItem('alertHtml', alertHtml);
        sessionStorage.setItem('alertType', type);
        sessionStorage.setItem('alertPosition', position);

        // Automatically remove the alert after a timeout (e.g., 5 seconds)
        setTimeout(function () {
            $alert.remove();
            sessionStorage.removeItem('alertHtml');
            sessionStorage.removeItem('alertType');
            sessionStorage.removeItem('alertPosition');
        }, 5000);

        resolve();
    });
}

























// function addValidation(selector, rules, customMessages = {}) {
//     const ruleSet = {};
//     const messageSet = {};
//     const defaultMessages = {
//         required: "This field is required.",
//         minlength: "Please enter at least {0} characters.",
//         maxlength: "Please enter no more than {0} characters.",
//         email: "Please enter a valid email address."
//     };

//     rules.split('|').forEach(rule => {
//         const [ruleName, ruleValue] = rule.split(':');
//         ruleSet[ruleName] = ruleValue !== undefined ? parseInt(ruleValue, 10) : true;

//         // Use custom message if provided, otherwise use default
//         if (customMessages[ruleName]) {
//             messageSet[ruleName] = customMessages[ruleName];
//         } else {
//             messageSet[ruleName] = defaultMessages[ruleName].replace("{0}", ruleValue);
//         }
//     });

//     $(selector).rules("add", {
//         ...ruleSet,
//         messages: messageSet
//     });
// }