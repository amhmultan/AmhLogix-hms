<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\Doctor;
use App\Models\Speciality;
use Yajra\DataTables\DataTables;

class TokenReportController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        $departments = Speciality::all();

        // Your blade file is in: resources/views/tokens/report.blade.php
        return view('token.token_report', compact('doctors', 'departments'));
    }

    public function data(Request $request)
    {
        // Base query with relationships
        $query = Token::with(['patient', 'doctors', 'specialties']);

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->doctor_id) {
            $query->where('fk_doctors_id', $request->doctor_id);
        }
        if ($request->department_id) {
            $query->where('fk_specialty_id', $request->department_id);
        }

        // Get totals before pagination
        $totalAmount = (clone $query)->sum('denomination');
        $totalTokens = (clone $query)->count();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($row) {
                return $row->patient?->name ?? '-';
            })
            ->addColumn('patient_mr_no', function ($row) {
                return $row->patient?->id ?? '-';
            })
            ->addColumn('doctor_name', function ($row) {
                return $row->doctors?->name ?? '-';
            })
            ->addColumn('speciality_name', function ($row) {
                return $row->specialties?->title ?? '-';
            })
            ->addColumn('amount_formatted', function ($row) {
                return number_format($row->denomination ?? 0, 2);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->with([
                'totalAmount' => number_format($totalAmount, 2),
                'totalTokens' => $totalTokens,
            ])
            ->make(true);
    }
    
}
