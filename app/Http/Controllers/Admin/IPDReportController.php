<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class IPDReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('admissions')
            ->leftJoin('patients', 'admissions.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'admissions.doctor_id', '=', 'doctors.id')
            ->leftJoin('beds', 'admissions.bed_id', '=', 'beds.id')
            ->leftJoin('specialities', 'doctors.speciality_id', '=', 'specialities.id')
            ->leftJoin('wards', 'beds.ward_id', '=', 'wards.id')
            ->select(
                'admissions.id as admission_id',
                'admissions.patient_id as mr_number',
                'admissions.admission_date',
                'admissions.discharge_date',
                'beds.bed_number as bed_name',
                'doctors.name as doctor_name',
                'specialities.title as speciality',
                'patients.reffered_by as panel_name',
                'patients.name as patient_name',
                'wards.name as ward_name'
            );

        // Filters
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('admissions.admission_date', [$request->from_date, $request->to_date]);
        }

        if ($request->doctor_id) {
            $query->where('admissions.doctor_id', $request->doctor_id);
        }

        if ($request->panel_name) {
            $query->where('patients.reffered_by', $request->panel_name);
        }

        if ($request->bed_id) {
            $query->where('admissions.bed_id', $request->bed_id);
        }

        if ($request->status) {
            if ($request->status == 'Admitted') {
                $query->whereNull('admissions.discharge_date');
            } elseif ($request->status == 'Discharged') {
                $query->whereNotNull('admissions.discharge_date');
            }
        }

        $admissions = $query->get();

        $doctors = DB::table('doctors')
            ->leftJoin('specialities', 'doctors.speciality_id', '=', 'specialities.id')
            ->select('doctors.id', 'doctors.name', 'specialities.title as speciality_title')
            ->get();

        $beds = DB::table('beds')
            ->leftJoin('wards', 'beds.ward_id', '=', 'wards.id')
            ->select('beds.id', 'beds.bed_number', 'wards.name as ward_name')
            ->get();

        // PDF download
        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('ipd.ipd_reports.pdf', compact('admissions'));
            return $pdf->stream('ipd_reports.pdf');
        }

        return view('ipd.ipd_reports.index', compact('admissions', 'doctors', 'beds'));
    }
}
