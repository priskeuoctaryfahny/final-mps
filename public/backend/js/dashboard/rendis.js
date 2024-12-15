let submit_method;

$(document).ready(function () {
    rendisTable();
});

// datatable serverside
function rendisTable() {
    $('#yajra').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "/rendis/serverside",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'nomor_agenda',
                name: 'nomor_agenda'
            },
            {
                data: 'nama_agenda_renstra',
                name: 'nama_agenda_renstra'
            },
            {
                data: 'deskripsi_uraian_renstra',
                name: 'deskripsi_uraian_renstra'
            },
            {
                data: 'disposisi_diteruskan',
                name: 'disposisi_diteruskan'
            },
            {
                data: 'tanggal_mulai',
                name: 'tanggal_mulai'
            },
            {
                data: 'tanggal_akhir',
                name: 'tanggal_akhir'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'is_terlaksana',
                name: 'is_terlaksana'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });
};

const deleteData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this renstra?",
        icon: "question",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        allowOutsideClick: false,
        showCancelButton: true,
        showCloseButton: true
    }).then((result) => {
        if (result.value) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "/rendis/" + id,
                dataType: "json",
                success: function (response) {
                    reloadTable();
                    toastSuccess(response.message);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
}

const deleteForceData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete permanently this article?",
        icon: "question",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        allowOutsideClick: false,
        showCancelButton: true,
        showCloseButton: true
    }).then((result) => {
        if (result.value) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "/users/force-delete/" + id,
                dataType: "json",
                success: function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: "Success!",
                        text: response.message,
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = '/admin/articles';
                        }
                    })
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
}
