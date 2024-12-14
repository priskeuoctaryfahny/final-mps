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
                <form id="exportForm" action="{{ route(Route::current()->uri() . '.export', ['format' => 'pdf']) }}"
                    method="get">
                    @csrf
                    <div class="form-floating form-floating-advance-select"><label
                            for="floaTingLabelMultipleSelect">Kolom yang akan diekspor</label><select
                            class="form-select" id="floaTingLabelMultipleSelect" data-choices="data-choices"
                            multiple="multiple" name="columns[]"
                            data-options='{"removeItemButton":true,"placeholder":true}'>
                            @foreach ($columns as $column)
                                <option value="{{ $column }}">
                                    {{ $columnLabels[$column] ?? $column }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-floating form-floating-advance-select my-2">
                        <label for="startDate">Tanggal awal</label>
                        <input type="date" class="form-control" name="startDate" required>
                    </div>

                    <div class="form-floating form-floating-advance-select my-2">
                        <label for="endDate">Tanggal akhir</label>
                        <input type="date" class="form-control" name="endDate" required>
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
            exportForm.submit(); // Submit the form
        });
    });
</script>

@push('header')
    <link href="{{ asset('backend') }}/vendors/choices/choices.min.css" rel="stylesheet" />
@endpush
@push('footer')
    <script src="{{ asset('backend/vendors/choices/choices.min.js') }}"></script>
@endpush
