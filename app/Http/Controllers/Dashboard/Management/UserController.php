<?php

namespace App\Http\Controllers\Dashboard\Management;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Arr;
use App\Exports\UsersExport;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Charts\UsersRoleChart;
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
use App\Http\Services\Export\ExportService;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Services\Dashboard\UserService;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends Controller
{
    use LogsActivity, ValidatesRequests;

    function __construct(
        private UserService $userService,
        private ExportService $exportService,
    ) {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-download', ['only' => ['export']]);
        $this->userService = $userService;
        $this->exportService = $exportService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersRoleChart $chart): View
    {
        $columns = $this->userService->columns();

        $columnLabels = $this->userService->columnLabels();

        // Define columns to exclude
        $excludedColumns = $this->userService->columnExclude();

        $columnDetail = $this->userService->getAttributesWithDetails();

        $title = __('text-ui.controller.user.index.title');
        $users = User::orderBy('id', 'DESC')->paginate(10);
        $chart = $chart->build();

        return view('dashboard.users.index', compact('users', 'title', 'chart', 'columns', 'columnLabels', 'columnDetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $columnDetail = $this->userService->getAttributesWithDetails();
        $roles = Role::pluck('name', 'name')->all();
        $title = __('text-ui.controller.user.create.title');

        return view('dashboard.users.create', compact('roles', 'title', 'columnDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        try {
            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = now()->toDateTimeString();

            $this->userService->create($data);

            return redirect()->route('users.index')
                ->with('success', 'Data Pengguna Berhasil Ditambahkan...');
        } catch (\Exception $error) {
            return redirect()->route('users.index')
                ->with('error', 'Data Pengguna Gagal Ditambahkan...' . $error->getMessage());
        }



        return redirect()->route('users.index')
            ->with('success', trans('success.user-store'));
    }

    public function show(User $user): View
    {
        $title = __('text-ui.controller.user.show.title');

        return view('dashboard.users.show', compact('user', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user): View
    {
        $title = __('text-ui.controller.user.edit.title');
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('dashboard.users.edit', compact('user', 'roles', 'userRole', 'title'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
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
    //     return redirect()->route('users.index')
    //         ->with('success', 'User deleted successfully');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->forceDelete($id);
        return response()->json(['message' => 'Data Pengguna Berhasil Dihapus...']);
    }
    public function serverside(Request $request): JsonResponse
    {
        return $this->userService->dataTable($request);
    }

    public function export(Request $request, $format)
    {
        $selectedColumns = $request->input('columns', []);
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $exportData = User::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->where('id', '>', 2)
            ->limit(100)
            ->get($selectedColumns);


        if ($exportData->isEmpty()) {
            return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
        }
        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh data pengguna dalam format ' . $format;
        $this->logActivity('users', Auth::user(), null, $description);

        $columns = $this->userService->columns();

        $columnLabels = $this->userService->columnLabels();

        // Define columns to exclude
        $excludedColumns = $this->userService->columnExclude();


        $title = 'Master Data Pengguna';
        $view = 'dashboard.users.pdf';
        $fileName = 'Data Pengguna';
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
            $exportData = User::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->where('id', '>', 2)
                ->get($selectedColumns);
            if ($exportData->isEmpty()) {
                return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            }
            return Excel::download(new UsersExport($exportData, $selectedColumns, $this->userService->columnLabels()), 'users.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }
}
