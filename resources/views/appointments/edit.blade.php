```blade
<x-app-layout>

    @push('styles')
    <style>
        /* =========================================================
           APPOINTMENT EDIT PAGE
           ========================================================= */

        .appointment-page {
            background: #f8f9fa;
            min-height: calc(100vh - 70px);
        }

        .appointment-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
        }

        /* Header */

        .appointment-card-header {
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 18px 24px;
        }

        .appointment-title {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #dc3545;
        }

        .appointment-title span {
            color: #198754;
        }

        .appointment-subtitle {
            font-size: 13px;
            color: #6c757d;
            margin-top: 3px;
        }

        /* Icon */

        .appointment-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(25, 135, 84, 0.10);
            color: #198754;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            margin-right: 12px;
        }

        /* Back Button */

        .back-btn {
            border-radius: 7px;
            padding: 8px 17px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            transform: translateY(-1px);
        }

        /* Form Body */

        .appointment-card-body {
            background: #ffffff;
            padding: 28px;
        }

        /* Error Alert */

        .appointment-error {
            border: none;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.08);
        }

        .appointment-error strong {
            font-size: 14px;
        }

        .appointment-error ul {
            margin-top: 8px;
            padding-left: 20px;
        }

        .appointment-error li {
            margin-bottom: 3px;
            font-size: 13px;
        }

        /* Edit indicator */

        .edit-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-left: 10px;
            padding: 4px 9px;
            border-radius: 20px;
            background: rgba(220, 53, 69, 0.08);
            color: #dc3545;
            font-size: 11px;
            font-weight: 600;
            vertical-align: middle;
        }

        /* Mobile */

        @media (max-width: 767px) {

            .appointment-page {
                padding: 10px 0;
            }

            .appointment-card-header {
                padding: 16px;
            }

            .appointment-card-body {
                padding: 18px;
            }

            .appointment-title {
                font-size: 19px;
            }

            .appointment-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            .header-actions {
                margin-top: 12px;
            }

            .back-btn {
                width: 100%;
            }

            .edit-badge {
                margin-left: 5px;
            }
        }
    </style>
    @endpush


    <main class="appointment-page">

        <div class="container py-4 px-3 px-md-4">

            {{-- =====================================================
                 ERROR MESSAGES
                 ===================================================== --}}

            @if($errors->any())

                <div class="alert alert-danger appointment-error mb-4">

                    <strong>
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Please correct the following errors:
                    </strong>

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =====================================================
                 APPOINTMENT CARD
                 ===================================================== --}}

            <div class="appointment-card">

                {{-- =================================================
                     CARD HEADER
                     ================================================= --}}

                <div class="appointment-card-header">

                    <div class="row align-items-center">

                        {{-- Title --}}

                        <div class="col-md-8">

                            <div class="d-flex align-items-center">

                                <div class="appointment-icon">
                                    <i class="fas fa-edit"></i>
                                </div>

                                <div>

                                    <h3 class="appointment-title">

                                        Edit
                                        <span>Appointment</span>

                                        <span class="edit-badge">
                                            <i class="fas fa-pen"></i>
                                            Editing
                                        </span>

                                    </h3>

                                    <div class="appointment-subtitle">
                                        Update patient and appointment information
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Back Button --}}

                        <div class="col-md-4 text-md-end header-actions">

                            <a
                                href="{{ route('admin.appointments.index') }}"
                                class="btn btn-secondary back-btn"
                            >

                                <i class="fas fa-arrow-left me-1"></i>

                                Back to Appointments

                            </a>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FORM BODY
                     ================================================= --}}

                <div class="appointment-card-body">

                    <form
                        action="{{ route('admin.appointments.update', $appointment->id) }}"
                        method="POST"
                    >

                        @csrf

                        @method('PUT')

                        @include('appointments._form', [
                            'appointment' => $appointment
                        ])

                    </form>

                </div>

            </div>

        </div>

    </main>

</x-app-layout>
```
