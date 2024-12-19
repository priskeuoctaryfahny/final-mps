<button class="btn btn-sm btn-info mx-2" type="button" id="importDropdown" data-bs-toggle="modal"
    data-bs-target="#importModal" data-format="pdf">
    <i class="fa-solid fa-file-import me-2"></i>Import
</button>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Impor Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" enctype="multipart/form-data" id="importForm"
                    action="{{ route(Route::current()->uri() . '.import') }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <input type="file" name="importFile" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-info fw-bold text-white">
                            Format XLS, XLSX dan CSV
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submitImport">Impor</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // submit the form
        document.getElementById('submitImport').addEventListener('click', function() {
            document.getElementById('importForm').submit();
        });
    })
</script>
