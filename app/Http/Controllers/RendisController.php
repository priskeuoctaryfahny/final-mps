<?php

namespace App\Http\Controllers;

use App\Models\Rendis;
use Illuminate\Support\Arr;
use App\Exports\RendisExport;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Charts\RendisRoleChart;
use App\Charts\RendisStatusChart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\RendisRequest;
use App\Http\Services\Dashboard\RendisService;
use Illuminate\Foundation\Validation\ValidatesRequests;
use PDF;

class RendisController extends Controller
{
    use LogsActivity, ValidatesRequests;

    function __construct(
        private RendisService $renDis,
    ) {
        $this->middleware('permission:renstra-list|renstra-create|renstra-edit|renstra-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:renstra-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:renstra-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:renstra-delete', ['only' => ['destroy']]);
        $this->middleware('permission:renstra-download', ['only' => ['export']]);
        $this->renDis = $renDis;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(rendisRoleChart $chart, rendisStatusChart $chart2): View
    {
        $columns = Schema::getColumnListing((new Rendis())->getTable());

        $columnLabels = [
            'nomor_agenda' => 'Nomor Agenda',
            'nama_agenda_renstra' => 'Nama Agenda',
            'deskripsi_uraian_renstra' => 'Deskripsi Renstra',
            'disposisi_diteruskan' => 'Disposisi/Diteruskan',
            'status_renstra' => 'Status Renstra',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'is_terlaksana' => 'Terlaksana',
        ];

        // Define columns to exclude
        $excludedColumns = [
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        // Filter out excluded columns
        $columns = array_diff($columns, $excludedColumns);

        $title = 'Renstra Kadis';
        $rendis = Rendis::orderBy('id', 'DESC')->paginate(10);
        $chart = $chart->build();
        $chart2 = $chart2->build();

        return view('dashboard.rendis.index', compact('rendis', 'title', 'chart', 'chart2', 'columns', 'columnLabels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = 'Tambah Renstra Kadis';

        return view('dashboard.rendis.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RendisRequest $request): JsonResponse
    {
        dd($request->validated());
        $this->validate($request, [
            'nomor_agenda' => 'required',
            'nama_agenda_renstra' => 'required'
        ]);
        $data = $request->validated();
        try {

            $this->renDis->create($data);

            return response()->json([
                'message' => 'Data Renstra Berhasil Ditambahkan...'
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Data Renstra Gagal Ditambahkan...' . $error->getMessage()
            ]);
        }



        return redirect()->route('rendis.index')
            ->with('success', trans('success.user-store'));
    }

    public function show(Rendis $rendis): View
    {
        $title = __('text-ui.controller.rendis.show.title');

        return view('dashboard.rendis.show', compact('rendis', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rendis $rendis): View
    {
        $title = __('text-ui.controller.rendis.edit.title');

        return view('dashboard.rendis.edit', compact('rendis', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'nomor_agenda' => 'required',
            'nama_agenda_renstra' => 'required'
        ]);

        $input = $request->all();
        $rendis = Rendis::find($id);
        $rendis->update($input);

        return redirect()->route('rendis.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id): RedirectResponse
    // {
    //     User::find($id)->delete();
    //     return redirect()->route('rendis.index')
    //         ->with('success', 'User deleted successfully');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->renDis->forceDelete($id);
        return response()->json(['message' => 'Data Pengguna Berhasil Dihapus...']);
    }

    public function forceDelete(string $id)
    {
        $rendis = $this->renDis->getFirstBy('id', $id, true);

        $this->renDis->forceDelete($id);

        return response()->json([
            'message' => 'Data Artikel Berhasil Dihapus Permanen...',
        ]);
    }

    public function restore(string $uuid)
    {
        $article = $this->renDis->getFirstBy('id', $uuid, true);

        $this->renDis->restore($uuid);

        return redirect()->back()->with('success', 'Data Pengguna Berhasil Dipulihkan');
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->renDis->dataTable($request);
    }

    public function export(Request $request, $format)
    {
        $selectedColumns = $request->input('columns', []);
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $rendiss = Rendis::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->limit(100)->get($selectedColumns);

        if ($rendiss->isEmpty()) {
            return redirect()->back()->with('error', 'Data renstra tidak ditemukan.');
        }
        $description = 'Renstra ' . Auth::user()->name . ' mengunduh data renstra dalam format ' . $format;
        $this->logActivity('rendis', Auth::user(), null, $description);

        $columnLabels = [
            'nomor_agenda' => 'Nomor Agenda',
            'nama_agenda_renstra' => 'Nama Agenda',
            'deskripsi_uraian_renstra' => 'Deskripsi Renstra',
            'disposisi_diteruskan' => 'Disposisi/Diteruskan',
            'status' => 'Status',
            'tanggal_mulai' => 'Tgl Mulai',
            'tanggal_akhir' => 'Tgl akhir',
            'is_terlaksana' => 'Progres',
        ];

        $title = 'Master Data Renstra Kadis';
        if ($format === 'pdf') {
            $pdf = PDF::loadView('dashboard.rendis.pdf', compact('rendiss', 'title', 'columnLabels', 'selectedColumns'))
           ->setPaper('a4', 'landscape'); // Set paper size and orientation

return $pdf->download('Data Renstra Kadis.pdf');
        } elseif ($format === 'excel') {
            $rendis = Rendis::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get($selectedColumns);
            return Excel::download(new RendisExport($rendis, $selectedColumns), 'rendis.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }
}
