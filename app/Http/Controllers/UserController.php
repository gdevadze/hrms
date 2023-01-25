<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Sold;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Arr;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('pages.users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function changePassword()
    {
        return view('pages.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = currentUser();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'მიმდინარე პაროლი არასწორია!');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'პაროლი წარმატებით შეიცვალა!');
    }

    public function changeNotification(Request $request)
    {
        try {
            User::where('id', currentUser()->id)->update(['domain' => $request->domain]);
            return jsonResponse(['status' => 1]);
        } catch (\Exception $exception) {
            return jsonResponse(['status' => 0]);
        }
    }

    public function getUsersForAjax()
    {
        return Datatables()->of(User::latest()->get())
            ->addIndexColumn()
            ->addColumn('active_status', function ($data) {
                $html = '';
                if ($data->status == 1) {
                    $html = "<span class='badge badge-success'>აქტიური</span>";
                } else {
                    $html = "<span class='badge badge-danger'>არა აქტიური</span>";
                }
                return $html;
            })
            ->addColumn('action', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light staff_info" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="ინფორმაცია" href="javascript:void(0)"><i class="fa fa-user"></i></a>';
                return $html;
            })
            ->rawColumns(['role', 'action', 'active_status'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'System Administrator')->pluck('name', 'name')->all();
        return view('pages.staff_info.blade.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:staff_info.blade,username',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect(url('/staff_info.blade'))
            ->with('success', 'მომხმარებელი წარმატებით დარეგისტრირდა');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('pages.staff_info.blade.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('pages.staff_info.blade.edit', compact('user', 'roles', 'userRole'));
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function update(UpdateUserRequest $request)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $input['tel'] = str_replace(' ','',$request->tel);
        $user = User::find($request->id);
        $user->update($input);

        return jsonResponse(['status' => 0]);
    }

    public function statusAction(Request $request)
    {
//        return $request->all();
        try {
            User::findOrFail($request->id)->update(['status' => $request->status]);
            return jsonResponse(['status' => 1]);
        } catch (\Exception $exception) {
            return jsonResponse(['status' => 0]);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            User::findOrFail($request->id)->delete();
            return jsonResponse(['status' => 1]);
        } catch (\Exception $exception) {
            return jsonResponse(['status' => 0]);
        }
    }
}
