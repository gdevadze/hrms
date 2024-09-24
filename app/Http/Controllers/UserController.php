<?php

namespace App\Http\Controllers;

use App\Enums\ContactType;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Department;
use App\Models\Movement;
use App\Models\Position;
use App\Models\Sold;
use App\Models\UserCompany;
use App\Models\UserFile;
use App\Models\UserVacationQuantity;
use App\Models\Vacation;
use App\Models\WorkingSchedule;
use App\Services\Contracts\WorkSchedulingServiceContract;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Arr;

class UserController extends Controller
{
    private WorkSchedulingServiceContract $workSchedulingService;

    public function __construct(WorkSchedulingServiceContract $workSchedulingService)
    {
        $this->workSchedulingService = $workSchedulingService;
//        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
//        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $positions = Position::all();
        $departments = Department::all();
        $roles = Role::where('name','!=','System Administrator')->get();
        return view('pages.users.index',compact('positions','departments','roles'));
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

    public function resetPassword(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);
        $password = $user->personal_num;
        $newPassword = Hash::make($password);
        $user->update(['password' => $newPassword]);
        return \jsonResponse(['status' => 1,'password' => $password]);
    }

    public function accountDisable(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);
        $user->user_companies()->update(['status' => 0]);
        return \jsonResponse(['status' => 1]);
    }

    public function uploadFiles(Request $request,$id): JsonResponse
    {
        try {
            $data = $request->all();
            $conditions = $data['title'];
            foreach ($conditions as $key => $condition) {
                $fileName = time().'_'.$data['files'][$key]->getClientOriginalName();
                $filePath = $data['files'][$key]->storeAs('uploads', $fileName, 'public');
                UserFile::create([
                    'user_id' => $id,
                    'title' => $data['title'][$key],
                    'file' => $filePath
                ]);
            }

            return jsonResponse(['status' => 1]);
        } catch (\Exception $exception) {
            return jsonResponse(['status' => 0,'error' => $exception->getMessage()]);
        }
    }

    public function saveVacationDays(Request $request, $id): JsonResponse
    {
        try {
            UserVacationQuantity::updateOrCreate([
                'user_id' => $id,
                'year' => $request->year,
            ],[
                'quantity' => 24,
                'current_quantity' => $request->quantity ?? 0
            ]);

            $user = User::findOrFail($id);
            $userVacation = $user->user_vacation_quantities()->sum('quantity');
            $usedUserVacations = $user->user_vacation_quantities()->sum('current_quantity');
            return jsonResponse(['status' => 1,'html' => view('general.staff.vacation_days',compact('userVacation','usedUserVacations'))->render()]);
        } catch (\Exception $exception) {
            return jsonResponse(['status' => 0,'error' => $exception->getMessage()]);
        }
    }

    public function delays(): View
    {
        return view('pages.users.delays');
    }

    public function delaysAjax()
    {
        return Datatables()->of(Movement::query()->with('user')->whereNotNull('delay_reason'))
            ->addIndexColumn()
            ->addColumn('user_full_name', function ($data) {
                return $data->user->full_name;
            })
            ->addColumn('formatted_start_date', function ($data) {
                if($data->checkUser($data->user['working_schedule']['week_days']))
                    return '<span
                        class="badge text-bg-success">'.$data->formatted_start_date.'</span>';
                else{
                    return '<span
                        class="badge text-bg-danger">'.$data->formatted_start_date.'</span>';
                }
            })
            ->addColumn('formatted_late', function ($data) {
                if($data->checkUser($data['working_schedule']['week_days']))
                    return '';
                else{
                    $test = Carbon::parse($data->start_date)->diffInSeconds($data->checkUserLate($data['working_schedule']['week_days']));
                    return ((int)gmdate('H',$test)) ? (int)gmdate('H',$test).' სთ და '.(int)gmdate('i',$test).' წთ' : (int)gmdate('i',$test).' წთ';
                }
            })
            ->addColumn('formatted_end_date', function ($data) {
                if($data->checkUser($data->user['working_schedule']['week_days'],true))
                    return '<span
                                                            class="badge text-bg-success">'.$data->formatted_end_date.'</span>';
                else{
                    return '<span
                                                            class="badge text-bg-danger">'.$data->formatted_end_date.'</span>';
                }
            })
            ->addColumn('action', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light staff_info" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('information').'" href="javascript:void(0)"><i class="fa fa-user"></i></a>';
                return $html;
            })
            ->rawColumns(['formatted_end_date', 'action', 'formatted_start_date','formatted_late'])
            ->make(true);
    }

    public function getUsersForAjax(Request $request)
    {
        $users = User::query()->where('status',1);
        if($request->role_id){
            $users = $users->role($request->role_id);
        }
        if($request->department_id){
            $users = $users->whereHas('user_companies', function ($q) use($request){
                return $q->where('department_id',$request->department_id);
            });
        }
        if($request->position_id){
            $users = $users->whereHas('user_companies', function ($q) use($request){
                return $q->where('position_id',$request->position_id);
            });
        }
        return Datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('company_title_position', function ($data) {
                $html = '';
                foreach ($data->user_companies as $userCompany){
                    $html.= $userCompany->position->title.'<br>';
                }
                return $html;
            })
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
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light staff_info" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('information').'" href="javascript:void(0)"><i class="fa fa-user"></i></a>';
                $html .= ' <a class="btn btn-soft-secondary waves-effect waves-light card_register" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="ბარათის რეგისტრაცია" href="javascript:void(0)"><i class="las la-id-card-alt"></i></a>';
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="რედაქტირება" href="'.route('users.edit',$data->id).'"><i class="fa fa-edit"></i></a>';
                $html .= ' <a class="btn btn-soft-danger waves-effect waves-light change-password" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="პაროლის შეცვლა" href="javascript:void(0)"><i class="fa fa-key"></i></a>';
                if($data->user_companies()->where('status',1)->count() > 0){
                    $html.= ' <a class="btn btn-soft-danger waves-effect waves-light account-disable" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="პროფილის გაუქმება" href="javascript:void(0)"><i class="fa fa-ban"></i></a>';
                }
                return $html;
            })
            ->rawColumns(['role', 'action', 'active_status','company_title_position'])
            ->make(true);

    }

    public function userCardRegisterRender(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        return jsonResponse(['status' => 0,'html' => view('general.users.card_register',compact('user'))->render()]);
    }

    public function userCardRegister(Request $request,$id): JsonResponse
    {
        $user = User::findOrFail($id)->update(['card_number' => $request->card_number]);
        return jsonResponse(['status' => 0,'msg' => 'ბარათის რეგისტრაცია წარმატებით განხორციელდა!']);
    }

    public function getUserFilesForAjax($id)
    {
        return Datatables()->of(UserFile::query()->where('user_id',$id))
            ->addIndexColumn()
            ->addColumn('download_file', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('download_file').'" href="'.route('users.download.file',$data->id).'"><i class="ri-download-2-line" aria-hidden="true"></i></a>';
                return $html;
            })
            ->addColumn('action', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light staff_info" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('information').'" href="javascript:void(0)"><i class="fa fa-user"></i></a>';
                return $html;
            })
            ->rawColumns(['download_file', 'action', 'active_status'])
            ->make(true);

    }

    public function changeVacationDaysStatus(Request $request): JsonResponse
    {
        $userVacationQuantity = UserVacationQuantity::findOrFail($request->id);
        $id = $userVacationQuantity->user_id;
        $user = User::findOrFail($id);
        $userVacationQuantity->update(['status' => $request->status]);
        $userVacation = $user->user_vacation_quantities()->sum('quantity');
        $usedUserVacations = $user->user_vacation_quantities()->sum('current_quantity');
        return jsonResponse(['status' => 1,'html' => view('general.staff.vacation_days',compact('userVacation','usedUserVacations'))->render()]);
    }

    public function changeVacationDays(Request $request): JsonResponse
    {
        $userVacationQuantity = UserVacationQuantity::findOrFail($request->id);
        return jsonResponse(['status' => 0,'vacation' => $userVacationQuantity]);
    }

    public function getUserVacationQuantitiesForAjax($id): JsonResponse
    {
        return Datatables()->of(UserVacationQuantity::query()->where('user_id',$id)->where('status',1))
            ->addIndexColumn()
            ->addColumn('vacation_days', function ($data) {
                $userVacation = $data->quantity;
                $usedUserVacations = $data->current_quantity;

                return $userVacation - $usedUserVacations;
            })
            ->addColumn('action', function ($data) {
                $html = '<button type="button" class="btn rounded-pill btn-primary waves-effect waves-light edit-vacation-days" data-id="'.$data->id.'" data-status="0">რედაქტირება</button> ';
                if($data->status == 1){
                    $html .= '<button type="button" class="btn rounded-pill btn-danger waves-effect waves-light change-vacation-days-status" data-id="'.$data->id.'" data-status="0">გაუქმება</button>';
                }else{
                    $html .= '<button type="button" class="btn rounded-pill btn-success waves-effect waves-light change-vacation-days-status" data-id="'.$data->id.'" data-status="1">გააქტიურება</button>';
                }
                return $html;
            })
            ->rawColumns(['download_file', 'action', 'active_status'])
            ->make(true);

    }

    public function getUserVacationForAjax($id)
    {
        return Datatables()->of(Vacation::query()->where('user_id',$id))
            ->addIndexColumn()
            ->addColumn('download_file', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light" data-bs-toggle="tooltip" target="_blank" data-bs-placement="top" title="PDF" href="'.route('vacations.pdf',$data->id).'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['download_file', 'action', 'active_status'])
            ->make(true);
    }

    public function subordinates(): View
    {
        return view('pages.users.subordinates');
    }

    public function subordinatesAjax(): JsonResponse
    {
        return Datatables()->of(UserCompany::query()->whereHas('position',function ($q){
            return $q->where('manager_id',currentUser()->id);
        }))
            ->addIndexColumn()
            ->addColumn('user_full_name', function ($data) {
                return $data->user->full_name;
            })
            ->addColumn('user_tel', function ($data) {
                return $data->user->tel;
            })
            ->addColumn('user_personal_num', function ($data) {
                return $data->user->personal_num;
            })
            ->addColumn('download_file', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('download_file').'" href="'.route('users.download.file',$data->user_id).'"><i class="ri-download-2-line" aria-hidden="true"></i></a>';
                return $html;
            })
            ->addColumn('action', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light staff_info" data-id="'.$data->user_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('information').'" href="javascript:void(0)"><i class="fa fa-user"></i></a>';
                $html = $html.= ' <a class="btn btn-soft-danger waves-effect waves-light change-password" data-id="'.$data->user_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="პაროლის შეცვლა" href="javascript:void(0)"><i class="fa fa-key"></i></a>';
                return $html;
            })
            ->rawColumns(['download_file', 'action', 'active_status'])
            ->make(true);
    }

    public function downloadFile($id)
    {
        $userFile = UserFile::findOrFail($id);

        return response()->download(public_path('storage/'.$userFile->file));
    }

    public function createRender(): JsonResponse
    {
        $companies = Company::all();
        $workingSchedules = WorkingSchedule::all();
        $positions = Position::all();
        $roles = Role::where('name','!=','System Administrator')->get();
        $contractTypes = ContactType::all();
        return jsonResponse(['html' => view('general.users.create',compact('companies','workingSchedules','positions','roles','contractTypes'))->render(),'status' => 0]);
    }

    public function create(): View
    {
        $companies = Company::all();
        $workingSchedules = WorkingSchedule::all();
        $positions = Position::all();
        $roles = Role::where('name','!=','System Administrator')->get();
        $contractTypes = ContactType::all();
        $departments = Department::all();
        $countries = Country::all();
        return view('pages.users.create',compact('companies','workingSchedules','positions','departments','roles','contractTypes','countries'));
    }

    public function store(StoreUserRequest $request, UserService $userService): JsonResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make('password');
        $input['working_schedule_id'] = $request->working_schedule_ids[0];
        $input['company_id'] = $request->company_ids[0];
        $input['tel'] = str_replace(' ','',$request->tel);
        $input['birthdate'] = Carbon::parse($input['birthdate'])->format('Y-m-d');
        $user = User::create($input);
        if($request->company_ids){
            for ($i = 0; $i < count($request->company_ids); $i++) {
                $user->user_companies()->create([
                    'company_id' => $request->post('company_ids')[$i],
                    'working_schedule_id' => $request->post('working_schedule_ids')[$i],
                    'department_id' => isset($request->post('department_ids')[$i]) ? $request->post('department_ids')[$i] : null,
                    'position_id' => isset($request->post('position_ids')[$i]) ? $request->post('position_ids')[$i] : null,
                    'contract_date' => isset($request->post('contract_dates')[$i]) ? Carbon::parse($request->post('contract_dates')[$i])->format('Y-m-d') : null,
                    'contract_end_date' => isset($request->post('contact_end_dates')[$i]) ? Carbon::parse($request->post('contact_end_dates')[$i])->format('Y-m-d') : null,
                    'contract_type_id' => isset($request->post('contact_types')[$i]) ? $request->post('contact_types')[$i] : null
                ]);
            }
        }
        $user->assignRole($request->input('roles'));

        return jsonResponse(['status' => 0,'msg' => 'თანამშრომელი წარმატებით დაემატა, პაროლი: '.$input['tel']]);
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
        $companies = Company::all();
        $workingSchedules = WorkingSchedule::all();
        $positions = Position::all();
        $contractTypes = ContactType::all();
        $departments = Department::all();
        $countries = Country::all();
        return view('pages.users.edit', compact('user', 'roles', 'userRole','companies','workingSchedules','positions','departments','contractTypes','countries'));
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function update(UpdateUserRequest $request,$id)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $input['tel'] = str_replace(' ','',$request->tel);
        $input['birthdate'] = Carbon::parse($input['birthdate'])->format('Y-m-d');
