<x-app-layout>

  @push('styles')
  <style>
    /* =========================================================
           APPOINTMENTS TABLE
        ========================================================= */

    .appointment-table-wrapper {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
      border: 1px solid #e5e7eb;
      overflow: hidden;
    }

    .appointment-table-container {
      overflow-x: auto;
    }

    #appointmentTable {
      width: 100% !important;
      margin: 0 !important;
      border-collapse: separate;
      border-spacing: 0;
    }

    /* Table Header */
    #appointmentTable thead th {
      background: linear-gradient(135deg, #4f46e5, #6366f1);
      color: #ffffff;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      padding: 15px 14px;
      border: none !important;
      white-space: nowrap;
      vertical-align: middle;
      text-align: center;
    }

    #appointmentTable thead th:first-child {
      border-top-left-radius: 0;
    }

    #appointmentTable thead th:last-child {
      border-top-right-radius: 0;
    }

    /* Table Body */
    #appointmentTable tbody td {
      padding: 13px 14px;
      font-size: 13px;
      color: #374151;
      border-bottom: 1px solid #eef0f3 !important;
      border-left: none !important;
      border-right: none !important;
      vertical-align: middle;
      white-space: nowrap;
    }

    #appointmentTable tbody tr {
      background-color: #ffffff;
      transition: all 0.2s ease;
    }

    /* Reliable hover effect */
    #appointmentTable tbody tr:hover {
      background-color: #f5f7ff !important;
      box-shadow: inset 4px 0 0 #6366f1;
    }

    #appointmentTable tbody tr:hover td {
      color: #1f2937;
    }

    #appointmentTable tbody tr:last-child td {
      border-bottom: none !important;
    }

    /* Patient name */
    .patient-name {
      font-weight: 700;
      color: #111827;
    }

    /* Doctor */
    .doctor-name {
      font-weight: 600;
      color: #4338ca;
    }

    /* Phone */
    .phone-number {
      color: #374151;
      font-weight: 500;
    }

    /* Date */
    .appointment-date {
      font-weight: 600;
      color: #374151;
    }

    /* Time */
    .appointment-time {
      display: inline-block;
      background: #f3f4f6;
      color: #374151;
      padding: 5px 9px;
      border-radius: 7px;
      font-weight: 600;
      font-size: 12px;
    }

    /* Notes */
    .appointment-notes {
      max-width: 180px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      display: inline-block;
      vertical-align: middle;
      color: #6b7280;
    }

    /* =========================================================
           STATUS BADGES
           ========================================================= */

    .status-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 85px;
      padding: 5px 11px;
      border-radius: 50px;
      font-size: 11px;
      font-weight: 700;
      text-transform: capitalize;
    }

    .status-pending {
      background: #ffe5ab;
      color: #1d4ed8;
    }

    .status-confirmed {
      background: #ecfdf5;
      color: #047857;
    }

    .status-completed {
      background: #eff6ff;
      color: #1d4ed8;
    }

    .status-cancelled,
    .status-canceled {
      background: #fef2f2;
      color: #dc2626;
    }

    .status-default {
      background: #f3f4f6;
      color: #4b5563;
    }

    /* =========================================================
           ACTION BUTTONS
           ========================================================= */

    .appointment-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 58px;
      padding: 6px 10px;
      border-radius: 7px;
      font-size: 11px;
      font-weight: 700;
      text-decoration: none;
      border: none;
      transition: all 0.2s ease;
    }

    .appointment-edit {
      background: #fff7ed;
      color: #c2410c;
    }

    .appointment-edit:hover {
      background: #04a54d;
      color: #ffffff;
      transform: translateY(-1px);
    }

    .appointment-delete {
      background: #fef2f2;
      color: #dc2626;
    }

    .appointment-delete:hover {
      background: #dc2626;
      color: #ffffff;
      transform: translateY(-1px);
    }

    .appointment-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    /* =========================================================
           PAGE HEADER
           ========================================================= */

    .appointment-page-title {
      font-size: 27px;
      font-weight: 800;
      color: #dc2626;
      margin-bottom: 0;
    }

    .appointment-page-title span {
      color: #059669;
    }

    .appointment-add-btn {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: #111827;
      color: #ffffff !important;
      padding: 10px 20px;
      border-radius: 9px;
      font-size: 14px;
      font-weight: 700;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(17, 24, 39, 0.15);
      transition: all 0.2s ease;
    }

    .appointment-add-btn:hover {
      background: #4f46e5;
      transform: translateY(-1px);
      box-shadow: 0 6px 14px rgba(79, 70, 229, 0.25);
    }

    /* =========================================================
           EMPTY STATE
           ========================================================= */

    .appointment-empty {
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      padding: 60px 20px;
      text-align: center;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .appointment-empty-icon {
      width: 65px;
      height: 65px;
      margin: 0 auto 15px;
      border-radius: 50%;
      background: #fef2f2;
      color: #dc2626;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 27px;
    }

    .appointment-empty h4 {
      color: #dc2626;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .appointment-empty p {
      color: #6b7280;
      margin: 0;
      font-size: 13px;
    }

    /* =========================================================
           DATATABLES
           ========================================================= */

    .dataTables_wrapper {
      padding: 18px;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
      margin-bottom: 18px;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
      font-size: 13px;
      font-weight: 600;
      color: #4b5563;
    }

    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #d1d5db;
      border-radius: 8px;
      padding: 8px 12px;
      margin-left: 7px;
      outline: none;
      transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .dataTables_wrapper .dataTables_length select {
      border: 1px solid #d1d5db;
      border-radius: 7px;
      padding: 6px 28px 6px 9px;
      outline: none;
      margin: 0 5px;
    }

    .dataTables_wrapper .dataTables_info {
      font-size: 12px;
      color: #6b7280;
      padding-top: 15px;
    }

    .dataTables_wrapper .dataTables_paginate {
      padding-top: 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      border: none !important;
      border-radius: 7px !important;
      margin: 0 2px;
      padding: 6px 11px !important;
      font-size: 12px;
      color: #4b5563 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: #eef2ff !important;
      color: #4338ca !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background: #4f46e5 !important;
      color: #ffffff !important;
      border: none !important;
    }

    /* Mobile */
    @media (max-width: 768px) {
      .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
      }

      .appointment-page-title {
        font-size: 22px;
      }

      .appointment-header {
        gap: 15px;
      }

      .appointment-add-btn {
        padding: 8px 14px;
        font-size: 12px;
      }

      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_filter {
        text-align: left !important;
        float: none !important;
      }

      .dataTables_wrapper .dataTables_filter {
        margin-top: 10px;
      }
    }
  </style>
  @endpush


  <main>
    <div class="container-fluid py-4 px-5">

      {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}
      <div class="row align-items-center mb-4 appointment-header">

        <div class="col-md-6">
          <h1 class="appointment-page-title">
            Appointment <span>Records</span>
          </h1>
        </div>

        <div class="col-md-6 text-md-end mt-3 mt-md-0">

          @can('Appointment create')
          <a href="{{ route('admin.appointments.create') }}"
            class="appointment-add-btn"
            accesskey="a">

            <!-- <span>＋</span> -->
            <i class="fa-solid fa-calendar-plus"></i>
            <span><u>A</u>dd Appointment</span>

          </a>
          @endcan

        </div>

      </div>


      {{-- =====================================================
                 APPOINTMENTS TABLE
                 ===================================================== --}}
      @if($appointments->isNotEmpty())

      <div class="appointment-table-wrapper">

        <div class="appointment-table-container">

          <table id="appointmentTable">

            <thead>
              <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Phone Number</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody>

              @foreach($appointments as $appointment)

              <tr>

                {{-- ID --}}
                <td>
                  <strong>{{ $appointment->id }}</strong>
                </td>


                {{-- Patient --}}
                <td>
                  <span class="patient-name">
                    {{ $appointment->patient_name ?? 'N/A' }}
                  </span>
                </td>


                {{-- Phone --}}
                <td>
                  <span class="phone-number">
                    {{ $appointment->phone_number ?? 'N/A' }}
                  </span>
                </td>


                {{-- Doctor --}}
                <td>
                  <span class="doctor-name">
                    {{ $appointment->doctor->name ?? 'N/A' }}
                  </span>
                </td>


                {{-- Date --}}
                <td>
                  <span class="appointment-date">
                    {{ $appointment->appointment_date ?? 'N/A' }}
                  </span>
                </td>


                {{-- Time --}}
                <td>
                  <span class="appointment-time">
                    {{ $appointment->appointment_time ?? 'N/A' }}
                  </span>
                </td>


                {{-- Status --}}
                <td>

                  @php
                  $status = strtolower($appointment->status ?? 'unknown');

                  $statusClass = match($status) {
                  'pending' => 'status-pending',
                  'confirmed' => 'status-confirmed',
                  'completed' => 'status-completed',
                  'cancelled',
                  'canceled' => 'status-cancelled',
                  default => 'status-default',
                  };
                  @endphp

                  <span class="status-badge {{ $statusClass }}">
                    {{ ucfirst($status) }}
                  </span>

                </td>


                {{-- Notes --}}
                <td>

                  @if($appointment->notes)

                  <span class="appointment-notes"
                    title="{{ $appointment->notes }}">
                    {{ $appointment->notes }}
                  </span>

                  @else

                  <span class="text-muted">—</span>

                  @endif

                </td>


                {{-- Created At --}}
                <td>
                  <span class="text-muted">
                    {{ \Carbon\Carbon::parse($appointment->created_at)->format('d M Y, h:i A') }}
                  </span>
                </td>


                {{-- Updated At --}}
                <td>
                  <span class="text-muted">
                    {{ \Carbon\Carbon::parse($appointment->updated_at)->format('d M Y, h:i A') }}
                  </span>
                </td>


                {{-- Actions --}}
                <td>

                  <div class="appointment-actions">

                    @can('Appointment edit')

                    <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                      class="appointment-action appointment-edit"
                      title="Edit Appointment">
                      <i class="fas fa-edit px-1"></i>
                      Edit
                    </a>

                    @endcan


                    @can('Appointment delete')

                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this appointment?');">

                      @csrf
                      @method('DELETE')

                      <button type="submit"
                        class="appointment-action appointment-delete"
                        title="Delete Appointment">
                        <i class="fas fa-trash px-1"></i>
                        Delete
                      </button>

                    </form>

                    @endcan

                  </div>

                </td>

              </tr>

              @endforeach

            </tbody>

          </table>

        </div>

      </div>

      @else

      {{-- =================================================
                     EMPTY STATE
                     ================================================= --}}
      <div class="appointment-empty">

        <div class="appointment-empty-icon">
          📅
        </div>

        <h4>NO RECORD FOUND</h4>

        <p>
          There are currently no appointment records available.
        </p>

      </div>

      @endif

    </div>
  </main>


  {{-- =========================================================
     DATATABLES
     ========================================================= --}}
  @push('scripts')

  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {

      console.log(
        'Appointment rows rendered:',
        $('#appointmentTable tbody tr').length
      );

      if ($.fn.DataTable.isDataTable('#appointmentTable')) {
        $('#appointmentTable').DataTable().destroy();
      }

      $('#appointmentTable').DataTable({
        order: [
          [0, 'desc']
        ],

        pageLength: 10,

        lengthMenu: [
          [10, 25, 50, 100],
          [10, 25, 50, 100]
        ],

        paging: true,
        searching: true,
        info: true,

        language: {
          search: "Search:",
          lengthMenu: "Show _MENU_ records",
          info: "Showing _START_ to _END_ of _TOTAL_ appointments",
          infoEmpty: "No appointments available",
          zeroRecords: "No matching appointments found",

          paginate: {
            previous: "Previous",
            next: "Next"
          }
        }
      });

    });
  </script>

  @endpush

</x-app-layout>