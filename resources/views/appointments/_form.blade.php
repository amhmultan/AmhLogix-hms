<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Patient Name</label>
    <input type="text" class="form-control" value="{{ old('patient_name', $appointment->patient_name ?? '') }}" name="patient_name" required>
    {{-- <select name="patient_id" class="form-select" required>
      <option value="">-- Select Patient --</option>
      @foreach($patients as $patient)
        <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
          {{ $patient->name }}
        </option>
      @endforeach
      >
    </select> --}}
  </div>

  <div class="col-md-6">
    <label class="form-label">Doctor</label>
    <select name="doctor_id" class="form-select" required>
      <option value="">-- Select Doctor --</option>
      @foreach($doctors as $doctor)
        <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}>
          {{ $doctor->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Date</label>
    <input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date ?? '') }}" required>
  </div>

  <div class="col-md-4">
    <label class="form-label">Time</label>
    <input type="time" name="appointment_time" class="form-control" value="{{ old('appointment_time', $appointment->appointment_time ?? '') }}" required>
  </div>

  <div class="col-md-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="pending" {{ (old('status', $appointment->status ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
      <option value="confirmed" {{ (old('status', $appointment->status ?? '') == 'confirmed') ? 'selected' : '' }}>Confirmed</option>
      <option value="canceled" {{ (old('status', $appointment->status ?? '') == 'canceled') ? 'selected' : '' }}>Canceled</option>
    </select>
  </div>

  <div class="col-12">
    <label class="form-label">Notes</label>
    <textarea name="notes" rows="3" class="form-control">{{ old('notes', $appointment->notes ?? '') }}</textarea>
  </div>

  <div class="col-12 text-end">
    <button type="submit" class="btn btn-success mt-3">Save Appointment</button>
  </div>
</div>
