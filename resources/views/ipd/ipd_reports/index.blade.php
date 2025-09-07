<x-app-layout>
<main class="py-6">
<div class="container">
    <h2>IPD Report</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.ipd.ipd_reports.index') }}">
        <div class="row mb-2">
            <div class="col-md-2">
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2">
                <select name="doctor_id" class="form-control">
                    <option value="">Select Doctor</option>
                    @foreach(DB::table('doctors')->get() as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id')==$doctor->id?'selected':'' }}>{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="panel_name" class="form-control">
                    <option value="">Select Panel</option>
                    @foreach(DB::table('patients')->distinct()->pluck('reffered_by') as $panel)
                        <option value="{{ $panel }}" {{ request('panel_name')==$panel?'selected':'' }}>{{ $panel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="bed_id" class="form-control">
                    <option value="">Select Bed</option>
                    @foreach(DB::table('beds')->get() as $bed)
                        <option value="{{ $bed->id }}" {{ request('bed_id')==$bed->id?'selected':'' }}>{{ $bed->bed_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Admitted" {{ request('status')=='Admitted'?'selected':'' }}>Admitted</option>
                    <option value="Discharged" {{ request('status')=='Discharged'?'selected':'' }}>Discharged</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <button type="submit" name="pdf" value="1" class="btn btn-danger">Download PDF</button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>MR Number</th>
                <th>Admission ID</th>
                <th>Bed</th>
                <th>Discharge Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admissions as $key => $admission)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $admission->mr_number }}</td>
                <td>{{ $admission->admission_id }}</td>
                <td>{{ $admission->bed_name }}</td>
                <td>{{ $admission->discharge_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</main>
</x-apop-layout>