{{-- =========================================================
     APPOINTMENT FORM
     ========================================================= --}}

@push('styles')
<style>
  /* =========================================================
       APPOINTMENT FORM
       ========================================================= */

  .appointment-form-section {
    margin-bottom: 28px;
    margin-top: 30px;
  }

  .appointment-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
  }

  .appointment-section-icon {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
    font-size: 14px;
  }

  .appointment-section-title h5 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #343a40;
  }

  .appointment-section-title small {
    display: block;
    color: #6c757d;
    font-size: 12px;
    font-weight: 400;
    margin-top: 2px;
  }

  /* Form groups */

  .appointment-field {
    margin-bottom: 4px;
  }

  .appointment-field .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 7px;
  }

  .appointment-field .form-label .required {
    color: #dc3545;
    margin-left: 2px;
  }

  .appointment-field .form-control,
  .appointment-field .form-select {
    min-height: 43px;
    border: 1px solid #dee2e6;
    border-radius: 7px;
    padding: 9px 12px;
    font-size: 14px;
    color: #343a40;
    background-color: #fff;
    transition: all 0.2s ease;
  }

  .appointment-field textarea.form-control {
    min-height: 100px;
    resize: vertical;
  }

  .appointment-field .form-control:focus,
  .appointment-field .form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.18rem rgba(25, 135, 84, 0.12);
  }

  .appointment-field .form-control::placeholder {
    color: #adb5bd;
    font-size: 13px;
  }

  /* Input with icon */

  .appointment-input-group {
    position: relative;
  }

  .appointment-input-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #8a9299;
    font-size: 14px;
    pointer-events: none;
    z-index: 2;
  }

  .appointment-input-group .form-control,
  .appointment-input-group .form-select {
    padding-left: 38px;
  }

  /* Select */

  .appointment-field select {
    cursor: pointer;
  }

  /* Status */

  .status-help {
    font-size: 11px;
    color: #6c757d;
    margin-top: 5px;
  }

  /* Notes */

  .notes-wrapper {
    position: relative;
  }

  .notes-icon {
    position: absolute;
    left: 13px;
    top: 14px;
    color: #8a9299;
    font-size: 14px;
    pointer-events: none;
  }

  .notes-wrapper textarea {
    padding-left: 38px !important;
  }

  /* Footer */

  .appointment-form-footer {
    margin-top: 10px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .appointment-save-btn {
    min-width: 165px;
    padding: 10px 20px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .appointment-save-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(25, 135, 84, 0.20);
  }

  .appointment-cancel-btn {
    padding: 10px 20px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 500;
  }

  /* Validation */

  .appointment-field .is-invalid {
    border-color: #dc3545;
  }

  .appointment-field .invalid-feedback {
    font-size: 11px;
    margin-top: 5px;
  }

  /* Mobile */

  @media (max-width: 767px) {

    .appointment-section-title {
      margin-bottom: 15px;
    }

    .appointment-field {
      margin-bottom: 12px;
    }

    .appointment-form-footer {
      flex-direction: column-reverse;
    }

    .appointment-save-btn,
    .appointment-cancel-btn {
      width: 100%;
    }
  }
</style>
@endpush


{{-- =========================================================
     PATIENT INFORMATION
     ========================================================= --}}

<div class="appointment-form-section">

  <div class="appointment-section-title">

    <div class="appointment-section-icon">
      <i class="fas fa-user"></i>
    </div>

    <div>
      <h5>Patient Information</h5>
      <small>Enter the patient's basic contact information</small>
    </div>

  </div>


  <div class="row g-3">

    {{-- Patient Name --}}
    <div class="col-md-6">

      <div class="appointment-field">

        <label class="form-label">
          Patient Name
          <span class="required">*</span>
        </label>

        <div class="appointment-input-group">

          <i class="fas fa-user appointment-input-icon"></i>

          <input
            type="text"
            name="patient_name"
            class="form-control"
            value="{{ old('patient_name', $appointment->patient_name ?? '') }}"
            placeholder="Enter patient name"
            required>

        </div>

      </div>

    </div>


    {{-- Phone Number --}}
    <div class="col-md-6">

      <div class="appointment-field">

        <label class="form-label">
          Phone Number
          <span class="required">*</span>
        </label>

        <div class="appointment-input-group">

          <i class="fas fa-phone appointment-input-icon"></i>

          <input
            type="text"
            name="phone_number"
            class="form-control"
            value="{{ old('phone_number', $appointment->phone_number ?? '') }}"
            placeholder="e.g. 03001234567"
            required>

        </div>

      </div>

    </div>

  </div>

</div>


{{-- =========================================================
     APPOINTMENT DETAILS
     ========================================================= --}}

<div class="appointment-form-section">

  <div class="appointment-section-title">

    <div class="appointment-section-icon">
      <i class="fas fa-calendar-check"></i>
    </div>

    <div>
      <h5>Appointment Details</h5>
      <small>Select doctor, date, time and appointment status</small>
    </div>

  </div>


  <div class="row g-3">

    {{-- Doctor --}}
    <div class="col-md-3">

      <div class="appointment-field">

        <label class="form-label">
          Doctor
          <span class="required">*</span>
        </label>

        <div class="appointment-input-group">

          <i class="fas fa-user-md appointment-input-icon"></i>

          <select
            name="doctor_id"
            class="form-select"
            required>

            <option value="">-- Select Doctor --</option>

            @foreach($doctors as $doctor)

            <option
              value="{{ $doctor->id }}"
              {{ old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}>
              {{ $doctor->name }}
            </option>

            @endforeach

          </select>

        </div>

      </div>

    </div>


    {{-- Date --}}
    <div class="col-md-3">

      <div class="appointment-field">

        <label class="form-label">
          Appointment Date
          <span class="required">*</span>
        </label>

        <div class="appointment-input-group">

          <i class="fas fa-calendar-alt appointment-input-icon"></i>

          <input
            type="date"
            name="appointment_date"
            class="form-control"
            value="{{ old('appointment_date', $appointment->appointment_date ?? '') }}"
            required>

        </div>

      </div>

    </div>


    {{-- Time --}}
    <div class="col-md-3">

      <div class="appointment-field">

        <label class="form-label">
          Appointment Time
          <span class="required">*</span>
        </label>

        <div class="appointment-input-group">

          <i class="fas fa-clock appointment-input-icon"></i>

          <input
            type="text"
            name="appointment_time"
            class="form-control"
            value="{{ old('appointment_time', $appointment->appointment_time ?? '') }}"
            placeholder="e.g. 10:30 AM"
            required>

        </div>

      </div>

    </div>


    {{-- Status --}}
    <div class="col-md-3">

      <div class="appointment-field">

        <label class="form-label">
          Status
        </label>

        <div class="appointment-input-group">

          <i class="fas fa-info-circle appointment-input-icon"></i>

          <select
            name="status"
            class="form-select">

            <option
              value="pending"
              {{ old('status', $appointment->status ?? 'pending') == 'pending' ? 'selected' : '' }}>
              Pending
            </option>

            <option
              value="confirmed"
              {{ old('status', $appointment->status ?? '') == 'confirmed' ? 'selected' : '' }}>
              Confirmed
            </option>

            <option
              value="canceled"
              {{ old('status', $appointment->status ?? '') == 'canceled' ? 'selected' : '' }}>
              Canceled
            </option>

          </select>

        </div>

        <div class="status-help">
          <i class="fas fa-info-circle me-1"></i>
          You can change the appointment status later.
        </div>

      </div>

    </div>

  </div>

</div>


{{-- =========================================================
     NOTES
     ========================================================= --}}

<div class="appointment-form-section">

  <div class="appointment-section-title">

    <div class="appointment-section-icon">
      <i class="fas fa-comment-medical"></i>
    </div>

    <div>
      <h5>Additional Information</h5>
      <small>Add any message or notes related to this appointment</small>
    </div>

  </div>


  <div class="row">

    <div class="col-12">

      <div class="appointment-field">

        <label class="form-label">
          Message / Notes
        </label>

        <div class="notes-wrapper">

          <i class="fas fa-comment-alt notes-icon"></i>

          <textarea
            name="notes"
            rows="4"
            class="form-control"
            placeholder="Enter any additional information, symptoms or instructions...">{{ old('notes', $appointment->notes ?? '') }}</textarea>

        </div>

      </div>

    </div>

  </div>

</div>


{{-- =========================================================
     HIDDEN SOURCE
     ========================================================= --}}

<input type="hidden" name="source" value="admin">


{{-- =========================================================
     FORM ACTIONS
     ========================================================= --}}

<div class="appointment-form-footer">

  <a
    href="{{ route('admin.appointments.index') }}"
    class="btn btn-light border appointment-cancel-btn">
    <i class="fas fa-times me-1"></i>
    Cancel
  </a>

  <button
    type="submit"
    class="btn btn-success appointment-save-btn">
    <i class="fas fa-calendar-check me-1"></i>
    Save Appointment
  </button>

</div>