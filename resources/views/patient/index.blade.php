<x-app-layout>
    @push('styles')
    <style>
        /* ========================= GLOBAL OVERFLOW FIX ========================= */
        html,
        body {
            overflow-x: hidden !important;
        }

        /* ========================= CONTAINER FIX ========================= */
        .container-fluid {
            max-width: 99%;
            overflow-x: hidden;
        }

        /* ========================= STICKY SEARCH ========================= */
        .sticky-search {
            position: sticky;
            top: 0;
            padding: 10px 0;
            width: 100%;
        }

        /* ========================= SEARCH INPUT FIX ========================= */
        .input-group {
            width: 100%;
        }

        #smartSearch {
            min-width: 0 !important;
        }

        /* ========================= TABLE RESPONSIVE FIX ========================= */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
        }

        /* IMPORTANT */
        #patientTable {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* IMPORTANT */
        .dataTables_wrapper {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: auto;
        }

        /* IMPORTANT */
        .dataTables_scroll {
            width: 100% !important;
        }

        /* IMPORTANT */
        table.dataTable {
            width: 100% !important;
            max-width: 100% !important;
            table-layout: auto;
        }

        /* ========================= TABLE CELL FIX ========================= */
        table.dataTable th,
        table.dataTable td {
            vertical-align: middle !important;
            text-align: center !important;
            white-space: nowrap;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before {
            margin-right: 8px;
        }

        /* ========================= CARD STYLING ========================= */
        .patient-card {
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #0d6efd;
        }

        .patient-card h5 {
            margin-bottom: 14px;
            font-weight: bold;
            word-break: break-word;
        }

        .patient-info-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 6px;
        }

        .patient-info-label {
            font-weight: 600;
            color: #666;
            min-width: 110px;
        }

        .patient-info-value {
            text-align: right;
            word-break: break-word;
        }

        .patient-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* ========================= MOBILE FIX ========================= */
        @media(max-width:767px) {
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
        }
    </style>
    @endpush


    <main>
        <div class="container-fluid py-4 px-2 px-md-3">

            {{-- HEADER --}}
            <div class="row mb-4 align-items-center">

                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <p class="h3 text-danger m-0">
                        <strong><em>Patients <span class="text-success">Dashboard</span></em></strong>
                    </p>
                </div>

                <div class="col-md-6 col-12 text-md-end">
                    @can('Patient create')
                    <a href="{{ route('admin.patients.create') }}"
                        class="btn btn-dark shadow-sm"
                        accesskey="n">
                        <u>N</u>ew Patient
                    </a>
                    @endcan
                </div>

            </div>

            {{-- STICKY SEARCH --}}
            <div class="sticky-search mb-3">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7 col-12">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white mr-1">
                                <i class="fa fa-search"></i>
                            </span>

                            <input type="text" id="smartSearch" class="form-control auto-focus"
                                placeholder="Search by Patient Name / MR No. / CNIC No. / Phone No.">
                        </div>
                    </div>
                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div id="desktopTableWrapper" class="d-none d-md-block">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="patientTable" class="table table-bordered table-striped align-middle">
                                <thead class="bg-indigo-500 text-white text-center">
                                    <tr>
                                        <th>MR No.</th>
                                        <th>PATIENT NAME</th>
                                        <th>FATHERS NAME</th>
                                        <th>AGE (Years)</th>
                                        <th>GENDER</th>
                                        <th>MARITAL STATUS</th>
                                        <th>PHONE</th>
                                        <th>EMAIL</th>
                                        <th>CNIC #</th>
                                        <th>ADDRESS</th>
                                        <th>REGISTERED ON</th>
                                        <th>REGISTERED BY</th>
                                        <th>UPDATED ON</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            {{-- MOBILE CARDS --}}
            <div id="mobileCardsWrapper" class="d-md-none">
                <div id="patientCardsContainer"></div>
            </div>

        </div>
    </main>


    @push('scripts')
    <script>
        $(function() {

            const isMobile = () => window.innerWidth < 768;

            let dt = null;
            let abortController = null;

            let state = {
                search: '',
                pageLength: 10
            };

            /* ----------------------------
                CORE API FETCH (SINGLE SOURCE)
            ----------------------------- */
            function fetchPatients(extra = {}, callback = null) {

                if (abortController) {
                    abortController.abort();
                }

                abortController = new AbortController();

                const payload = {
                    smart_search: state.search,
                    length: state.pageLength,
                    ...extra
                };

                return $.ajax({
                    url: "{{ route('admin.patients.data') }}",
                    data: payload,
                    signal: abortController.signal,
                    success: function(res) {
                        if (callback) callback(res);
                    }
                });
            }

            /* ----------------------------
                MOBILE RENDER
            ----------------------------- */
            function renderMobile(data) {

                let html = '';

                if (!data || !data.length) {
                    html = `<div class="alert alert-warning text-center">No Patients Found</div>`;
                } else {

                    data.forEach(patient => {

                        html += `
                <div class="patient-card">
                    <h5 class="text-primary">MR-${patient.id} : ${patient.name ?? '-'}</h5>

                    ${row('Father Name', patient.fname)}
                    ${row('Age', patient.age)}
                    ${row('Gender', patient.gender)}
                    ${row('Marital Status', patient.marital_status)}
                    ${row('Phone', patient.phone)}
                    ${row('Email', patient.email)}
                    ${row('CNIC', patient.cnic)}
                    ${row('Address', patient.address)}
                    ${row('Registered On', patient.registered_on)}
                    ${row('Registered By', patient.usersName)}
                    ${row('Updated On', patient.updated_on)}

                    <div class="patient-actions">${patient.action ?? ''}</div>
                </div>`;
                    });
                }

                $('#patientCardsContainer').html(html);
            }

            function row(label, value) {
                return `
                <div class="patient-info-row">
                    <span class="patient-info-label">${label}</span>
                    <span class="patient-info-value">${value ?? '-'}</span>
                </div>`;
            }

            /* ----------------------------
                DESKTOP DATATABLE
            ----------------------------- */
            function initDataTable() {

                if ($.fn.DataTable.isDataTable('#patientTable')) {
                    dt.destroy();
                }

                dt = $('#patientTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    scrollX: false,
                    pageLength: state.pageLength,
                    searching: false,
                    order: [
                        [0, 'desc']
                    ],

                    ajax: function(data, callback) {

                        fetchPatients({
                            draw: data.draw,
                            start: data.start,
                            length: data.length,
                            order: data.order,
                            columns: data.columns
                        }, function(res) {
                            callback(res);
                        });
                    },

                    columns: [{
                            data: 'id',
                            responsivePriority: 1
                        },

                        {
                            data: 'name',
                            responsivePriority: 1
                        },
                        
                        {
                            data: 'fname',
                            responsivePriority: 2
                        },

                        {
                            data: 'age',
                            responsivePriority: 2
                        },
                        {
                            data: 'gender',
                            responsivePriority: 3
                        },
                        
                        {
                            data: 'marital_status',
                            responsivePriority: 3
                        },

                        {
                            data: 'phone',
                            responsivePriority: 2
                        },

                        {
                            data: 'email',
                            responsivePriority: 10
                        },
                        {
                            data: 'cnic',
                            responsivePriority: 3
                        },

                        {
                            data: 'address',
                            responsivePriority: 2
                        },
                        {
                            data: 'updated_on',
                            responsivePriority: 9
                        },

                        {
                            data: 'usersName',
                            responsivePriority: 7
                        },
                        {
                            data: 'registered_on',
                            responsivePriority: 8
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            responsivePriority: 1
                        }
                    ]
                });
            }

            /* ----------------------------
                VIEW SWITCH
            ----------------------------- */
            function renderView() {

                if (isMobile()) {

                    $('#desktopTableWrapper').hide();
                    $('#mobileCardsWrapper').show();

                    fetchPatients({}, function(res) {
                        renderMobile(res.data || []);
                    });

                } else {

                    $('#mobileCardsWrapper').hide();
                    $('#desktopTableWrapper').show();

                    if (!dt) {
                        initDataTable();
                    } else {
                        dt.columns.adjust().responsive.recalc();
                    }
                }
            }

            /* ----------------------------
                SEARCH HANDLER (SAFE + DEBOUNCED)
            ----------------------------- */
            let timer = null;

            $('#smartSearch').on('keyup', function() {

                clearTimeout(timer);

                timer = setTimeout(function() {

                    state.search = $('#smartSearch').val().trim();

                    if (isMobile()) {

                        fetchPatients({}, function(res) {
                            renderMobile(res.data || []);
                        });

                    } else {

                        if (dt) dt.draw();
                    }

                }, 350);
            });

            /* ----------------------------
                RESIZE HANDLER
            ----------------------------- */
            $(window).on('resize', function() {
                renderView();
            });

            /* ----------------------------
                INIT
            ----------------------------- */
            renderView();

            if (!isMobile()) {
                setTimeout(function() {
                    $('#smartSearch').focus();
                }, 500);
            }

        });
    </script>
    @endpush

</x-app-layout>