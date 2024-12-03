<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\InsuranceRequest\SendNafathCodeRequestFormRequest;
use App\Http\Requests\Backend\Insurances\StoreInsuranceBenefitsFormRequest;
use App\Http\Requests\Backend\Insurances\StoreInsuranceFormRequest;
use App\Http\Requests\Backend\Insurances\UpdateInsuranceFormRequest;
use App\Models\Insurance;
use App\Models\InsuranceBenefit;
use App\Models\InsuranceRequest;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;

class InsuranceRequestsBackendController extends Controller
{
    use UploadImageTrait;

    // ========================================================================
    // =========================== index Function =============================
    // ========================================================================
    public function index(Request $request, Route $route)
    {
        try {
            $insuranceRequests = InsuranceRequest::orderBy('created_at', 'desc')->get();
            return view('admin.insurance_requests.index', compact('insuranceRequests'));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
    // ========================================================================
    // ============================ Show Function =============================
    // ========================================================================
    public function show($id, Route $route)
    {
        try {
            // $insurance = Insurance::with('projectWorkingEmployees')->find($id);
            $insuranceRequest = InsuranceRequest::find($id);
            if ($insuranceRequest) {
                return view('admin.insurance_requests.show', compact('insuranceRequest'));
            } else {
                return redirect()->route('super_admin.insurances-index')->with('danger', 'This data is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
    // ========================================================================
    // ======================== Soft Delete Function ==========================
    // ========================================================================
    public function softDelete($id, Route $route)
    {
        try {
            $insurance = InsuranceRequest::find($id);
            if ($insurance) {
                DB::transaction(function () use ($insurance) {
                    $insurance->delete();
                });
                return redirect()->back()->with('success', 'The Deletion process has been successful');
            } else {
                return redirect()->back()->with('danger', 'This data is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
    // ========================================================================
    // ====================== Show Soft Delete Function =======================
    // ========================================================================
    public function showSoftDelete(Request $request, Route $route)
    {
        try {
            $insurances = new Insurance();
            $insurances = $insurances->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            return view('admin.insurances.trashed', compact('insurances'));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== Soft Delete Restore Function ======================
    // ========================================================================
    public function softDeleteRestore($id, Route $route)
    {
        try {
            $insurance = Insurance::onlyTrashed()->find($id);
            if ($insurance) {
                DB::transaction(function () use ($insurance) {
                    $insurance->restore();
                });
                return redirect()->route('super_admin.insurances-showSoftDelete')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->back()->with('danger', 'This section does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
    // ========================================================================
    // ============================ send Nafath Code Function =============================
    // ========================================================================
    public function sendNafathCode($id)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            if ($insuranceRequest) {
                return view('admin.insurance_requests.send_nafath_code', compact('insuranceRequest'));
            }
            return redirect()->back()->with('danger', 'Record not found');
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }



    // ========================================================================
    // ===================== sendNafathCodeRequest Function ======================
    // ========================================================================
    public function sendNafathCodeRequest(SendNafathCodeRequestFormRequest $request, Route $route, $id)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            if (!$insuranceRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }

            // Validate that code is exactly 2 digits
            $code = $request->nafath_code;
            if (!preg_match('/^\d{2}$/', $code)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nafath code must be exactly 2 digits'
                ], 422);
            }

            DB::transaction(function () use ($insuranceRequest, $code) {
                $insuranceRequest->update([
                    'nafath_code' => $code,
                    'updated_at' => now()
                ]);
            });

            \Log::info('Nafath code set for insurance request ID: ' . $id . ' at ' . now());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nafath Code Added Successfully'
                ]);
            }

            return redirect()->route('super_admin.insurance_requests-index')
                           ->with('success', 'Nafath Code Added Successfully');

        } catch (\Throwable $th) {
            \Log::error('Error in sendNafathCodeRequest: ' . $th->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your request'
                ], 500);
            }

            $function_name = $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
}
