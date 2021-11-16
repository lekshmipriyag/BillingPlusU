<?php

namespace App\Http\Controllers;

use App\Claims;
use App\Doctors;
use App\FavoriteLists;
use App\ItemNumbers;
use App\Locations;
use App\SpRelations;
use App\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    // Index
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type == "personal") {
                return redirect('dashboard_personal');
            }
            if (Auth::user()->type == "processor") {
                return redirect('dashboard_processor');
            }
            if (Auth::user()->type == "practice") {
                return redirect('dashboard_practice');
            }
            if (Auth::user()->type == "admin") {
                return redirect('dashboard_admin');
            }
            return view('index');
        }
        return redirect('login');
    }

    // Image
    public function image(String $claim_id, String $filename)
    {
        if (Auth::check()) {
            if (Auth::user()->type == "processor") {
                $id = Claims::where('id', $claim_id)->first()->user_id;
            } else {
                $id = Auth::id();
            }
            $path = storage_path('/uploads/sticker/' . $id . '/' . $filename);
            if (!File::exists($path)) {
                abort(404);
            }
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        }
        return redirect('login');
    }

    // Personal
    public function dashboardPersonal()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }
            return view(
                'dashboard_personal',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'count' => Claims::where('user_id', Auth::id())->count(),
                    'claims' => Claims::where('user_id', Auth::id())->where('status', '!=', 'Discharged')->orderBy('updated_at', 'DESC')->get(),
                    'item_numbers' => ItemNumbers::where('user_id', Auth::id())->orderBy('item_numbers', 'ASC')->get()
                ]
            );
        }
        return redirect('login');
    }

    private function distinctLocation()
    {
        $claims = Claims::where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->get();
        $value = array();
        $result = array();
        foreach ($claims as $claim) {
            if (!in_array($claim->location->id, $value)) {
                array_push($value, $claim->location->id);
                array_push($result, $claim->location);
            }
            if (count($value) >= 5) {
                break;
            }
        }
        return $result;
    }

    private function distinctDoctor()
    {
        $claims = Claims::where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->get();
        $value = array();
        $result = array();
        foreach ($claims as $claim) {
            if (!in_array($claim->doctor->id, $value)) {
                array_push($value, $claim->doctor->id);
                array_push($result, $claim->doctor);
            }
            if (count($value) >= 5) {
                break;
            }
        }
        return $result;
    }

    public function addNewClaimForm()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }
            $favorite_lists = FavoriteLists::where('user_id', Auth::id())->orderBy('favorite_list_name', 'ASC')->get();
            if (count($favorite_lists) == 0) {
                $favorite_list = new FavoriteLists;
                $favorite_list->favorite_list_name = '';
                $favorite_list->item_numbers = '';
                $favorite_lists = [0 => $favorite_list];
            }
            return view(
                'add_new_claim',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'locations' => Locations::where('user_id', Auth::id())->orderBy('location', 'ASC')->get(),
                    'doctors' => Doctors::where('user_id', Auth::id())->orderBy('first_name', 'ASC')->get(),
                    'item_numbers' => ItemNumbers::where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->get(),
                    'recent_locations' => $this->distinctLocation(),
                    'recent_doctors' => $this->distinctDoctor(),
                    'favorite_lists' => $favorite_lists
                ]
            );
        }
        return redirect('login');
    }

    public function addNewClaim(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }

            session([
                'date_of_services' => $request->input('date_of_services'),
                'location' => $request->input('location'),
                'new_location' => $request->input('new_location'),
                'doctor' => $request->input('doctor'),
                'new_doctor_first_name' => $request->input('new_doctor_first_name'),
                'new_doctor_last_name' => $request->input('new_doctor_last_name'),
                'item_numbers[]' => $request->input('item_numbers[]'),
                'new_item_numbers' => $request->input('new_item_numbers'),
                'notes' => $request->input('notes')
            ]);

            $this->validate(
                $request,
                [
                    'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'date_of_services' => 'required|size:10',
                    'input_option' => 'required'
                ]
            );

            try {
                $claim = new Claims;

                $image = $request->file('image_file');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = storage_path('/uploads/sticker/' . Auth::id());
                $image->move($destinationPath, $filename);

                $claim->image_path = $filename;

                if (!empty($request->input('location'))) {
                    if (!Locations::where('id', $request->input('location'))->exists()) {
                        return redirect('add_new_claim')->with('error', 'The location does not exist!');
                    }
                    $location_id = $request->input('location');
                } else if (!empty($request->input('new_location'))) {
                    $this->validate(
                        $request,
                        [
                            'new_location' => 'max:150'
                        ]
                    );
                    $location = new Locations;
                    $location->user_id = Auth::id();
                    $location->location = $request->input('new_location');
                    $location->save();
                    $location_id = $location->id;
                } else {
                    return redirect('add_new_claim')->with('error', 'The location is required');
                }
                $claim->location_id = $location_id;

                $date = date_create_from_format('Y-m-d', $request->input('date_of_services'));
                $claim->date_of_services = $date;

                if (!empty($request->input('doctor'))) {
                    if (!Doctors::where('id', $request->input('doctor'))->exists()) {
                        return redirect('add_new_claim')->with('error', 'The doctor does not exist!');
                    }
                    $doctor_id = $request->input('doctor');
                } else if (!empty($request->input('new_doctor_first_name') && !empty($request->input('new_doctor_last_name')))) {
                    $this->validate(
                        $request,
                        [
                            'new_doctor_first_name' => 'alpha|max:150',
                            'new_doctor_last_name' => 'alpha|max:150'
                        ]
                    );
                    $doctor = new Doctors;
                    $doctor->user_id = Auth::id();
                    $doctor->title = "Dr.";
                    $doctor->first_name = $request->input('new_doctor_first_name');
                    $doctor->last_name = $request->input('new_doctor_last_name');
                    $doctor->save();
                    $doctor_id = $doctor->id;
                } else {
                    return redirect('add_new_claim')->with('error', 'The doctor is required');
                }
                $claim->doctor_id = $doctor_id;

                if ($request->input('input_option') == "0") {
                    $item_number_exist = false;
                    if (!empty($request->input('item_numbers', []))) {
                        $item_numbers = implode(",", $request->input('item_numbers', []));
                        $item_number_exist = true;
                    }
                    if (!empty($request->input('new_item_numbers'))) {
                        $new_item_numbers = str_replace(' ', '', $request->input('new_item_numbers'));
                        $re = '/^\d+(?:,\d+)*$/';
                        if (!preg_match($re, $new_item_numbers)) {
                            return redirect('add_new_claim')->with('error', 'Please put comma as a seperator only!');
                        }
                        $item_numbers_array = explode(",", $new_item_numbers);
                        $new_item_numbers = "";
                        foreach ($item_numbers_array as $item_number_member) {
                            if (!ItemNumbers::where('item_numbers', $item_number_member)->exists()) {
                                $item_number = new ItemNumbers;
                                $item_number->user_id = Auth::id();
                                $item_number->item_numbers = $item_number_member;
                                $item_number->save();
                            }
                            $new_item_numbers .= $item_number_member . ",";
                        }
                        if ($item_number_exist) {
                            $item_numbers .= "," . substr($new_item_numbers, 0, -1);
                        } else {
                            $item_numbers = substr($new_item_numbers, 0, -1);
                        }

                        $item_number_exist = true;
                    }
                    if (!$item_number_exist) {
                        return redirect('add_new_claim')->with('error', 'The item numbers is required');
                    }
                } else {
                    $favorite_list_checkbox_values = $request->input('favorite_list_checkbox_value', []);
                    $favorite_list_values = $request->input('favorite_list_value', []);
                    $favorite_list_names = $request->input('favorite_list_name', []);
                    $favorite_list_new_values = $request->input('favorite_list_new_value', []);
                    foreach ($favorite_list_checkbox_values as $key => $item) {
                        if ($item == "1") {
                            $new_item_numbers = str_replace(' ', '', $favorite_list_new_values[$key]);
                            $re = '/^\d+(?:,\d+)*$/';
                            if (!preg_match($re, $new_item_numbers)) {
                                return redirect('add_new_claim')->with('error', 'Please put comma as a seperator only!');
                            }
                        }
                    }
                    FavoriteLists::where('user_id', Auth::id())->delete();
                    foreach ($favorite_list_checkbox_values as $key => $item) {
                        if ($item == "1") {
                            $new_item_numbers = "";
                            $item_numbers_array = explode(",", str_replace(' ', '', $favorite_list_new_values[$key]));
                            foreach ($item_numbers_array as $item_number_member) {
                                if (!ItemNumbers::where('item_numbers', $item_number_member)->exists()) {
                                    $item_number = new ItemNumbers;
                                    $item_number->user_id = Auth::id();
                                    $item_number->item_numbers = $item_number_member;
                                    $item_number->save();
                                }
                                $new_item_numbers .= $item_number_member . ",";
                            }
                            $item_numbers = $favorite_list_values[$key];
                            if ($new_item_numbers) {
                                $item_numbers .= "," . substr($new_item_numbers, 0, -1);
                                $favorite_list_values[$key] = $item_numbers;
                            }
                        }
                        $favorite_list = new FavoriteLists;
                        $favorite_list->item_numbers = $favorite_list_values[$key];
                        $favorite_list->favorite_list_name = $favorite_list_names[$key];
                        $favorite_list->user_id = Auth::id();
                        $favorite_list->save();
                    }
                }

                $claim->item_numbers = $item_numbers;
                $claim->user_id = Auth::id();
                $claim->notes = $request->input('notes');
                $claim->status = "Waiting for Billing";
                $claim->doctor()->associate($claim->doctor_id);
                $claim->location()->associate($claim->location_id);
                $claim->save();

                session([
                    'date_of_services' => '',
                    'location' => '',
                    'new_location' => '',
                    'doctor' => '',
                    'new_doctor_first_name' => '',
                    'new_doctor_last_name' => '',
                    'item_numbers[]' => '',
                    'new_item_numbers' => '',
                    'notes' => ''
                ]);
            } catch (\Exception $e) {
                return redirect('add_new_claim')->with('error', 'Internal Error, please try again!');
            }

            return redirect('dashboard_personal')->with('success', 'Claim Successfully Added!');
        }
        return redirect('login');
    }

    public function rebillClaim(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }

            $this->validate(
                $request,
                [
                    'date_of_services' => 'required|size:10'
                ]
            );

            try {
                $claim = Claims::where('user_id', Auth::id())->where('status', '!=', 'Discharged')->where('id', $request->input('claim'))->first();

                if (count($claim) < 1 || empty($request->input('claim')) || !is_numeric($request->input('claim'))) {
                    return redirect('dashboard_personal')->with('error', 'Invalid Input!');
                }

                $item_number_exist = false;
                if (!empty($request->input('item_numbers', []))) {
                    $item_numbers = implode(",", $request->input('item_numbers', []));
                    $item_number_exist = true;
                }
                if (!empty($request->input('new_item_numbers'))) {

                    $new_item_numbers = str_replace(' ', '', $request->input('new_item_numbers'));
                    $re = '/^\d+(?:,\d+)*$/';
                    if (!preg_match($re, $new_item_numbers)) {
                        return redirect('dashboard_personal')->with('error', 'Please put comma as a seperator only!');
                    }
                    $item_numbers_array = explode(",", $new_item_numbers);
                    $new_item_numbers = "";
                    foreach ($item_numbers_array as $item_number_member) {
                        if (!ItemNumbers::where('item_numbers', $item_number_member)->exists()) {
                            $item_number = new ItemNumbers;
                            $item_number->user_id = Auth::id();
                            $item_number->item_numbers = $item_number_member;
                            $item_number->save();
                        }
                        $new_item_numbers .= $item_number_member . ",";
                    }
                    if ($item_number_exist) {
                        $item_numbers .= "," . substr($new_item_numbers, 0, -1);
                    } else {
                        $item_numbers = substr($new_item_numbers, 0, -1);
                    }

                    $item_number_exist = true;
                }
                if (!$item_number_exist) {
                    return redirect('dashboard_personal')->with('error', 'The item numbers is required');
                }

                $newClaim = $claim->replicate();
                $newClaim->date_of_services = date_create_from_format('Y-m-d', $request->input('date_of_services'));
                $newClaim->item_numbers = $item_numbers;
                $newClaim->status = "Waiting for Billing";
                $newClaim->save();
            } catch (\Exception $e) {
                return redirect('dashboard_personal')->with('error', 'Internal Error, please try again!');
            }
            return redirect('dashboard_personal')->with('success', 'Claim Successfully Rebilled!');
        }
        return redirect('login');
    }

    public function dischargeClaim(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }
            try {
                $claim = Claims::where('user_id', Auth::id())->where('status', '!=', 'Discharged')->where('id', $request->input('claim'))->first();

                if (count($claim) < 1 || empty($request->input('claim')) || !is_numeric($request->input('claim'))) {
                    return redirect('dashboard_personal')->with('error', 'Invalid Input!');
                }
                $claim->status = "Discharged";
                $claim->save();
            } catch (\Exception $e) {
                return redirect('dashboard_personal')->with('error', $e->getMessage());
            }
            return redirect('dashboard_personal')->with('success', 'Claim Successfully Discharged!');
        }
        return redirect('login');
    }

    public function manageProcessorForm()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }
            return view(
                'manage_processor',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'has_processor' => SpRelations::where('specialist_id', Auth::id())->first(),
                    'pending_processors' => SpRelations::where('specialist_id', Auth::id())->where('status', 'Pending')->orderBy('updated_at', 'DESC')->get(),
                    'active_processors' => SpRelations::where('specialist_id', Auth::id())->where('status', 'Active')->orderBy('updated_at', 'DESC')->get()
                ]
            );
        }
        return redirect('login');
    }

    public function manageProcessor(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }
            try {
                $spRelations = SpRelations::where('specialist_id', Auth::id())->where('processor_id', $request->input('processor'))->first();

                if (count($spRelations) < 1 || empty($request->input('status')) || !is_numeric($request->input('status'))) {
                    return redirect('manage_processor')->with('error', 'Invalid Input!');
                }

                $status = (int) $request->input('status');
                switch ($status) {
                    case 1:
                        if ($spRelations->status != "Pending") {
                            return redirect('manage_processor')->with('error', 'Invalid Input!');
                        }
                        $active_relation = SpRelations::where('specialist_id', Auth::id())->where('status', 'active')->first();
                        if (count($active_relation) > 0) {
                            return redirect('manage_processor')->with('error', 'This plan only allow 1 processor');
                        }
                        $spRelations->status = "Active";
                        $spRelations->save();
                        break;
                    case 2:
                        if ($spRelations->status != "Active") {
                            return redirect('manage_processor')->with('error', 'Invalid Input!');
                        }
                        $spRelations->delete();
                        break;
                    case 3:
                        if ($spRelations->status != "Pending") {
                            return redirect('manage_processor')->with('error', 'Invalid Input!');
                        }
                        $spRelations->delete();
                        break;
                    default:
                        return redirect('manage_processor')->with('error', 'Invalid Input!');
                        break;
                }
            } catch (\Exception $e) {
                return redirect('manage_processor')->with('error', 'Failed!');
            }

            return redirect('manage_processor')->with('success', 'Success!');
        }
        return redirect('login');
    }

    private function claimOfMonth(int $num, int $user_id)
    {
        if (Auth::user()->type == "personal" || Auth::user()->type == "processor") {
            return Claims::where('user_id', $user_id)->whereBetween(
                'created_at',
                [
                    Carbon::now()->startOfMonth()->subMonth($num),
                    Carbon::now()->endOfMonth()->subMonth($num)
                ]
            )->count();
        }
        return redirect('/');
    }

    private function claimOfWeek(int $num, int $user_id)
    {
        if (Auth::user()->type == "personal" || Auth::user()->type == "processor") {
            $datetime = Carbon::now()->subMonth($num);
            $year = $datetime->year;
            $month = $datetime->month;
            $day = $datetime->day;
            $date = Carbon::createFromDate($year, $month);
            $numberOfWeeks = floor($date->daysInMonth / Carbon::DAYS_PER_WEEK);
            $data = array();
            $week = array();
            $j = 1;
            $day = $date->daysInMonth;
            for ($i = 1; $i <= $day; $i++) {
                array_push(
                    $data,
                    Claims::where('user_id', $user_id)->whereBetween(
                        'created_at',
                        [
                            Carbon::createFromDate($year, $month, $i)->startOfWeek(),
                            Carbon::createFromDate($year, $month, $i)->endOfweek()
                        ]
                    )->count()
                );
                array_push($week, 'Week ' . $j);
                $i += 7;
                $j++;
            }
            $result['label'] = $week;
            $result['data'] = $data;
            return $result;
        }
        return redirect('/');
    }

    private function claimStatus()
    {
        $discharged = 0;
        $processed = 0;
        $waiting = 0;
        $result['index'] = [0, 1, 2];
        $result['label'] = ['Processed', 'Waiting for Billing', 'Discharged'];
        $result['color'] = ['primary', 'secondary',  'info', 'brand', 'danger', 'success'];
        $result['donut_color'] = ['#5969ff', '#ff407b', '#25d5f2', '#ffc750', '#ef172c', '#2ec551'];
        foreach (Claims::where('user_id', Auth::id())->get() as $claim) {
            switch ($claim->status) {
                case 'Processed':
                    $processed++;
                    break;
                case 'Waiting for Billing':
                    $waiting++;
                    break;
                case 'Discharged':
                    $discharged++;
                    break;
                default:
                    break;
            }
        }
        $result['data'] = [$processed, $waiting, $discharged];
        return $result;
    }

    public function dataAnalyticsPersonal()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "personal") {
                return redirect('/');
            }
            return view(
                'data_analytics_personal',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'total_claims_num' => Claims::where('user_id', Auth::id())->count(),
                    'patients_num' => Claims::where('user_id', Auth::id())->select('title', 'first_name', 'middle_name', 'last_name')->whereNotNull('first_name')->distinct()->get()->count(),
                    'this_month_claims_num' => $this->claimOfMonth(0, Auth::id()),
                    'last_month_claims_num' => $this->claimOfMonth(1, Auth::id()),
                    'this_month_claims' => $this->claimOfWeek(0, Auth::id()),
                    'last_month_claims' => $this->claimOfWeek(1, Auth::id()),
                    'claim_status' => $this->claimStatus()
                ]
            );
        }
        return redirect('login');
    }

    // Processor
    public function dashboardProcessor()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "processor") {
                return redirect('/');
            }
            return view(
                'dashboard_processor',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'specialists' => SpRelations::where('processor_id', Auth::id())->orderBy('status', 'ASC')->orderBy('updated_at', 'DESC')->get(),
                    'active_specialist_num' => SpRelations::where('processor_id', Auth::id())->where('status', "Active")->count()
                ]
            );
        }
        return redirect('login');
    }

    public function manageAllClaim(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "processor") {
                return redirect('/');
            }
            $spRelations = SpRelations::where('processor_id', Auth::id())->where('status', 'Active')->get()->toarray();

            if (count($spRelations) < 1) {
                return redirect('dashboard_processor')->with('error', 'No Claim Available!');
            }
            $specialist_ids = array_column($spRelations, 'specialist_id');
            session()->forget("user_id");
            return view(
                'manage_all_claim',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => 'processor',
                    'claim_waiting' => Claims::whereIn('user_id', $specialist_ids)->where('status', 'Waiting for Billing')->orderBy('updated_at', 'DESC')->get(),
                    'claim_process' => Claims::whereIn('user_id', $specialist_ids)->where('status', 'Processed')->orderBy('updated_at', 'DESC')->get()
                ]
            );
        }
        return redirect('login');
    }

    public function addSpecialist(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "processor") {
                return redirect('/');
            }
            $this->validate(
                $request,
                [
                    'email' => 'required|email|max:150'
                ]
            );

            try {

                $user = Users::where('email', $request->input('email'))->first();

                if (count($user) < 1) {
                    return redirect('dashboard_processor')->with('error', 'Email does not exist!');
                }

                if ($user->id == Auth::id()) {
                    return redirect('dashboard_processor')->with('error', 'Cannot be yourself!');
                }

                if ($user->type == "processor" || $user->type == "admin") {
                    return redirect('dashboard_processor')->with('error', 'Must be specialist!');
                }

                if (SpRelations::where('processor_id', Auth::id())->where('specialist_id', $user->id)->first()) {
                    return redirect('dashboard_processor')->with('error', 'Already exist!');
                }

                $spRelations = new SpRelations;
                $spRelations->specialist_id = $user->id;
                $spRelations->processor_id = Auth::id();
                $spRelations->status = "Pending";
                $spRelations->save();
            } catch (\Exception $e) {
                return redirect('dashboard_processor')->with('error', 'Failed!');
            }

            return redirect('dashboard_processor')->with('success', 'Success!');
        }
        return redirect('login');
    }

    public function deleteSpecialist(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->type != "processor") {
                return redirect('/');
            }
            try {
                $spRelations = SpRelations::where('processor_id', Auth::id())->where('specialist_id', $request->input('specialist'))->first();

                if (count($spRelations) < 1 || empty($request->input('specialist')) || !is_numeric($request->input('specialist'))) {
                    return redirect('dashboard_processor')->with('error', 'Invalid Input!');
                }
                $spRelations->delete();
            } catch (\Exception $e) {
                return redirect('dashboard_processor')->with('error', 'Failed!');
            }
            return redirect('dashboard_processor')->with('success', 'Success!');
        }
        return redirect('login');
    }

    private function claimPerSpecialist()
    {
        $discharged = 0;
        $processed = 0;
        $waiting = 0;
        $result['index_specialist'] = array();
        $result['label_specialist'] = array();
        $result['data_specialist'] = array();
        $result['color_specialist'] = ['primary', 'secondary',  'info', 'brand', 'danger', 'success'];
        $result['donut_color_specialist'] = ['#5969ff', '#ff407b', '#25d5f2', '#ffc750', '#ef172c', '#2ec551'];
        $result['total_claims'] = 0;
        $result['this_month_claims_num'] = 0;
        $result['last_month_claims_num'] = 0;
        $result['label_week'] = array();
        $result['data_this_month'] = array();
        $result['data_last_month'] = array();
        $counter = 0;
        $specialist_ids = SpRelations::where('processor_id', Auth::id())->where('status', 'Active')->distinct('specialist_id')->get('specialist_id');
        foreach ($specialist_ids as $specialist_id) {
            $specialist = Users::where('id', $specialist_id->specialist_id)->first();
            $count = Claims::where('user_id', $specialist_id->specialist_id)->count();
            $this_month_claims_num = $this->claimOfMonth(0, $specialist_id->specialist_id);
            $last_month_claims_num = $this->claimOfMonth(1, $specialist_id->specialist_id);
            array_push($result['index_specialist'], $counter);
            array_push($result['label_specialist'], $specialist['first_name'] . $specialist['last_name']);
            array_push($result['data_specialist'], $count);
            $counter++;
            $result['total_claims'] += $count;
            $result['this_month_claims_num'] += $this_month_claims_num;
            $result['last_month_claims_num'] += $last_month_claims_num;
            $this_month = $this->claimOfWeek(0, $specialist_id->specialist_id);
            $last_month = $this->claimOfWeek(1, $specialist_id->specialist_id);
            $result['label_week'] = $this_month['label'];
            if ($result['data_this_month']) {
                for ($i = 0; $i < count($this_month['data']); $i++) {
                    $result['data_this_month'][$i] += $this_month['data'][$i];
                }
            } else {
                $result['data_this_month'] = $this_month['data'];
            }

            if ($result['data_last_month']) {
                for ($i = 0; $i < count($last_month['data']); $i++) {
                    $result['data_last_month'][$i] += $last_month['data'][$i];
                }
            } else {
                $result['data_last_month'] = $last_month['data'];
            }
        }
        return $result;
    }

    public function dataAnalyticsProcessor()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "processor") {
                return redirect('/');
            }
            $result = $this->claimPerSpecialist();
            return view(
                'data_analytics_processor',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'claims' => $result,
                    'specialists_num' => SpRelations::where('processor_id', Auth::id())->where('status', 'Active')->distinct('specialist_id')->count('specialist_id')
                ]
            );
        }
        return redirect('login');
    }

    // Personal & Processor
    public function claimDetailsForm($id = null)
    {
        if (Auth::check()) {
            $type = Auth::user()->type;
            if ($type == "processor") {
                $user_id = Claims::where('id', $id)->first()->user_id;
            } else if ($type == "personal") {
                $user_id = Auth::id();
            } else {
                return redirect('/');
            }
            $claim = Claims::where('id', $id)->first();

            if (count($claim) < 1 || empty($id) || !is_numeric($id)) {
                return redirect('/')->with('error', 'Invalid Claim!');
            }
            return view(
                'claim_details',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => $type,
                    'claim' => $claim,
                    'doctors' => Doctors::where('user_id', $user_id)->orderBy('first_name', 'ASC')->get(),
                    'item_numbers' => ItemNumbers::where('user_id', $user_id)->orderBy('item_numbers', 'ASC')->get(),
                    'titles' => ['Mr', 'Mrs', 'Miss', 'Dr', 'X'],
                    'states' => [
                        'New South Wales',
                        'Victoria',
                        'Queensland',
                        'Western Australia',
                        'Tasmania',
                        'Australian Capital Territory',
                        'Northern Territory'
                    ],
                    'genders' => ['Male', 'Female'],
                    'locations' => Locations::where('user_id', $user_id)->orderBy('location', 'ASC')->get()
                ]
            );
        }
        return redirect('login');
    }

    public function manageClaimForm($id = null)
    {
        if (Auth::check()) {
            $type = Auth::user()->type;
            if ($type == "personal") {
                $specialist = Auth::user();
                $id = Auth::id();
            } else if ($type == "processor") {
                $spRelations = SpRelations::where('processor_id', Auth::id())->where('specialist_id', $id)->where('status', 'Active')->first();

                if (count($spRelations) < 1 || empty($id) || !is_numeric($id)) {
                    return redirect('dashboard_processor')->with('error', 'Require specialist permission!');
                }
                $specialist = $spRelations->specialist;
                $id = $specialist->id;
            } else {
                return redirect('/');
            }
            session(["user_id" => $id]);
            return view(
                'manage_claim',
                [
                    'name' => Auth::user()->first_name,
                    'specialist' => $specialist,
                    'user_type' => $type,
                    'claim_waiting' => Claims::where('user_id', $id)->where('status', 'Waiting for Billing')->orderBy('updated_at', 'DESC')->get(),
                    'claim_process' => Claims::where('user_id', $id)->where('status', 'Processed')->orderBy('updated_at', 'DESC')->get()
                ]
            );
        }
        return redirect('login');
    }

    public function updateClaim(Request $request, $id = null)
    {
        if (Auth::check()) {
            $this->validate(
                $request,
                [
                    'title' => 'nullable|max:5',
                    'first_name' => 'required|alpha|max:150',
                    'middle_name' => 'nullable|alpha|max:150',
                    'last_name' => 'nullable|alpha|max:150',
                    'item_numbers' => 'required|regex:/^\d+(?:,\d+)*$/',
                    'referral_date' => 'nullable|regex:/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/',
                    'date_of_services' => 'nullable|regex:/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/'
                ]
            );

            try {
                $claim = Claims::where('id', $id)->first();

                if (count($claim) < 1 || empty($id) || !is_numeric($id)) {
                    return redirect()->back()->with('error', 'Invalid Input!');
                }

                $path = storage_path('/uploads/sticker/' . $claim->user_id . '/' . $claim->image_path);
                if (!File::exists($path)) {
                    return redirect()->back()->with('error', 'Invalid Input!');
                }

                $image_data = explode(",", $request->input('sticker'));
                if (count($image_data) != 2) {
                    return redirect()->back()->with('error', 'Invalid Image!');
                }
                if ($image_data[1] != "empty") {
                    $file = base64_decode($image_data[1]);
                    file_put_contents($path, $file);
                }

                if (!empty($request->input('ref_doctor_first_name') && !empty($request->input('ref_doctor_last_name')))) {
                    $this->validate(
                        $request,
                        [
                            'ref_doctor_first_name' => 'alpha|max:150',
                            'ref_doctor_last_name' => 'alpha|max:150'
                        ]
                    );
                    $doctor = new Doctors;
                    $doctor->user_id = $claim->user_id;
                    $doctor->title = "Dr.";
                    $doctor->first_name = $request->input('ref_doctor_first_name');
                    $doctor->last_name = $request->input('ref_doctor_last_name');
                    $doctor->save();
                    $doctor_id = $doctor->id;
                } else if (!empty($request->input('ref_doctor'))) {
                    if (!Doctors::where('id', $request->input('ref_doctor'))->exists()) {
                        return redirect()->back()->with('error', 'The doctor does not exist!');
                    }
                    $doctor_id = $request->input('ref_doctor');
                } else {
                    return redirect()->back()->with('error', 'The doctor is required');
                }

                if (!empty($request->input('referral_date'))) {
                    $referral_date = date_create_from_format('d/m/Y', $request->input('referral_date'));
                } else {
                    $referral_date = NULL;
                }

                if (!empty($request->input('date_of_services'))) {
                    $date_of_services = date_create_from_format('d/m/Y', $request->input('date_of_services'));
                } else {
                    $date_of_services = NULL;
                }

                if (!empty($request->input('new_location'))) {
                    $this->validate(
                        $request,
                        [
                            'new_location' => 'max:150'
                        ]
                    );
                    $location = new Locations;
                    $location->user_id = $claim->user_id;
                    $location->location = $request->input('new_location');
                    $location->save();
                    $location_id = $location->id;
                } else if (!empty($request->input('location'))) {
                    if (!Locations::where('id', $request->input('location'))->exists()) {
                        return redirect()->back()->with('error', 'The location does not exist!');
                    }
                    $location_id = $request->input('location');
                } else {
                    return redirect()->back()->with('error', 'The location is required');
                }

                if (!empty($request->input('status'))) {
                    $status = "Processed";
                } else {
                    $status = "Waiting for Billing";
                }

                $claim->title = $request->input('title');
                $claim->first_name = $request->input('first_name');
                $claim->middle_name = $request->input('middle_name');
                $claim->last_name = $request->input('last_name');
                $claim->item_numbers = $request->input('item_numbers');
                $claim->doctor_id = $doctor_id;
                $claim->location_id = $location_id;
                $claim->referral_date = $referral_date;
                $claim->date_of_services = $date_of_services;
                $claim->notes = $request->input('notes');
                $claim->status = $status;
                $claim->doctor()->associate($claim->doctor_id);
                $claim->location()->associate($claim->location_id);
                $claim->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed!');
            }
            if ($status == "Processed") {
                $user_id = session()->get('user_id', null);
                if ($user_id) {
                    return redirect('manage_claim/' . $user_id);
                }
                return redirect('manage_all_claim');
            }
            return redirect()->back()->with('success', 'Success!');
        }
        return redirect('login');
    }

    public function contactUsForm()
    {
        if (Auth::check()) {
            return view(
                'contact_us',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type
                ]
            );
        }
        return redirect('login');
    }

    public function contactUs(Request $request)
    {
        if (Auth::check()) {
            return view('contact_us');
        }
        return redirect('login');
    }

    // Admin
    public function dashboardAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "admin") {
                return redirect('/');
            }
            return view(
                'dashboard_admin',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'specialists' => SpRelations::where('processor_id', Auth::id())->get()
                ]
            );
        }
        return redirect('login');
    }

    public function manageClaimAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "admin") {
                return redirect('/');
            }
            return view(
                'manage_claim_admin',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'claims' => Claims::all(),
                    'doctors' => Doctors::orderBy('first_name', 'ASC')->get(),
                    'item_numbers' => ItemNumbers::orderBy('item_numbers', 'ASC')->get(),
                    'titles' => ['Mr', 'Mrs', 'Miss', 'Dr', 'X'],
                    'states' => [
                        'New South Wales',
                        'Victoria',
                        'Queensland',
                        'Western Australia',
                        'Tasmania',
                        'Australian Capital Territory',
                        'Northern Territory'
                    ],
                    'genders' => ['Male', 'Female']
                ]
            );
        }
        return redirect('login');
    }

    public function manageReferralDoctorAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "admin") {
                return redirect('/');
            }
            return view(
                'manage_referraldoctor_admin',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'claims' => Claims::all(),
                    'doctors' => Doctors::all(),
                    'item_numbers' => ItemNumbers::all(),
                    'titles' => ['Mr', 'Mrs', 'Miss', 'Dr', 'X'],
                    'states' => [
                        'New South Wales',
                        'Victoria',
                        'Queensland',
                        'Western Australia',
                        'Tasmania',
                        'Australian Capital Territory',
                        'Northern Territory'
                    ],
                    'genders' => ['Male', 'Female']
                ]
            );
        }
        return redirect('login');
    }

    public function manageLocationAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "admin") {
                return redirect('/');
            }
            return view(
                'manage_location_admin',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'claims' => Claims::all(),
                    'doctors' => Doctors::all(),
                    'item_numbers' => ItemNumbers::all(),
                    'titles' => ['Mr', 'Mrs', 'Miss', 'Dr', 'X'],
                    'states' => [
                        'New South Wales',
                        'Victoria',
                        'Queensland',
                        'Western Australia',
                        'Tasmania',
                        'Australian Capital Territory',
                        'Northern Territory'
                    ],
                    'genders' => ['Male', 'Female']
                ]
            );
        }
        return redirect('login');
    }

    public function manageUserAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "admin") {
                return redirect('/');
            }
            return view(
                'manage_user_admin',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'claims' => Claims::all(),
                    'doctors' => Doctors::all(),
                    'item_numbers' => ItemNumbers::all(),
                    'titles' => ['Mr', 'Mrs', 'Miss', 'Dr', 'X'],
                    'states' => [
                        'New South Wales',
                        'Victoria',
                        'Queensland',
                        'Western Australia',
                        'Tasmania',
                        'Australian Capital Territory',
                        'Northern Territory'
                    ],
                    'genders' => ['Male', 'Female']
                ]
            );
        }
        return redirect('login');
    }

    public function manageFeedbackAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->type != "admin") {
                return redirect('/');
            }
            return view(
                'manage_feedback_admin',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type,
                    'claims' => Claims::all(),
                    'doctors' => Doctors::all(),
                    'item_numbers' => ItemNumbers::all(),
                    'titles' => ['Mr', 'Mrs', 'Miss', 'Dr', 'X'],
                    'states' => [
                        'New South Wales',
                        'Victoria',
                        'Queensland',
                        'Western Australia',
                        'Tasmania',
                        'Australian Capital Territory',
                        'Northern Territory'
                    ],
                    'genders' => ['Male', 'Female']
                ]
            );
        }
        return redirect('login');
    }
}
