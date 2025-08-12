<x-app-layout>
    <div class="container bg-white p-5">
        @can('Token access')
            
        {{-- Action Buttons --}}
        <div class="row mb-5 text-center no-print">
            <div class="col-sm-12">
                <a href="{{ route('admin.tokens.index') }}" class="btn btn-info text-light"><u>B</u>ack</a>
                <button class="btn btn-success text-light" onclick="printDiv('printableArea')" accesskey="p">Print</button>

                @can('Token edit')
                <a href="{{ route('admin.tokens.edit', $token->id) }}" class="btn btn-warning"><u>E</u>dit</a>
                @endcan

                @can('Token delete')
                <form action="{{ route('admin.tokens.destroy', $token->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger"><u>D</u>elete</button>
                </form>
                @endcan
            </div>
        </div>
        
            <div class="container" id="printableArea">

            {{-- Hospital Header --}}
            @if($hospital)
            <div class="row">
                <div class="col-sm-2 text-center">
                    <img src="{{ asset('img/' . $hospital->logo) }}" 
                         style="border: 5px solid black; width:150px; height:150px; padding: 5px;" 
                         alt="{{ $hospital->title }} Logo">
                </div>
                <div class="col-sm-10 text-center">
                    <h2 class="display-5 fw-bold text-uppercase">{{ $hospital->title }}</h2>
                    <p>{{ $hospital->address }}</p>
                    <p>
                        <strong>Contact:</strong> {{ $hospital->contact }} |
                        <strong>Email:</strong> {{ $hospital->email }} |
                        <strong>Website:</strong> {{ $hospital->website }}
                    </p>
                </div>
            </div>
            @endif

            <hr>

            {{-- Patient Info --}}
            <div class="fw-bold">Patient Information</div>
            <table class="table table-bordered w-100">
                <tbody>
                    <tr>
                        <th>Token No:</th>
                        <td class="text-center">{{ $token->id }}</td>
                        <th>MR No:</th>
                        <td class="text-center">{{ $token->fk_patients_id }}</td>
                        <th>Patient:</th>
                        <td class="text-center">{{ $token->pName }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th>
                        <td class="text-center">{{ $token->pAge }}</td>
                        <th>Age:</th>
                        <td class="text-center">{{ 
                            $token->pAge
                            ? \Carbon\Carbon::parse($token->pAge)->age . ' years, ' . \Carbon\Carbon::parse($token->pAge)->month . ' months, ' . \Carbon\Carbon::parse($token->pAge)->day . ' days'
                            : 'N/A'}}</td>
                        <th>Checkup Date:</th>
                        <td class="text-center">{{ date('d-m-Y', strtotime($token->created_at)) }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td colspan="5">{{ $token->pAddress }}</td>
                    </tr>
                </tbody>
            </table>

            <hr>

            {{-- Rx Symbol --}}
            <div class="display-5 fw-bold pl-4">℞</div>

            {{-- Spacer --}}
            <div style="height: 600px;"></div>

            {{-- Doctor Signature --}}
            <div class="text-end mt-3">
                <div>Doctor's Signature</div>
            </div>
        </div>

        @endcan
    </div>

    {{-- Print Script --}}
    <script>
        function printDiv(printableArea) {
            const printContents = document.getElementById(printableArea).innerHTML;
            const printWindow = window.open('', '', 'height=800,width=1000');
            printWindow.document.write('<html><head><title>MR No: {{ $token->fk_patients_id }}</title>');
            printWindow.document.write('<link rel="stylesheet" href="{{ asset('bootstrap-5.1.3-dist/css/bootstrap.min.css') }}">');
            // printWindow.document.write('<link href="{{ asset('bootstrap-4.1.3-dist/css/bootstrap.min.css') }}" rel="stylesheet">');
            printWindow.document.write('<style>@media print {.no-print { display: none !important; }}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</x-app-layout>
