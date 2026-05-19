<x-app-layout>
    @push('styles')
        <!-- Bootstrap + Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <style>
            .card-box {
                border-radius: 1rem;
                padding: 20px;
                color: white;
                min-height: 160px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                position: relative;
                transition: transform 0.2s ease;
            }

            .card-box:hover {
                transform: translateY(-5px);
            }

            .card-box i {
                font-size: 3rem;
                position: absolute;
                top: 15px;
                right: 20px;
                opacity: 0.2;
            }

            .count-number {
                font-size: 2rem;
                font-weight: bold;
            }

            .count-label {
                font-size: 1rem;
                margin-top: 5px;
                font-style: italic;
            }

            .card-box a {
                margin-top: 10px;
                display: inline-block;
            }

            /* Custom colors */
            .bg-primary { background-color: #007bff !important; }
            .bg-success { background-color: #28a745 !important; }
            .bg-danger  { background-color: #dc3545 !important; }
            .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
            .bg-info    { background-color: #17a2b8 !important; }
            .bg-dark    { background-color: #343a40 !important; }
            .bg-secondary { background-color: #6c757d !important; }
        </style>
    @endpush

    <div class="container py-4">
        <!-- Hospital Section -->
        <h2 class="text-center mb-4 text-black"><strong>O.P.D</strong></h2>
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="card-box bg-primary">
                    <i class="fas fa-money-bill-wave"></i>
                    <div class="count-number">{{ DB::table('tokens')->whereDate('updated_at', today())->sum('tokens.denomination') }}</div>
                    <div class="count-label">Today's OPD Sale</div>
                    <a class="btn btn-sm btn-light" href="{{ route('admin.tokens.index') }}">More Info</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-box bg-danger">
                    <i class="fas fa-user-injured"></i>
                    <div class="count-number">{{ DB::table('patients')->whereDate('created_at', today())->count() }}</div>
                    <div class="count-label">Today's Patients</div>
                    <a class="btn btn-sm btn-light" href="{{ route('admin.patients.index') }}">More Info</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-box bg-success">
                    <i class="fas fa-users"></i>
                    <div class="count-number">{{ DB::table('patients')->count() }}</div>
                    <div class="count-label">Total Patients</div>
                    <a class="btn btn-sm btn-light" href="{{ route('admin.patients.index') }}">More Info</a>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-5">

        <!-- Pharmacy Section -->
        <h2 class="text-center mb-4 text-black"><strong>PHARMACY</strong></h2>
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="card-box bg-info">
                    <i class="fas fa-cart-plus"></i>
                    <div class="count-number">{{ DB::table('purchase_invoices')->whereDate('created_at', today())->sum('net_amount') }}</div>
                    <div class="count-label">Today's Purchase</div>
                    <a class="btn btn-sm btn-light" href="{{ route('admin.purchases.index') }}">More Info</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-box bg-secondary">
                    <i class="fas fa-cash-register"></i>
                    <div class="count-number">{{ DB::table('sale_invoices')->whereDate('created_at', today())->sum('net_amount') }}</div>
                    <div class="count-label">Today's Sale</div>
                    <a class="btn btn-sm btn-light" href="{{ route('admin.sales.index') }}">More Info</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-box bg-warning text-white">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <div class="count-number text-white">{{ DB::table('products')->count() }}</div>
                    <div class="count-label text-white">Medicines</div>
                    <a class="btn btn-sm btn-light" href="{{ route('admin.products.index') }}">More Info</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
