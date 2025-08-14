<x-app-layout>
<main>
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h4 class="fw-bold">OPD Report</h4>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" id="from_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" id="to_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Doctor</label>
                <select id="doctor_id" class="form-control">
                    <option value="">All</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Speciality</label>
                <select id="department_id" class="form-control">
                    <option value="">All</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <button id="filterBtn" class="btn btn-primary me-2">Filter</button>
            <button id="resetBtn" class="btn btn-secondary">Reset</button>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="report-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase text-center">Token #</th>
                        <th class="text-uppercase text-center">Date</th>
                        <th class="text-uppercase text-center">Patient</th>
                        <th class="text-uppercase text-center">Patient MR #</th>
                        <th class="text-uppercase text-center">Doctor</th>
                        <th class="text-uppercase text-center">Speciality</th>
                        <th class="text-uppercase text-center">Fees</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Totals:</th>
                        <th id="total_tokens" class="text-center"></th>
                        <th id="total_amount" class="text-center"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @push('scripts')
    <!-- DataTables and Buttons -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            let table = $('#report-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: function () {
                            let from = $('#from_date').val() || 'Start';
                            let to = $('#to_date').val() || 'End';
                            return `OPD Report (${from} to ${to})`;
                        },
                        footer: false, // disable default tfoot export
                        customize: function (xlsx) {
                            let sheet = xlsx.xl.worksheets['sheet1.xml'];
                            let lastRow = $('row', sheet).last();
                            let rowIndex = parseInt(lastRow.attr('r')) + 1;
                            let totalTokens = $('#total_tokens').text();
                            let totalAmount = $('#total_amount').text();

                            // Manually add totals row in Excel
                            let totalsRow = `
                                <row r="${rowIndex}">
                                    <c t="inlineStr" r="A${rowIndex}"><is><t></t></is></c>
                                    <c t="inlineStr" r="B${rowIndex}"><is><t></t></is></c>
                                    <c t="inlineStr" r="C${rowIndex}"><is><t></t></is></c>
                                    <c t="inlineStr" r="D${rowIndex}"><is><t></t></is></c>
                                    <c t="inlineStr" r="E${rowIndex}"><is><t>Totals:</t></is></c>
                                    <c t="inlineStr" r="F${rowIndex}"><is><t>${totalTokens}</t></is></c>
                                    <c t="inlineStr" r="G${rowIndex}"><is><t>${totalAmount}</t></is></c>
                                </row>`;
                            sheet.childNodes[0].childNodes[1].innerHTML += totalsRow;
                        }
                    },
                    {
                        extend: 'pdf',
                        title: function () {
                            let from = $('#from_date').val() || 'Start';
                            let to = $('#to_date').val() || 'End';
                            return `OPD Report (${from} to ${to})`;
                        },
                        footer: false, // disable default footer for PDF
                        customize: function (doc) {
                            let totalTokens = $('#total_tokens').text();
                            let totalAmount = $('#total_amount').text();

                            // Add totals row manually with correct colspan
                            doc.content[1].table.body.push([
                                { text: 'Totals:', colSpan: 5, alignment: 'right', bold: true },
                                {}, {}, {}, {},
                                { text: totalTokens, alignment: 'center', bold: true },
                                { text: totalAmount, alignment: 'center', bold: true }
                            ]);
                        }
                    },
                    {
                        extend: 'print',
                        title: function () {
                            let from = $('#from_date').val() || 'Start';
                            let to = $('#to_date').val() || 'End';
                            return `OPD Report (${from} to ${to})`;
                        },
                        footer: false, // disable default tfoot export
                        customize: function (win) {
                            let totalTokens = $('#total_tokens').text();
                            let totalAmount = $('#total_amount').text();

                            // Add totals row manually after the table
                            $(win.document.body).find('table').append(
                                `<tr>
                                    <td colspan="5" style="text-align:right;font-weight:bold;">Totals:</td>
                                    <td style="text-align:center;font-weight:bold;">${totalTokens}</td>
                                    <td style="text-align:center;font-weight:bold;">${totalAmount}</td>
                                </tr>`
                            );
                        }
                    },
                ],
                ajax: {
                    url: "{{ route('admin.tokens.token_report.data') }}",
                    data: function (d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.doctor_id = $('#doctor_id').val();
                        d.department_id = $('#department_id').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data) {
                            if (!data) return '';
                            let date = new Date(data);
                            return date.toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });
                        }
                    },
                    { data: 'patient_name', name: 'patient_name' },
                    { data: 'patient_mr_no', name: 'patient_mr_no' },
                    { data: 'doctor_name', name: 'doctor_name' },
                    { data: 'speciality_name', name: 'speciality_name' },
                    { data: 'amount_formatted', name: 'amount_formatted' }
                ],
                drawCallback: function (settings) {
                    if (settings.json) {
                        $('#total_tokens').html(settings.json.totalTokens);
                        $('#total_amount').html(settings.json.totalAmount);
                    }
                }
            });

            $('#filterBtn').click(function () {
                table.ajax.reload();
            });

            $('#resetBtn').click(function () {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#doctor_id').val('');
                $('#department_id').val('');
                table.ajax.reload();
            });
        });
    </script>
    
    @endpush
</main>
</x-app-layout>
