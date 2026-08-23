<x-app-layout>

    @push('styles')
    <style>
        .backup-row:hover {
            background-color: #f3f4f6 !important;
        }
    </style>
    @endpush

    <main>
        <div class="container mx-auto px-4 py-5">

            <h1 class="text-2xl font-bold mb-4">Backup Management</h1>

            {{-- Flash Messages --}}
            @foreach (['success', 'error'] as $msg)
            @if(session($msg))
            <div class="mb-4 rounded px-4 py-2 {{ $msg === 'success' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                {{ session($msg) }}
            </div>
            @endif
            @endforeach

            {{-- Create Backup Button --}}
            <form action="{{ route('admin.backups.create') }}"
                method="POST"
                class="mb-6"
                id="backupForm">

                @csrf

                <button type="submit"
                    id="backupBtn"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">

                    <span id="btnText">
                        Create Backup Now
                    </span>

                    <svg id="btnSpinner"
                        class="animate-spin h-5 w-5 text-white hidden"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24">

                        <circle class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4">
                        </circle>

                        <path class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z">
                        </path>

                    </svg>

                </button>
            </form>

            {{-- Backup Files Table --}}
            <table class="w-full border border-gray-300 table-auto border-collapse my-5">

                <thead class="bg-indigo-600 text-white font-semibold uppercase">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">
                            S. No
                        </th>

                        <th class="border border-gray-300 px-4 py-2 text-center">
                            Backup File
                        </th>

                        <th class="border border-gray-300 px-4 py-2 text-center">
                            Size (MB)
                        </th>

                        <th class="border border-gray-300 px-4 py-2 text-center">
                            Created At
                        </th>

                        <th class="border border-gray-300 px-4 py-2 text-center">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($backupFiles as $backup)

                    <tr class="backup-row bg-white text-center transition-colors duration-150">

                        <td class="border border-gray-300 px-4 py-2">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border border-gray-300 px-4 py-2">
                            {{ $backup['name'] }}
                        </td>

                        <td class="border border-gray-300 px-4 py-2">
                            {{ number_format($backup['size'] / 1024 / 1024, 2) }} MB
                        </td>

                        <td class="border border-gray-300 px-4 py-2">
                            {{ date('d-m-y h:i A', $backup['last_modified']) }}
                        </td>

                        <td class="border border-gray-300 px-4 py-2 text-center">

                            <div class="flex justify-center items-center gap-2">

                                {{-- Download --}}
                                <a href="{{ route('admin.backups.download', $backup['name']) }}"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-decoration-none">
                                    Download
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.backups.delete', $backup['name']) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this backup?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>

                                </form>

                                {{-- Restore --}}
                                <form action="{{ route('admin.backups.restore', $backup['name']) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to restore this backup? This will overwrite your current database.');">

                                    @csrf

                                    <button type="submit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                        Restore
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4"
                            class="text-center px-4 py-6">
                            No backups found.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </main>

    <script>
        document.getElementById('backupForm').addEventListener('submit', function() {
            document.getElementById('btnText').classList.add('hidden');
            document.getElementById('btnSpinner').classList.remove('hidden');
        });
    </script>

</x-app-layout>