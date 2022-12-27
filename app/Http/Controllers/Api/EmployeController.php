<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeController extends Controller
{

    //list data employee
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $age = $request->input('age');
        $phone = $request->input('phone');
        $team_id = $request->input('team_id');
        $role_id = $request->input('role_id');
        $company_id = $request->input('company_id');
        $limit = $request->input('limit', 10);

        $employeeQuery = Employee::query();

        // Get single data
        if ($id) {
            $employee = $employeeQuery->with(['team', 'role'])->find($id);

            if ($employee) {
                return ResponseFormatter::success($employee, 'Employee found');
            }

            return ResponseFormatter::error('Employee not found', 404);
        }

        // Get multiple data
        $employees = $employeeQuery;

        if ($name) {
            $employees->where('name', 'like', '%' . $name . '%');
        }

        if ($email) {
            $employees->where('email', $email);
        }

        if ($age) {
            $employees->where('age', $age);
        }

        if ($phone) {
            $employees->where('phone', 'like', '%' . $phone . '%');
        }

        if ($role_id) {
            $employees->where('role_id', $role_id);
        }

        if ($team_id) {
            $employees->where('team_id', $team_id);
        }

        return ResponseFormatter::success(
            $employees->paginate($limit),
            'Employees found'
        );
    }

    //menambahkan data employee
    public function create(CreateEmployeeRequest $request)
    {

        try {
            if ($request->file('photo')) {
                $path = $request->file('photo')->store('public/photos');
            }
            $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'age' => $request->age,
                'phone' => $request->phone,
                'photo' => $path,
                'team_id' => $request->team_id,
                'role_id' => $request->role_id,

            ]);

            if (!$employee) {
                throw new Exception('Employee Not Created');
            }

            return ResponseFormatter::success($employee, 'employee created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    //update data employee
    public function update(UpdateEmployeeRequest $request, $id)
    {

        try {
            // Get employee
            $employee = Employee::find($id);

            // Check if employee exists
            if (!$employee) {
                throw new Exception('Employee not found');
            }

            // Upload photo
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/photos');
            }

            // Update employee
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'age' => $request->age,
                'phone' => $request->phone,
                'photo' => isset($path) ? $path : $employee->photo,
                'team_id' => $request->team_id,
                'role_id' => $request->role_id,
            ]);

            return ResponseFormatter::success($employee, 'Employee updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    //delet data byID employee
    public function destroy($id)
    {
        try {
            //get employee
            $employee = Employee::find($id);

            // check if item exits
            if (!$employee) {
                throw new Exception('Employee Not Found');
            }

            //delete employee
            $employee->delete();

            return ResponseFormatter::success('Employee deleated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
