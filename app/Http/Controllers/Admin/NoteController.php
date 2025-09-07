<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyNote;
use App\Models\Admission;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:IPD_Notes access|IPD_Notes create|IPD_Notes edit|DoctorNotes delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:IPD_Notes create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:IPD_Notes edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:IPD_Notes delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $dailyNotes = DailyNote::with('admission.patient', 'admission.bed.ward')->latest()->get();
        $admissions = Admission::with('patient')->where('status', 'admitted')->get();
        return view('daily-notes.index', compact('dailyNotes','admissions'));
    }

    public function create(Admission $admission)
    {
        $admission->load(['patient', 'doctor', 'bed.ward']);
        return view('daily-notes.create', compact('admission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'notes' => 'nullable|string|max:2000',
            'vitals' => 'nullable|array',
        ]);

        DailyNote::create([
            'admission_id' => $request->admission_id,
            'user_id' => auth()->id(),
            'notes' => $request->notes,
            'vitals' => $request->vitals,
        ]);

        return redirect()->route('admin.daily-notes.index')
            ->with('success', 'Daily note added.');
    }

    public function edit(DailyNote $dailyNote)
    {
        $dailyNote->load(['admission.patient', 'admission.bed.ward']);
        return view('daily-notes.edit', compact('dailyNote'));
    }

    public function update(Request $request, DailyNote $dailyNote)
    {
        $request->validate([
            'notes' => 'nullable|string|max:2000',
            'vitals' => 'nullable|array',
        ]);

        $dailyNote->update([
            'notes' => $request->notes,
            'vitals' => $request->vitals,
        ]);

        return redirect()->route('admin.daily-notes.index')
            ->with('success', 'Daily note updated.');
    }

    public function destroy(DailyNote $dailyNote)
    {
        $dailyNote->delete();
        return redirect()->route('admin.daily-notes.index')
            ->with('success', 'Daily note deleted.');
    }
}
