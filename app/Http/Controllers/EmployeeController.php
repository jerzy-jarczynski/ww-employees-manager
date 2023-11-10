<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $sortBy = $request->input('sort_by', 'first_name');
        $sortOrder = $request->input('sort_order', 'asc');
    
        if ($request->input('sort_order') && $request->input('last_sort_by') == $sortBy) {
            $sortOrder = $request->input('sort_order') == 'asc' ? 'desc' : 'asc';
        }
    
        $employees = Employee::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('first_name', 'like', "%{$searchTerm}%")
                             ->orWhere('last_name', 'like', "%{$searchTerm}%")
                             ->orWhere('email', 'like', "%{$searchTerm}%")
                             ->orWhere('company', 'like', "%{$searchTerm}%");
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);
    
        return view('employees.index', [
            'employees' => $employees,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'lastSortBy' => $request->input('last_sort_by'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        \Log::info('Before Validation: ', $request->all());
    
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'company' => 'required|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_numbers' => 'required|string',
            'dietary_preferences' => 'required|max:255',
        ]);
    
        \Log::info('After Validation: ', $validatedData);
    
        $employee = Employee::findOrFail($id);
        $employee->update($validatedData);
    
        \Log::info('After Update: ', $employee->toArray());
    
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
