<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Implementasi Keperawatan</h1>
                <p class="text-slate-600">Dokumentasi pelaksanaan tindakan keperawatan</p>
            </div>
            <a href="{{ route('implementations.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <ion-icon name="add-outline"></ion-icon>
                Tambah Implementasi
            </a>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Cari Pasien</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Nama pasien atau nomor rekam medis...">
                </div>
                <div class="min-w-48">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                        <option value="">Semua Status</option>
                        <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="discontinued" {{ request('status') == 'discontinued' ? 'selected' : '' }}>Dihentikan</option>
                    </select>
                </div>
                <div class="min-w-48">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2">
                </div>
                <button type="submit" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
                @if(request()->hasAny(['search', 'status', 'date']))
                <a href="{{ route('implementations.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-700 px-4 py-2 rounded-lg">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <ion-icon name="document-text-outline" class="text-2xl"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600">Total Implementasi</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $implementations->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <ion-icon name="checkmark-circle-outline" class="text-2xl"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600">Selesai</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $implementations->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <ion-icon name="time-outline" class="text-2xl"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600">Berlangsung</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $implementations->where('status', 'in_progress')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-slate-100 text-slate-600">
                        <ion-icon name="calendar-outline" class="text-2xl"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600">Hari Ini</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $implementations->where('implementation_date', today())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Implementations List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($implementations->count() > 0)
                <!-- Desktop View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pasien</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Intervensi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Respon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($implementations as $implementation)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-slate-900">{{ $implementation->patient->name }}</div>
                                                <div class="text-sm text-slate-500">{{ $implementation->patient->medical_record_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900">{{ $implementation->nursingIntervention->intervention_name ?? 'N/A' }}</div>
                                        <div class="text-sm text-slate-500">{{ $implementation->nursingIntervention->siki_code ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-900">{{ $implementation->implementation_date->format('d/m/Y') }}</div>
                                        <div class="text-sm text-slate-500">{{ $implementation->implementation_time->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($implementation->status === 'completed') bg-green-100 text-green-800
                                            @elseif($implementation->status === 'in_progress') bg-yellow-100 text-yellow-800
                                            @elseif($implementation->status === 'planned') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($implementation->status === 'completed') Selesai
                                            @elseif($implementation->status === 'in_progress') Berlangsung
                                            @elseif($implementation->status === 'planned') Direncanakan
                                            @else Dihentikan @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900">{{ Str::limit($implementation->patient_response ?? 'Belum ada respon', 30) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('implementations.show', $implementation) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <ion-icon name="eye-outline" class="text-lg"></ion-icon>
                                            </a>
                                            @can('update', $implementation)
                                            <a href="{{ route('implementations.edit', $implementation) }}" 
                                               class="text-green-600 hover:text-green-900">
                                                <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                            </a>
                                            @endcan
                                            @can('delete', $implementation)
                                            <form method="POST" action="{{ route('implementations.destroy', $implementation) }}" 
                                                  onsubmit="return confirm('Yakin ingin menghapus implementasi ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="md:hidden">
                    @foreach($implementations as $implementation)
                        <div class="p-4 border-b border-slate-200">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">{{ $implementation->patient->name }}</h3>
                                    <p class="text-xs text-slate-500">{{ $implementation->patient->medical_record_number }}</p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($implementation->status === 'completed') bg-green-100 text-green-800
                                    @elseif($implementation->status === 'in_progress') bg-yellow-100 text-yellow-800
                                    @elseif($implementation->status === 'planned') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($implementation->status === 'completed') Selesai
                                    @elseif($implementation->status === 'in_progress') Berlangsung
                                    @elseif($implementation->status === 'planned') Direncanakan
                                    @else Dihentikan @endif
                                </span>
                            </div>
                            <p class="text-sm text-slate-600 mb-2">{{ $implementation->nursingIntervention->intervention_name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500 mb-3">{{ $implementation->implementation_date->format('d/m/Y H:i') }}</p>
                            
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('implementations.show', $implementation) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <ion-icon name="eye-outline" class="text-lg"></ion-icon>
                                </a>
                                @can('update', $implementation)
                                <a href="{{ route('implementations.edit', $implementation) }}" 
                                   class="text-green-600 hover:text-green-900">
                                    <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                </a>
                                @endcan
                                @can('delete', $implementation)
                                <form method="POST" action="{{ route('implementations.destroy', $implementation) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus implementasi ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $implementations->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <ion-icon name="document-text-outline" class="text-6xl text-slate-400 mb-4"></ion-icon>
                    <h3 class="text-lg font-medium text-slate-900 mb-2">Belum Ada Implementasi</h3>
                    <p class="text-slate-500 mb-6">Mulai dokumentasikan implementasi tindakan keperawatan.</p>
                    <a href="{{ route('implementations.create') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2">
                        <ion-icon name="add-outline"></ion-icon>
                        Tambah Implementasi
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
