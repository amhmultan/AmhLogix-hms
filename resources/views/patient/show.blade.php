<x-app-layout>

@push('styles')
<style>

.opd-page{
    position: relative;
    width: 100%;
    min-height: 100mm;
    margin: 0 auto;
    padding: 6mm;
    background: #fff;
    box-sizing: border-box;
    }
.opd-strip{
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding: 16px 10px;
        border: 2px solid #000;
        border-radius: 4px;
        font-size: 16px;
        line-height: 1.8;
        background: #fff;
        margin-top: 50px;
    }

.opd-block{
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
        border-right: 1px solid #ddd;
        padding-right: 10px;
    }

.opd-block:last-child{
        border-right: none;
    }
.opd-item{
        display: flex;
        gap: 10px;
        white-space: nowrap;
    }

.opd-item strong{
        min-width: 110px;
        font-weight: 800;
        color: #222;
    }
</style>
@endpush

<!-- ACTION BUTTONS -->
<div class="container mt-3 text-center">

    <a href="{{ route('admin.patients.index') }}" class="btn btn-info btn-sm text-light">Back</a>

    <input class="btn btn-success btn-sm text-light"
           type="button"
           onclick="printDiv('printableArea')"
           value="Print" />

    @can('Patient edit')
    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-warning btn-sm text-light">
        Edit
    </a>
    @endcan

</div>
<div class="container bg-white shadow-sm rounded mb-5 my-2 pb-3">

@can('Patient access')

    <!-- A4 WRAPPER -->
    <div id="printableArea" class="opd-page">

        

        <!-- HEADER -->
        <div class="row">

            <div class="col-sm-2">
                <img src="{{ asset('img/'.$hospitals->logo) }}" width="200px" alt="Hospital Logo" class="rounded"/>
            </div>

            <div class="col-sm-9 text-center">
                <h1 class="text-uppercase font-weight-bold mt-2" style="font-family: Arial Black;">
                    {{ $hospitals->title }}
                </h1>
                <div>
                    {{ $hospitals->address }} <br/>
                </div>
            </div>

        </div>

        <!-- PATIENT STRIP -->
        <div class="opd-strip">

            <div class="opd-block">
                <div class="opd-item"><strong>MR#:</strong> {{ $patient->id }}</div>
                <div class="opd-item"><strong>Name:</strong> {{ $patient->name }}</div>
                <div class="opd-item"><strong>Guardian:</strong> {{ $patient->fname }}</div>
                <div class="opd-item"><strong>Gender:</strong> {{ $patient->gender }}</div>
                <div class="opd-item"><strong>Age:</strong> {{ $patient->age_detailed }}</div>
                <div class="opd-item"><strong>Marital:</strong> {{ $patient->marital_status }}</div>
            </div>

            <div class="opd-block">
                <div class="opd-item"><strong>Phone:</strong> {{ $patient->phone }}</div>
                <div class="opd-item"><strong>Email:</strong> {{ $patient->email }}</div>
                <div class="opd-item"><strong>CNIC:</strong> {{ $patient->cnic }}</div>
                <div class="opd-item">
                    <strong>Address:</strong>
                    <span style="white-space: normal;">{{ $patient->address }}</span>
                </div>
                <div class="opd-item">
                    <strong>Reg at:</strong>
                    {{ optional($patient->created_at)->format('d-m-Y h:i A') }}
                </div>
                <div class="opd-item"><strong>Reg By:</strong> {{ $patient->users->name ?? 'N/A' }} </div>
            </div>

            <div class="opd-block">
                <div class="opd-item">
                    <strong>Next of Kin:</strong>
                    <span style="white-space: normal;">{{ $patient->emr_name }}</span>
                </div>
                <div class="opd-item"><strong>Kin Relation:</strong> {{ $patient->relationship }}</div>
                <div class="opd-item"><strong>Kin Phone:</strong> {{ $patient->emr_phone }}</div>
                <div class="opd-item"><strong>History:</strong> {{ $patient->history }}</div>
                <div class="opd-item"><strong>Referred By:</strong> {{ $patient->reffered_by }}</div>
            </div>

        </div>
    </div>

@endcan
</div>

<!-- PRINT SCRIPT -->
<script>
    function printDiv(divName) {
        let printContents = document.getElementById(divName).innerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

</x-app-layout>