@props(['columns' => [], 'columnLabels' => []])

@php
    $columns = json_decode($columns, true);
    $columnLabels = json_decode($columnLabels, true);
@endphp


<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Filter dan Ekspor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="exportForm"
                    action="{{ route(Route::current()->uri() . '.export', ['format' => 'pdf']) }}" method="get">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-floating form-floating-advance-select">
                            <label for="columns">Kolom yang akan diekspor</label>
                            <select class="form-select" id="columns" data-choices="data-choices" multiple="multiple"
                                name="columns[]" data-options='{"removeItemButton":true,"placeholder":true}'>
                                @foreach ($columns as $column)
                                    <option value="{{ $column }}">
                                        {{ $columnLabels[$column] ?? $column }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-advance-select ">
                            <label for="startDate">Tanggal Awal</label>
                            <input type="date" class="form-control" name="startDate" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-advance-select ">
                            <label for="endDate">Tanggal akhir</label>
                            <input type="date" class="form-control" name="endDate" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-advance-select ">
                            <label for="paperSize">Ukuran Kertas</label>
                            <select class="form-select" id="paperSize" name="paperSize" data-choices="data-choices"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="A0">A0</option>
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="A3">A3</option>
                                <option value="A4">A4</option>
                                <option value="A5">A5</option>
                                <option value="A6">A6</option>
                                <option value="A7">A7</option>
                                <option value="A8">A8</option>
                                <option value="A9">A9</option>
                                <option value="A10">A10</option>
                                <option value="C4">C4</option>
                                <option value="C5">C5</option>
                                <option value="C6">C6</option>
                                <option value="C7">C7</option>
                                <option value="Letter">Letter</option>
                                <option value="F4">F4</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating form-floating-advance-select ">
                            <label for="orientation">Orientasi Kertas</label>
                            <select class="form-select" id="orientation" name="orientation" data-choices="data-choices"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="portrait">Portrait</option>
                                <option value="landscape">Landscape</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-danger fw-bold">
                            Abaikan ukuran dan orientasi kertas bila memilih format Excel
                        </div>
                    </div>
                    <input type="hidden" name="format" id="exportFormat" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submitExport">Ekspor</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportButtons = document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]');
        const exportFormatInput = document.getElementById('exportFormat');
        const exportForm = document.getElementById('exportForm');
        const columnsSelect = document.getElementById('columns');
        const startDateInput = document.querySelector('input[name="startDate"]');
        const endDateInput = document.querySelector('input[name="endDate"]');

        exportButtons.forEach(button => {
            button.addEventListener('click', function() {
                const format = this.getAttribute(
                    'data-format'); // Get the format from data attribute
                exportFormatInput.value = format; // Set the format value
                exportForm.action = "{{ route(Route::current()->uri() . '.export', '') }}/" +
                    format; // Set the form action
            });
        });

        document.getElementById('submitExport').addEventListener('click', function() {
            // Validate the form
            const selectedColumns = Array.from(columnsSelect.selectedOptions).map(option => option
                .value);
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (selectedColumns.length === 0) {
                alert('Silakan pilih kolom yang akan diekspor.');
                return;
            }

            if (!startDate) {
                alert('Silakan masukkan tanggal awal.');
                return;
            }

            if (!endDate) {
                alert('Silakan masukkan tanggal akhir.');
                return;
            }

            if (new Date(startDate) > new Date(endDate)) {
                alert('Tanggal akhir harus lebih besar dari tanggal awal.');
                return;
            }

            exportForm.submit(); // Submit the form if all validations pass
        });
    });
</script>

@push('header')
    <link href="{{ asset('backend') }}/vendors/choices/choices.min.css" rel="stylesheet" />
@endpush
@push('footer')
    <script src="{{ asset('backend/vendors/choices/choices.min.js') }}"></script>
@endpush
