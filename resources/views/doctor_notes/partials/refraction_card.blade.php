<style>
@media screen, print {
    .table-responsive {
        border: 1px solid #000 !important;
        border-radius: 5px;
        display: inline-block;
        width: 100%;
        page-break-inside: avoid;
    }

    .eye-table{
        width: 100%;
        max-width: 100%;
        border-collapse: collapse !important;
        border-spacing: 0 !important;
        background: #fff !important;
        margin: 0;
    }

    .eye-table th,
    .eye-table td{
        border: 1px solid #000 !important;
        padding: 10px;
        vertical-align: middle;
        text-align: center;
        background-clip: padding-box;
        font-size: 14px;
    }

    .eye-table th:first-child,
    .eye-table td:first-child {
        border-left: 1px solid #000 !important;
    }

    .eye-table th:last-child,
    .eye-table td:last-child {
        border-right: 1px solid #000 !important;
    }

    .eye-table thead th{
        font-weight: bold;
        background: #f8f9fa !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
        border: 1px solid #000 !important;
    }

    .eye-table tbody td{
        height: 40px;
    }
}
</style>

<div class="table-responsive">
    <table class="table mb-0 eye-table">
        <thead>
            <tr>
                <th colspan="4">Right Eye (OD)</th>
                <th colspan="4">Left Eye (OS)</th>
            </tr>
            <tr>
                <th>SPH</th>
                <th>CYL</th>
                <th>AXIS</th>
                <th>VA</th>

                <th>SPH</th>
                <th>CYL</th>
                <th>AXIS</th>
                <th>VA</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <input type="text" name="right_sph" value="{{ old('right_sph', $doctor_notes->right_sph ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="right_cyl" value="{{ old('right_cyl', $doctor_notes->right_cyl ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="right_axis" value="{{ old('right_axis', $doctor_notes->right_axis ?? '') }}&deg;" class="form-control">
                </td>
                <td>
                    <input type="text" name="right_va" value="{{ old('right_va', $doctor_notes->right_va ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="left_sph" value="{{ old('left_sph', $doctor_notes->left_sph ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="left_cyl" value="{{ old('left_cyl', $doctor_notes->left_cyl ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="left_axis" value="{{ old('left_axis', $doctor_notes->left_axis ?? '') }}&deg;" class="form-control">
                </td>
                <td>
                    <input type="text" name="left_va" value="{{ old('left_va', $doctor_notes->left_va ?? '') }}" class="form-control">
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <input type="text" name="right_add" value="{{ old('right_add', $doctor_notes->right_add ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="right_pd" value="{{ old('right_pd', $doctor_notes->right_pd ?? '') }}" class="form-control">
                </td>
                <td colspan="3">
                    <input type="text" name="left_add" value="{{ old('left_add', $doctor_notes->left_add ?? '') }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="left_pd" value="{{ old('left_pd', $doctor_notes->left_pd ?? '') }}" class="form-control">
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <input type="text" name="right_remarks" value="{{ old('right_remarks', $doctor_notes->right_remarks ?? '') }}" class="form-control">
                </td>
                <td colspan="4">
                    <input type="text" name="left_remarks" value="{{ old('left_remarks', $doctor_notes->left_remarks ?? '') }}" class="form-control">
                </td>
            </tr>
        </tbody>
    </table>
</div>