//        return $input;
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        if($request->company_ids){
            for ($i = 0; $i < count($request->company_ids); $i++) {
                $user->user_companies()->create([
                    'company_id' => $request->post('company_ids')[$i],
                    'working_schedule_id' => $request->post('working_schedule_ids')[$i],
                    'department_id' => isset($request->post('department_ids')[$i]) ? $request->post('department_ids')[$i] : null,
                    'position_id' => isset($request->post('position_ids')[$i]) ? $request->post('position_ids')[$i] : null,
                    'contract_date' => isset($request->post('contract_dates')[$i]) ? Carbon::parse($request->post('contract_dates')[$i])->format('Y-m-d') : null,
                    'contract_end_date' => isset($request->post('contact_end_dates')[$i]) ? Carbon::parse($request->post('contact_end_dates')[$i])->format('Y-m-d') : null,
                    'contract_type_id' => isset($request->post('contact_types')[$i]) ? $request->post('contact_types')[$i] : null
                ]);
            }
        }
        $user->assignRole($request->input('roles'));
        return redirect()->to(route('users.index'))->with('success','თანამშრომლის ინფორმაცია წარმატებით განახლდა!');
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

    public function editUserCompany(Request $request)
    {
        $userCompany = UserCompany::findOrFail($request->id);
        $companies = Company::all();
        $workingSchedules = WorkingSchedule::all();
        $positions = Position::all();
        $contractTypes = ContactType::all();
        $departments = Department::all();
        return jsonResponse(['status' => 0,'html' =>view('general.users.edit_user_company',compact('userCompany','companies','workingSchedules','positions','departments','contractTypes'))->render()]);
    }

    public function updateUserCompany(Request $request,$id)
    {
        $data = $request->all();
        $data['contract_date'] = Carbon::parse($request->contract_date)->format('Y-m-d');
        $data['contract_end_date'] = Carbon::parse($request->contract_end_date)->format('Y-m-d');
        UserCompany::findOrFail($id)->update($data);
        return jsonResponse(['status' => 0]);
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
