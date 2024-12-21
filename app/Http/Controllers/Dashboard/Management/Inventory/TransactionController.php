<?php

namespace App\Http\Controllers\Dashboard\Management\Inventory;

use PDF;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Dashboard\Gas;
use App\Charts\TransactionsChart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Exports\TransactionsExport;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Dashboard\Transaction;
use Illuminate\Http\RedirectResponse;
use App\Http\Services\Export\ExportService;
use App\Imports\Dashboard\TransactionsImport;
use App\Http\Requests\Dashboard\TransactionRequest;
use App\Http\Services\Dashboard\TransactionService;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TransactionController extends Controller
{
    use LogsActivity, ValidatesRequests;

    function __construct(
        private TransactionService $transactionService,
        private ExportService $exportService,
    ) {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-download', ['only' => ['export']]);
        $this->transactionService = $transactionService;
        $this->exportService = $exportService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionsChart $chart, $id): View
    {
        $columns = $this->transactionService->columns();
        $columnLabels = $this->transactionService->columnLabels();
        $excludedColumns = $this->transactionService->columnExclude();
        $columnDetail = $this->transactionService->getAttributesWithDetails();
        $title = 'Data Gas';

        // Fetch transactions for the specific gas ID
        $transactions = Transaction::where('gas_id', $id)->latest()->paginate(10);

        // Build the chart
        $chart = $chart->build();

        return view('dashboard.inventory.transactions.index', compact('transactions', 'id', 'title', 'chart', 'columns', 'columnLabels', 'columnDetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_in($id): View
    {
        $type = 'in';
        $columnDetail = $this->transactionService->getAttributesWithDetails();
        $gases = Gas::all();
        $title = 'Tambah Data Gas';

        return view('dashboard.inventory.transactions.create', compact('gases', 'id', 'type', 'title', 'columnDetail'));
    }

    public function create_out($id): View
    {
        $type = 'out';
        $columnDetail = $this->transactionService->getAttributesWithDetails();
        $gases = Gas::all();
        $title = 'Tambah Data Gas';

        return view('dashboard.inventory.transactions.create', compact('gases', 'id', 'type', 'title', 'columnDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        try {
            $this->transactionService->create($data);

            return redirect()->route('transactions.index', $data['gas_id'])
                ->with('success', 'Data Gas Berhasil Ditambahkan...');
        } catch (\Exception $error) {
            return redirect()->route('transactions.index', $data['gas_id'])
                ->with('error', 'Data Gas Gagal Ditambahkan...' . $error->getMessage());
        }
    }

    public function show(Transaction $user): View
    {
        $title = __('text-ui.controller.user.show.title');

        return view('dashboard.inventory.transactions.show', compact('user', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_in(Transaction $transaction): View
    {
        $type = 'in';
        $title = 'Ubah Data Gas';
        $gases = Gas::all();

        return view('dashboard.inventory.transactions.edit', compact('transaction', 'type', 'gases', 'title'));
    }

    public function edit_out(Transaction $transaction): View
    {
        $type = 'out';
        $title = 'Ubah Data Gas';
        $gases = Gas::all();

        return view('dashboard.inventory.transactions.edit', compact('transaction', 'type', 'gases', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id): RedirectResponse
    {
        $data = $request->validated();


        $transaction = Transaction::find($id);
        $transaction->update($data);

        return redirect()->route('transactions.index', $transaction->gas_id)
            ->with('success', 'Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $this->transactionService->forceDelete($id);
        return response()->json(['message' => 'Data Gas Berhasil Dihapus...']);
    }
    public function serverside(Request $request, $id): JsonResponse
    {
        return $this->transactionService->dataTable($request, $id);
    }

    public function export(Request $request, $format)
    {
        $selectedColumns = $request->input('columns', []);
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $exportData = Transaction::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->limit(100)
            ->get($selectedColumns);


        if ($exportData->isEmpty()) {
            return redirect()->back()->with('error', 'Data gas tidak ditemukan.');
        }
        $description = 'Gas ' . Auth::user()->name . ' mengunduh data gas dalam format ' . $format;
        $this->logActivity('users', Auth::user(), null, $description);

        $columns = $this->transactionService->columns();

        $columnLabels = $this->transactionService->columnLabels();

        // Define columns to exclude
        $excludedColumns = $this->transactionService->columnExclude();


        $title = 'Master Data Gas';
        $view = 'dashboard.inventory.transactions.pdf';
        $fileName = 'Data Gas';
        $paperSize = $request->input('paperSize', 'A4');
        $orientation = $request->input('orientation', 'portrait');

        $startDateTranslated = Carbon::parse($request->input('startDate'))->translatedFormat('d F Y');
        $endDateTranslated = Carbon::parse($request->input('endDate'))->translatedFormat('d F Y');
        $dateFilter = $startDateTranslated . ' - ' . $endDateTranslated;

        $data = compact('exportData', 'title', 'view', 'fileName', 'paperSize', 'orientation', 'columnLabels', 'selectedColumns', 'columns', 'dateFilter');

        if ($format === 'pdf') {
            $pdf = $this->exportService->exportPdf($data);
            return $pdf->download($fileName . '.pdf');
        } elseif ($format === 'excel') {
            $exportData = Transaction::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->get($selectedColumns);
            if ($exportData->isEmpty()) {
                return redirect()->back()->with('error', 'Data gas tidak ditemukan.');
            }
            return Excel::download(new TransactionsExport($exportData, $selectedColumns, $this->transactionService->columnLabels()), 'users.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'importFile' => 'required|mimes:xls,xlsx,csv',
        ]);
        try {
            Excel::import(new TransactionsImport, $request->file('importFile'));
            return redirect()->back()->with('success', 'Impor data gas berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}
