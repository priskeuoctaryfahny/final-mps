toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "timeOut": 3000,
    "positionClass": "toast-top-right",
    "preventDuplicates": true
}

let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})

const toastSuccess = (message) => {
    toastr.success(message);
}

const toastError = (message) => {
    let resJson = JSON.parse(message);

    let errorText = '';

    for (let key in resJson.errors) {
        errorText = resJson.errors[key];
        break;
    }

    toastr.error(errorText);
}

const startLoading = (str = 'Tunggu Sebentar...') => {
    document.getElementById('loadingOverlay').style.display = 'block'; // Show overlay
    Swal.fire({
        title: 'Loading!',
        text: str,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        },
        willClose: () => {
            document.getElementById('loadingOverlay').style.display = 'none'; // Hide overlay when closing
        },
    })
}

const stopLoading = () => {
    Swal.close(); // Close SweetAlert
    document.getElementById('loadingOverlay').style.display = 'none'; // Hide overlay
}

const reloadTable = () => {
    $('#yajra').DataTable().draw(false);
}

const resetForm = (form) => {
    $(form)[0].reset();
}

const resetValidation = () => {
    $('.is-invalid').removeClass('is-invalid');
    $('.is-valid').removeClass('is-valid');
    $('span.invalid-feedback').remove();
}


