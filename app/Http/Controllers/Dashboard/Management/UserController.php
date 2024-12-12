<?php

namespace App\Http\Controllers\Dashboard\Management;

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
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Services\Dashboard\UserService;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends Controller
{
    use LogsActivity, ValidatesRequests;

    function __construct(
        private UserService $userService,
    ) {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-download', ['only' => ['export']]);
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersRoleChart $chart): View
    {
        $title = __('text-ui.controller.user.index.title');
        $users = User::orderBy('id', 'DESC')->paginate(10);
        $chart = $chart->build();

        return view('dashboard.users.index', compact('users', 'title', 'chart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $title = __('text-ui.controller.user.create.title');

        return view('dashboard.users.create', compact('roles', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = now()->toDateTimeString();

            $this->userService->create($data);

            return response()->json([
                'message' => 'Data Artikel Berhasil Ditambahkan...'
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Data Artikel Gagal Ditambahkan...' . $error->getMessage()
            ]);
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

    public function forceDelete(string $id)
    {
        $user = $this->userService->getFirstBy('id', $id, true);

        $this->userService->forceDelete($id);

        return response()->json([
            'message' => 'Data Artikel Berhasil Dihapus Permanen...',
        ]);
    }

    public function restore(string $uuid)
    {
        $article = $this->userService->getFirstBy('id', $uuid, true);

        $this->userService->restore($uuid);

        return redirect()->back()->with('success', 'Data Artikel Berhasil Dipulihkan...');
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->userService->dataTable($request);
    }

    public function export(Request $request, $format)
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'Data master disposisi tidak ditemukan.');
        }
        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh data pengguna dalam format ' . $format;
        $this->logActivity('outgoing_letters', Auth::user(), null, $description);

        $title = 'Master Data Pengguna';
        if ($format === 'pdf') {
            $pdf = PDF::loadView('dashboard.pdf.testing', compact('users', 'title'));
            return $pdf->download('users.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new UsersExport, 'users.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }
}
