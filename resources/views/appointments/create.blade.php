<x-app-layout>

    @push('styles')
    <style>
        /* ==============================
           APPOINTMENT CREATE PAGE
           ============================== */

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

        /* Back button */
        .back-btn {
            border-radius: 7px;
            padding: 8px 17px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            transform: translateY(-1px);
        }

        /* Form body */
        .appointment-card-body {
            background: #ffffff;
            padding: 28px;
        }

        /* Error alert */
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
        }
    </style>
    @endpush


    <main class="appointment-page">

        <div class="container py-4 px-3 px-md-4">

            {{-- ==============================
                 ERROR MESSAGES
                 ============================== --}}
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


            {{-- ==============================
                 APPOINTMENT CARD
                 ============================== --}}
            <div class="appointment-card">

                {{-- Card Header --}}
                <div class="appointment-card-header">

                    <div class="row align-items-center">

                        {{-- Title --}}
                        <div class="col-md-8">

                            <div class="d-flex align-items-center">

                                <div class="appointment-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>

                                <div>
                                    <h3 class="appointment-title">
                                        Add <span>Appointment</span>
                                    </h3>

                                    <div class="appointment-subtitle">
                                        Create a new patient appointment
                                    </div>
                                </div>

                            </div>

                        </div>


                        {{-- Back Button --}}
                        <div class="col-md-4 text-md-end header-actions">

                            <a href="{{ route('admin.appointments.index') }}"
                               class="btn btn-secondary back-btn">

                                <i class="fas fa-arrow-left me-1"></i>
                                Back to Appointments

                            </a>

                        </div>

                    </div>

                </div>


                {{-- ==============================
                     FORM BODY
                     ============================== --}}
                <div class="appointment-card-body">

                    <form action="{{ route('admin.appointments.store') }}"
                          method="POST">

                        @csrf

                        @include('appointments._form', [
                            'appointment' => null
                        ])

                    </form>

                </div>

            </div>

        </div>

    </main>

</x-app-layout>