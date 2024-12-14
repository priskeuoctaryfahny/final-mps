<div class="btn-group">
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="exportDropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-file-export me-2"></i>Export
        </button>
        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
            <li>
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModal" data-format="pdf">
                    Export PDF
                </button>
            </li>
            <li>
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModal" data-format="excel">
                    Export Excel
                </button>
            </li>
            <li>
                <button class="dropdown-item" onclick="window.print()">
                    Export Diagram
                </button>
            </li>
        </ul>
    </div>
</div>
