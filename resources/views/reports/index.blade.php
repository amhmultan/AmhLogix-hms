<x-app-layout>
    
        <div class="flex justify-between items-center pt-4 mx-3">
            <p class="h3 text-danger"><strong><em>Stock <span class="text-success">Report</span></em></strong></p>
        </div>

    <div class="my-6 p-4">

        <!-- Filters Form -->
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-5 row">
            <div class="col-auto">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="form-control">
            </div>
            <div class="col-auto">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="form-control">
            </div>
            <div class="col-auto">
                <label for="filter_type" class="form-label">Filter Type</label>
                <select id="filter_type" name="filter_type" class="form-select">
                    <option value="both" {{ request('filter_type')=='both'?'selected':'' }}>Both</option>
                    <option value="purchase" {{ request('filter_type')=='purchase'?'selected':'' }}>Purchases</option>
                    <option value="sale" {{ request('filter_type')=='sale'?'selected':'' }}>Sales</option>
                </select>
            </div>
            <div class="col-auto" style="margin-top: 28px;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <hr />

        <!-- PDF iframe & loading spinner -->
        @if(request('from_date') || request('to_date') || request('filter_type'))
            <div id="pdfContainer" style="position: relative; width: 100%; min-height: 600px; border:1px solid #ccc;">
                <!-- Loading overlay -->
                <div id="pdfLoading" style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;z-index:10;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <iframe id="pdfFrame"
                    src="{{ route('admin.reports.print', request()->all()) }}"
                    style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                    frameborder="0"></iframe>
            </div>
        @else
            <p class="text-center text-muted mt-4" style="font-size:16px;">
                Please select <strong>From Date, To Date, or Filter Type</strong> to view the stock report.
            </p>
        @endif

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const iframe = document.getElementById('pdfFrame');
            const loading = document.getElementById('pdfLoading');

            if(iframe){
                iframe.onload = () => {
                    try {
                        // Hide loading spinner
                        if(loading) loading.style.display = 'none';

                        // Adjust iframe height dynamically
                        const pdfContainer = document.getElementById('pdfContainer');
                        const doc = iframe.contentWindow.document;
                        if(doc && doc.body){
                            pdfContainer.style.height = doc.body.scrollHeight + 'px';
                        }
                    } catch(e){
                        // Ignore cross-origin issues
                        if(loading) loading.style.display = 'none';
                    }
                };
            }
        });
    </script>
    @endpush
</x-app-layout>
