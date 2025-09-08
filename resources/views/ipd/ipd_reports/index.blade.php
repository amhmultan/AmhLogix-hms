<x-app-layout>
<main class="py-6">
<div class="container-fluid px-5">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h3 class="text-danger"><strong>IPD <span class="text-success">Report</span></strong></h3>
        </div>
        <div class="col-sm-6 text-end">
            <a href="{{ route('admin.ipd.index') }}" class="btn btn-secondary mb-1">Back to IPD Dashboard</a>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.ipd.ipd_reports.index') }}">
        <div class="row mb-4">
            <div class="col-md-2">
                <span class="font-weight-bold">From Date:</span>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <span class="font-weight-bold">To Date:</span>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2">
                <span class="font-weight-bold">Doctor / Speciality:</span>
                <select name="doctor_id" class="form-control">
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id')==$doctor->id?'selected':'' }}>{{ $doctor->name }} ({{ $doctor->speciality_title }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <span class="font-weight-bold">Panel:</span>
                <select name="panel_name" class="form-control">
                    <option value="">Select Panel</option>
                    @foreach(DB::table('patients')->distinct()->pluck('reffered_by') as $panel)
                        <option value="{{ $panel }}" {{ request('panel_name')==$panel?'selected':'' }}>{{ $panel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <span class="font-weight-bold">Ward / Bed:</span>
                <select name="bed_id" class="form-control">
                    <option value="">Select Bed</option>
                    @foreach($beds as $bed)
                        <option value="{{ $bed->id }}" {{ request('bed_id')==$bed->id?'selected':'' }}>{{ $bed->ward_name }} / {{ $bed->bed_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <span class="font-weight-bold">Status:</span>
                <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Admitted" {{ request('status')=='Admitted'?'selected':'' }}>Admitted</option>
                    <option value="Discharged" {{ request('status')=='Discharged'?'selected':'' }}>Discharged</option>
                </select>
            </div>
            <div class="col-md-2 my-4 mx-1">
                <button type="submit" class="btn btn-warning">Filter</button>
                <button type="submit" name="pdf" value="1" class="btn btn-danger">Download PDF</button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered text-center" id="ipd_report_table" style="width:100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-uppercase">Sr. No.</th>
                    <th class="text-uppercase">MR Number</th>
                    <th class="text-uppercase">Patient Name</th>
                    <th class="text-uppercase">Panel</th>
                    <th class="text-uppercase">Admission ID</th>
                    <th class="text-uppercase">Admission Date & Time</th>
                    <th class="text-uppercase">Discharge Date & Time</th>
                    <th class="text-uppercase">Doctor Name / Speciality</th>
                    <th class="text-uppercase">Ward / Bed</th>
                    <th class="text-uppercase">IPD Total Bill</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($admissions as $key => $admission)
                <tr class="border border-dark hover:bg-gray-50 odd:bg-white even:bg-gray-50">
                    <td>{{ $key+1 }}</td>
                    <td>{{ $admission->mr_number }}</td>
                    <td>{{ $admission->patient_name }}</td>
                    <td>{{ $admission->panel_name }}</td>
                    <td>{{ $admission->admission_id }}</td>
                    <td>{{ $admission->admission_date }}</td>
                    <td>{{ $admission->discharge_date }}</td>
                    <td>{{ $admission->doctor_name }} / {{ $admission->speciality }}</td>
                    <td>{{ $admission->ward_name }} / {{ $admission->bed_name }} </td>
                    <td> 0 </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</main>
</x-app-layout>