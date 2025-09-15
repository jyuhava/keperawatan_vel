<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Diagnosis Keperawatan</h1>
                <p class="text-slate-600">Kelola diagnosis keperawatan berdasarkan SDKI</p>
            </div>
            <a href="{{ route('nursing-diagnoses.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <ion-icon name="add-outline"></ion-icon>
                Tambah Diagnosis
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <form method="GET" action="{{ route('nursing-diagnoses.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Cari Pasien/Diagnosis</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama pasien atau kode diagnosis..."
                           class="w-full border border-slate-300 rounded-lg px-3 py-2">
                </div>
                <div class="min-w-36">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Prioritas</label>
                    <select name="priority" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                        <option value="">Semua</option>
                        <option value="tinggi" {{ request('priority') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="sedang" {{ request('priority') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="rendah" {{ request('priority') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isDosen())
                <div class="min-w-48">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Mahasiswa</label>
                    <select name="student_id" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                        <option value="">Semua Mahasiswa</option>
                        @foreach(\App\Models\User::where('role', 'mahasiswa')->get() as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <button type="submit" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg">
                    Filter
                </button>
            </form>
        </div>

        <!-- Diagnoses Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                Pasien
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                Diagnosis (SDKI)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                Prioritas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                Mahasiswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($diagnoses as $diagnosis)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $diagnosis->patient->name }}</div>
                                        <div class="text-sm text-slate-500">No. MR: {{ $diagnosis->patient->medical_record_number }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $diagnosis->sdki_code ?? 'D.0001' }}</div>
                                        <div class="text-sm text-slate-600">{{ Str::limit($diagnosis->diagnosis, 60) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $diagnosis->priority == 'tinggi' ? 'bg-red-100 text-red-800' : 
                                           ($diagnosis->priority == 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($diagnosis->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-900">
                                    {{ $diagnosis->user->name }}
                                </td>
                                <td class="px-6 py-4 text-slate-900">
                                    {{ $diagnosis->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('nursing-diagnoses.show', $diagnosis) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </a>
                                        @can('update', $diagnosis)
                                            <a href="{{ route('nursing-diagnoses.edit', $diagnosis) }}" 
                                               class="text-yellow-600 hover:text-yellow-800">
                                                <ion-icon name="create-outline"></ion-icon>
                                            </a>
                                        @endcan
                                        @can('delete', $diagnosis)
                                            <form method="POST" action="{{ route('nursing-diagnoses.destroy', $diagnosis) }}" 
                                                  class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    <ion-icon name="medical-outline" class="mx-auto text-4xl mb-2"></ion-icon>
                                    <p>Belum ada data diagnosis keperawatan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($diagnoses->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $diagnoses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
