<?php

namespace App\Http\Requests\Backend\Employees;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupervisorEmployeeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        //    ============================================ EDITED BY RAGHAD ============================================
        $projectCoordinators = User::where('status', 1)->where('employee_type_id', 4)->select('id', 'name', 'employee_type_id', 'status')->pluck('id')->toArray();
        // Design
        $designDepartments = Department::where('status', '1')->where('department_type_id', 3)->pluck('id')->toArray();
        $designDepartmentsSupervisors =  User::where('department_id', isset($this->design_department_id) ? $this->design_department_id : 0)->pluck('id')->toArray();
        // Web
        $webDepartments = Department::where('status', '1')->where('department_type_id', 1)->pluck('id')->toArray();
        $webDepartmentsSupervisors = User::where('department_id',  isset($this->web_department_id) ? $this->web_department_id : 0)->whereIn('employee_type_id', [1, 2])->pluck('id')->toArray();
        // Mobile
        $mobileDepartments = Department::where('status', '1')->where('department_type_id', 2)->pluck('id')->toArray();
        $mobileDepartmentSupervisors = User::where('department_id', isset($this->mobile_department_id) ? $this->mobile_department_id : 0)->whereIn('employee_type_id', [1, 2])->pluck('id')->toArray();
        // Accessors Arrays
        $statusArray = [1, 2, 3]; // 1 => In Queue, 2 => In Progress, 3 => Completed
        $programmingLanguagesWebArray = [1, 2, 3, 4]; // 1 => Laravel, 2 => Drupal, 3 => WordPress, 4 => Not Decided Yet
        $programmingLanguagesMobileArray = [1, 2, 3, 4]; // 1 => IOS, 2 => Android, 3 => Flutter, 4 => Andoid + IOS

        $rules = [
            'project_project_coordinator_name' => ['nullable', 'numeric', 'integer', Rule::in($projectCoordinators)],
            // BA
            'gather_analyze_requirements_supervisor_id' => ['nullable', 'numeric', 'integer',  Rule::in($projectCoordinators)],
            'gather_analyze_requirements_status' => ['numeric', 'integer', Rule::in($statusArray)],
            // Design Department
            'design_department_id' => ['nullable', 'numeric', 'integer', Rule::in($designDepartments)],
            'design_supervisor_id' => ['nullable', 'numeric', 'integer', Rule::in($designDepartmentsSupervisors)],
            'design_status' => ['nullable', 'numeric', 'integer', Rule::in($statusArray)],
            // Web Department
            'web_department_id' => ['nullable', 'numeric', 'integer', Rule::in($webDepartments)],
            'web_supervisor_id' => ['nullable', 'numeric', 'integer', Rule::in($webDepartmentsSupervisors)],
            'web_status' => ['nullable', 'numeric', 'integer', Rule::in($statusArray)],
            'programming_language_used_web' => ['nullable', 'numeric', 'integer', Rule::in($programmingLanguagesWebArray)],
            // Mobile Department
            'mobile_department_id' => ['nullable', 'numeric', 'integer', Rule::in($mobileDepartments)],
            'mobile_supervisor_id' => ['nullable', 'numeric', 'integer', Rule::in($mobileDepartmentSupervisors)],
            'mobile_status' => ['nullable', 'numeric', 'integer', Rule::in($statusArray)],
            'programming_language_used_mobile' => ['nullable', 'numeric', 'integer', Rule::in($programmingLanguagesMobileArray)],
            // QA
            'quality_assurance_supervisor_id' => ['nullable', 'numeric', 'integer', Rule::in($projectCoordinators)],
            'quality_assurance_status' => ['nullable', 'numeric', 'integer', Rule::in($statusArray)],
        ];
        // ========================================== The following validation is Done By Raghad ==========================================

        // Project Project Coordinator Name
        if (isset($this->project_project_coordinator_name)) {
            $rules['project_project_coordinator_name'] = ['numeric', 'integer', Rule::in($projectCoordinators)];
        }

        // Check all fields of BA
        if (isset($this->gather_analyze_requirements_supervisor_id)) {
            $rules['gather_analyze_requirements_supervisor_id'] = ['numeric', 'integer',  Rule::in($projectCoordinators)];
            $rules['gather_analyze_requirements_status'] = ['required', 'numeric', 'integer', Rule::in($statusArray)];
        }

        // Check all fileds of Desgin Department
        if (isset($this->design_department_id)) {
            $rules['design_department_id'] = ['numeric', 'integer', Rule::in($designDepartments)];
            $rules['design_supervisor_id'] = ['required', 'numeric', 'integer', Rule::in($designDepartmentsSupervisors)];
            $rules['design_status'] = ['required', 'numeric', 'integer', Rule::in($statusArray)];
        }

        // Check all fileds of Web Department
        if (isset($this->web_department_id)) {
            $rules['web_department_id'] = ['numeric', 'integer', Rule::in($webDepartments)];
            $rules['web_supervisor_id'] = ['required', 'numeric', 'integer', Rule::in($webDepartmentsSupervisors)];
            $rules['web_status'] = ['required', 'numeric', 'integer', Rule::in($statusArray)];
            $rules['programming_language_used_web'] = ['required', 'numeric', 'integer', Rule::in($programmingLanguagesWebArray)];
        }
        // Check all fileds of Mobile Department
        if (isset($this->mobile_department_id)) {
            $rules['mobile_department_id'] = ['numeric', 'integer', Rule::in($mobileDepartments)];
            $rules['mobile_supervisor_id'] = ['required', 'numeric', 'integer', Rule::in($mobileDepartmentSupervisors)];
            $rules['mobile_status'] = ['required', 'numeric', 'integer', Rule::in($statusArray)];
            $rules['programming_language_used_mobile'] = ['required', 'numeric', 'integer', Rule::in($programmingLanguagesMobileArray)];
        }
        // Check all fileds of QA Department
        if (isset($this->quality_assurance_supervisor_id)) {
            $rules['quality_assurance_supervisor_id'] = ['numeric', 'integer', Rule::in($projectCoordinators)];
            $rules['quality_assurance_status'] = ['required', 'numeric', 'integer', Rule::in($statusArray)];
        }

        return $rules;
    }

    public function messages()
    {
        return [

            // Project Coordinator
            'project_project_coordinator_name.numeric' => 'Project Coordinator must be a number',
            'project_project_coordinator_name.integer' => 'Project Coordinator must be an integer',
            'project_project_coordinator_name.in' => 'The selected project coordinator is not valid',

            // Gather Analyze Requirements Supervisor ID
            'gather_analyze_requirements_supervisor_id.numeric' => 'Gather Analyze must be a number',
            'gather_analyze_requirements_supervisor_id.integer' => 'Gather Analyze must be an integer',
            'gather_analyze_requirements_supervisor_id.in' => 'Gather Analyze Requirements Supervisor ID is not valid',

            'gather_analyze_requirements_status.numeric' => 'Gather Analyze Requirements Status must be a number',
            'gather_analyze_requirements_status.integer' => 'Gather Analyze Requirements Status must be an integer',
            'gather_analyze_requirements_status.in' => 'Gather Analyze Requirements Status is not valid',

            // Design

            'design_department_id.numeric' => 'Design Department must be a number',
            'design_department_id.integer' => 'Design Department must be an integer',
            'design_department_id_in' => 'Design Department is not valid',

            'design_supervisor_id.required' => 'Design Supervisor is required',
            'design_supervisor_id.numeric' => 'Design Supervisor must be a number',
            'design_supervisor_id.integer' => 'Design Supervisor must be an integer',
            'design_supervisor_id.in' => 'Design Supervisor is not valid',

            'design_status.required' => 'Deisgn Status is required',
            'design_status.numeric' => 'Deisgn Status must be a number',
            'design_status.integer' => 'Deisgn Status must be an integer',
            'design_status.in' => 'Deisgn Status is not valid',


            // Web Department

            'web_department_id.numeric' => 'Web Department must be a number',
            'web_department_id.integer' => 'Web Department must be an integer',
            'web_department_id.in' => 'Web Department is not valid',

            'web_supervisor_id.required' => 'Web Supervisor is required',
            'web_supervisor_id.numeric' => 'Web Supervisor must be a number',
            'web_supervisor_id.integer' => 'Web Supervisor must be an integer',
            'web_supervisor_id.in' => 'Web Supervisor is not valid',

            'web_status.required' => 'Web Status is required',
            'web_status.numeric' => 'Web Status must be a number',
            'web_status.integer' => 'Web Status must be an integer',
            'web_status.in' => 'Web Status is not valid',

            'programming_language_used_web.required' => 'Progarmming Language Used is required',
            'programming_language_used_web.numeric' => 'Progarmming Language Used must be a number',
            'programming_language_used_web.integer' => 'Progarmming Language Used must be an integer',
            'programming_language_used_web.in' => 'Progarmming Language is not valid',

            // Mobile Department

            'mobile_department_id.numeric' => 'Mobile Department must be a number',
            'mobile_department_id.integer' => 'Mobile Department must be an integer',
            'mobile_department_id.in' => 'Mobile Department is not valid',

            'mobile_supervisor_id.required' => 'Mobile Supervisor is required',
            'mobile_supervisor_id.numeric' => 'Mobile Supervisor must be a number',
            'mobile_supervisor_id.integer' => 'Mobile Supervisor must be an integer',
            'mobile_supervisor_id.in' => 'Mobile Supervisor is not valid',

            'mobile_status.required' => 'Mobile Status must is required',
            'mobile_status.numeric' => 'Mobile Status must be a number',
            'mobile_status.integer' => 'Mobile Status must be an integer',
            'mobile_status.in' => 'Mobile Status is not valid',

            'programming_language_used_mobile.required' => 'Programming Language is required',
            'programming_language_used_mobile.numeric' => 'Programming Language must be a number',
            'programming_language_used_mobile.integer' => 'Programming Language must be an integer',
            'programming_language_used_mobile.in' => 'Programming Language is not valid',

            // Quality Assurance Supervisor
            'quality_assurance_supervisor_id.numeric' => 'Quality Assurance must be a number',
            'quality_assurance_supervisor_id.integer' => 'Quality Assurance must be an integer',
            'quality_assurance_supervisor_id.in' => 'Quality Assurance is not valid',

            'quality_assurance_status.required' => 'Quality Assurance Status is required',
            'quality_assurance_status.numeric' => 'Quality Assurance Status must be a number',
            'quality_assurance_status.integer' => 'Quality Assurance Status must be an integer',
            'quality_assurance_status.in' => 'Quality Assurance Status is not valid',

        ];
    }
}
