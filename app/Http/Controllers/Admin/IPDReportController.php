<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admission;
use App\Models\Doctor;
use App\Models\Bed;
use App\Models\Hospital;


class IPDReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with([
            'patient',
            'doctor.speciality',
            'bed.ward',
            'charges'
        ]);

        // Filters
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('admission_date', [
                $request->from_date . " 00:00:00",
                $request->to_date . " 23:59:59"
            ]);
        }

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->panel_name) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('reffered_by', $request->panel_name);
            });
        }

        if ($request->bed_id) {
            $query->where('bed_id', $request->bed_id);
        }

        if ($request->status) {

            if ($request->status == 'Admitted') {
                $query->whereNull('discharge_date');
            }

            elseif ($request->status == 'Discharged') {
                $query->whereNotNull('discharge_date');
            }
        }

        $admissions = $query->latest()->get();

        $doctors = Doctor::with('speciality')->get();

        $beds = Bed::with('ward')->get();

        $hospital = Hospital::first();

        // PDF
        if ($request->has('pdf')) {

            $pdf = Pdf::loadView(
                'ipd.ipd_reports.pdf',
                compact(
                    'admissions',
                    'hospital',
                    'doctors',
                    'beds'
                )
            )->setPaper('a4', 'landscape');

            return $pdf->stream('ipd_reports.pdf');
        }

        return view(
            'ipd.ipd_reports.index',
            compact(
                'admissions',
                'doctors',
                'beds'
            )
        );
    }
}
