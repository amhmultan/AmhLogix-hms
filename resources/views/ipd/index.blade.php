<x-app-layout>
  <main>
    <div class="container-fluid py-4 px-5">
        <div class="row mb-5">
            <div class="col-sm-6">
                <p class="h3 text-danger"><strong><em>IPD <span class="text-success">Dashboard</span></em></strong></p>
            </div>
        </div>
        <div class="container mx-auto py-8">

            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Wards --}}
                @can('Ward access')
                    <a href="{{ route('admin.wards.index') }}"
                    class="no-underline hover:no-underline group block bg-gradient-to-r from-purple-600 to-indigo-500 text-white font-extrabold text-2xl py-8 rounded-2xl shadow-xl hover:from-purple-700 hover:to-indigo-600 transition-all text-center relative"
                    accesskey="w"
                    title="{{ $wardsCount ?? 0 }} total wards">
                    <i class="fas fa-building fa-3x mb-2"></i>
                    <div>Wards</div>
                    <span class="absolute top-2 right-4 bg-white text-purple-700 font-bold text-sm px-2 py-1 rounded-full">{{ $wardsCount ?? 0 }}</span>
                </a>
                @endcan
                {{-- Beds --}}
                @can('Bed access')
                    <a href="{{ route('admin.beds.index') }}"
                    class="no-underline hover:no-underline group block bg-gradient-to-r from-green-500 to-teal-500 text-white font-extrabold text-2xl py-8 rounded-2xl shadow-xl hover:from-green-600 hover:to-teal-600 transition-all text-center relative"
                    accesskey="b"
                    title="{{ $availableBeds ?? 0 }} beds available">
                    <i class="fas fa-bed fa-3x mb-2"></i>
                    <div>Beds</div>
                    <span class="absolute top-2 right-4 bg-white text-green-700 font-bold text-sm px-2 py-1 rounded-full">{{ $availableBeds ?? 0 }}</span>
                </a>
                @endcan
                {{-- Admissions --}}
                @can('IPD_Admission access')
                <a href="{{ route('admin.admissions.index') }}"
                class="no-underline hover:no-underline group block bg-gradient-to-r from-red-500 to-pink-500 text-white font-extrabold text-2xl py-8 rounded-2xl shadow-xl hover:from-red-600 hover:to-pink-600 transition-all text-center relative"
                accesskey="a"
                title="{{ $admissionsCount ?? 0 }} patients admitted">
                    <i class="fas fa-procedures fa-3x mb-2"></i>
                    <div>Admissions</div>
                    <span class="absolute top-2 right-4 bg-white text-red-600 font-bold text-sm px-2 py-1 rounded-full">{{ $admissionsCount ?? 0 }}</span>
                </a>
                @endcan
                {{-- Charges --}}
                @can('IPD_Billing access')
                <a href="{{ route('admin.charges.index') }}"
                class="no-underline hover:no-underline group block bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-extrabold text-2xl py-8 rounded-2xl shadow-xl hover:from-yellow-600 hover:to-orange-600 transition-all text-center relative"
                accesskey="c"
                title="{{ $chargesCount ?? 0 }} pending charges">
                    <i class="fas fa-file-invoice-dollar fa-3x mb-2"></i>
                    <div>Charges</div>
                    <span class="absolute top-2 right-4 bg-white text-yellow-600 font-bold text-sm px-2 py-1 rounded-full">{{ $chargesCount ?? 0 }}</span>
                </a>
                @endcan
                {{-- Daily Notes --}}
                @can('IPD_Notes access')
                <a href="{{ route('admin.daily-notes.index') }}"
                class="no-underline hover:no-underline group block bg-gradient-to-r from-blue-500 to-indigo-400 text-white font-extrabold text-2xl py-8 rounded-2xl shadow-xl hover:from-blue-600 hover:to-indigo-500 transition-all text-center relative"
                accesskey="d"
                title="{{ $notesCount ?? 0 }} notes today">
                    <i class="fas fa-notes-medical fa-3x mb-2"></i>
                    <div>Daily Notes</div>
                    <span class="absolute top-2 right-4 bg-white text-blue-700 font-bold text-sm px-2 py-1 rounded-full">{{ $notesCount ?? 0 }}</span>
                </a>
                @endcan
                {{-- IPD Reports --}}
                @can('IPD_Reports access')
                <a href="{{ route('admin.ipd.ipd_reports.index') }}"
                class="no-underline hover:no-underline group block bg-gradient-to-r from-gray-700 to-gray-900 text-white font-extrabold text-2xl py-8 rounded-2xl shadow-xl hover:from-gray-800 hover:to-gray-950 transition-all text-center relative"
                accesskey="r"
                title="#">
                    <i class="fas fa-receipt fa-3x mb-2"></i>
                    <div>Reports</div>
                    <span class="absolute top-2 right-4 bg-white text-gray-800 font-bold text-sm px-2 py-1 rounded-full">{{ $reports ?? 0 }}</span>
                </a>
                @endcan
            </div>
        </div>

    </div>
  </main>
</x-app-layout>