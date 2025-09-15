<x-dashboard-layout>
    <x-slot name="title">Data Pasien</x-slot>

    <!-- Header with Add Button -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Data Pasien</h2>
            <p class="text-gray-600">Kelola data pasien Anda</p>
        </div>
        @if(auth()->user()->isMahasiswa())
        <a href="{{ route('patients.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
            <ion-icon name="add" class="mr-2"></ion-icon>
            Tambah Pasien
        </a>
        @endif
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pasien</label>
                <input type="text" placeholder="Nama atau No. RM" 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="discharged">Pulang</option>
                    <option value="transferred">Transfer</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <ion-icon name="search" class="mr-2"></ion-icon>
                    Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Pasien ({{ $patients->total() }} total)
                </h3>
                <div class="flex items-center space-x-2">
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                        <ion-icon name="download"></ion-icon>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                        <ion-icon name="print"></ion-icon>
                    </button>
                </div>
            </div>
        </div>

        @if($patients->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No. RM & Nama
                        </th>
                        <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Informasi Pasien
                        </th>
                        <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Masuk
                        </th>
                        <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        @if(!auth()->user()->isMahasiswa())
                        <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mahasiswa
                        </th>
                        @endif
                        <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $patient->medical_record_number }}
                                </div>
                                <div class="text-sm font-semibold text-blue-600">
                                    {{ $patient->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}, {{ $patient->age }} tahun
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">
                                @if($patient->room_number)
                                    <div class="flex items-center text-xs text-gray-600 mb-1">
                                        <ion-icon name="bed" class="mr-1"></ion-icon>
                                        Kamar: {{ $patient->room_number }}
                                    </div>
                                @endif
                                @if($patient->phone)
                                    <div class="flex items-center text-xs text-gray-600">
                                        <ion-icon name="call" class="mr-1"></ion-icon>
                                        {{ $patient->phone }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">
                                {{ $patient->admission_date->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $patient->daysAdmitted }} hari dirawat
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $patient->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($patient->status === 'discharged' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                @if($patient->status === 'active')
                                    <ion-icon name="checkmark-circle" class="mr-1"></ion-icon>
                                    Aktif
                                @elseif($patient->status === 'discharged')
                                    <ion-icon name="home" class="mr-1"></ion-icon>
                                    Pulang
                                @else
                                    <ion-icon name="arrow-forward" class="mr-1"></ion-icon>
                                    Transfer
                                @endif
                            </span>
                        </td>
                        @if(!auth()->user()->isMahasiswa())
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900">{{ $patient->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $patient->user->student_id }}</div>
                        </td>
                        @endif
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('patients.show', $patient) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-1 rounded transition-colors"
                                   title="Lihat Detail">
                                    <ion-icon name="eye"></ion-icon>
                                </a>
                                @if(auth()->user()->isMahasiswa() && $patient->user_id === auth()->id())
                                <a href="{{ route('patients.edit', $patient) }}" 
                                   class="text-yellow-600 hover:text-yellow-800 p-1 rounded transition-colors"
                                   title="Edit">
                                    <ion-icon name="create"></ion-icon>
                                </a>
                                <form method="POST" action="{{ route('patients.destroy', $patient) }}" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 p-1 rounded transition-colors"
                                            title="Hapus">
                                        <ion-icon name="trash"></ion-icon>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $patients->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <ion-icon name="people" class="text-6xl text-gray-400 mb-4"></ion-icon>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada data pasien</h3>
            <p class="text-gray-600 mb-4">Mulai tambahkan data pasien untuk memulai dokumentasi keperawatan.</p>
            @if(auth()->user()->isMahasiswa())
            <a href="{{ route('patients.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg inline-flex items-center transition-colors">
                <ion-icon name="add" class="mr-2"></ion-icon>
                Tambah Pasien Pertama
            </a>
            @endif
        </div>
        @endif
    </div>
</x-dashboard-layout>
