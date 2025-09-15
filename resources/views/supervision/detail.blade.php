<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <a href="{{ route('supervision.dashboard') }}" class="text-blue-600 hover:text-blue-700 mr-3">
                            <ion-icon name="arrow-back" class="text-xl"></ion-icon>
                        </a>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Supervisi</h1>
                    </div>
                    <p class="text-gray-600">Review dan berikan feedback untuk pekerjaan mahasiswa</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 text-xs font-medium rounded-full
                        @if($log->status === 'viewed') bg-blue-100 text-blue-800
                        @elseif($log->status === 'reviewed') bg-purple-100 text-purple-800
                        @elseif($log->status === 'approved') bg-green-100 text-green-800
                        @elseif($log->status === 'needs_revision') bg-orange-100 text-orange-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Student Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mahasiswa</h3>
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr($log->student->name, 0, 2) }}
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $log->student->name }}</h4>
                            <p class="text-gray-500">{{ $log->student->student_id }} • {{ $log->student->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Work Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ ucfirst($log->supervise_type) }}</h3>
                        <span class="text-sm text-gray-500">ID: {{ $log->supervise_id }}</span>
                    </div>
                    
                    @if($record)
                        @switch($log->supervise_type)
                            @case('assessment')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pasien</label>
                                        <p class="text-gray-900">{{ $context['patient']->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan Utama</label>
                                        <p class="text-gray-900">{{ $record->chief_complaint ?? 'Tidak ada data' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Riwayat Penyakit</label>
                                        <p class="text-gray-900">{{ $record->present_illness ?? 'Tidak ada data' }}</p>
                                    </div>
                                    @if($record->vital_signs)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanda Vital</label>
                                            <div class="bg-gray-50 rounded p-3">
                                                <pre class="text-sm">{{ json_encode($record->vital_signs, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @break
                                
                            @case('diagnosis')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Diagnosis</label>
                                        <p class="text-gray-900 font-medium">{{ $record->diagnosis_title }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Definisi</label>
                                        <p class="text-gray-900">{{ $record->definition }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanda & Gejala</label>
                                        <div class="bg-gray-50 rounded p-3">
                                            @foreach($record->signs_symptoms as $symptom)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2 mb-2">{{ $symptom }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @break
                                
                            @case('intervention')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Intervensi</label>
                                        <p class="text-gray-900 font-medium">{{ $record->intervention_title }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Definisi</label>
                                        <p class="text-gray-900">{{ $record->definition }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Aktivitas</label>
                                        <div class="bg-gray-50 rounded p-3">
                                            <ul class="space-y-1">
                                                @foreach($record->activities as $activity)
                                                    <li class="flex items-start">
                                                        <ion-icon name="checkmark" class="text-green-600 mt-1 mr-2 flex-shrink-0"></ion-icon>
                                                        <span class="text-sm">{{ $activity }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @break
                                
                            @case('implementation')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pelaksanaan</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($record->completion_status === 'completed') bg-green-100 text-green-800
                                            @elseif($record->completion_status === 'partially_completed') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $record->completion_status)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode yang Digunakan</label>
                                        <p class="text-gray-900">{{ $record->method_used ?? 'Tidak ada catatan' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Respon Pasien</label>
                                        <p class="text-gray-900">{{ $record->patient_response ?? 'Tidak ada catatan' }}</p>
                                    </div>
                                    @if($record->student_reflection)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Refleksi Mahasiswa</label>
                                            <div class="bg-blue-50 rounded p-3">
                                                <p class="text-gray-900">{{ $record->student_reflection }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @break
                                
                            @case('evaluation')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Progress Keseluruhan</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($record->overall_progress === 'exceeded' || $record->overall_progress === 'met') bg-green-100 text-green-800
                                            @elseif($record->overall_progress === 'partially_met') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $record->overall_progress)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Progress</label>
                                        <p class="text-gray-900">{{ $record->progress_notes }}</p>
                                    </div>
                                    @if($record->student_analysis)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Analisis Mahasiswa</label>
                                            <div class="bg-blue-50 rounded p-3">
                                                <p class="text-gray-900">{{ $record->student_analysis }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @break
                        @endswitch
                    @else
                        <div class="text-center py-8">
                            <ion-icon name="alert-circle" class="text-4xl text-gray-400 mb-2"></ion-icon>
                            <p class="text-gray-500">Data tidak ditemukan</p>
                        </div>
                    @endif
                </div>

                <!-- Previous Feedback -->
                @if($log->supervisor_notes || $log->feedback_points)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Feedback Sebelumnya</h3>
                    @if($log->supervisor_notes)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Supervisor</label>
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-gray-900">{{ $log->supervisor_notes }}</p>
                            </div>
                        </div>
                    @endif
                    @if($log->feedback_points)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin Feedback</label>
                            <div class="bg-gray-50 rounded p-3">
                                <ul class="space-y-1">
                                    @foreach($log->feedback_points as $point)
                                        <li class="flex items-start">
                                            <ion-icon name="arrow-forward" class="text-gray-600 mt-1 mr-2 flex-shrink-0"></ion-icon>
                                            <span class="text-sm">{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if($log->grade)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai</label>
                            <span class="text-2xl font-bold text-blue-600">{{ $log->grade }}/100</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Supervisi</h3>
                    
                    <form action="{{ route('supervision.update', $log->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Action Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan</label>
                            <select name="action" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih tindakan...</option>
                                <option value="review">Review & Beri Feedback</option>
                                <option value="approve">Setujui</option>
                                <option value="request_revision">Minta Revisi</option>
                                <option value="reject">Tolak</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea name="supervisor_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Berikan catatan dan feedback..."></textarea>
                        </div>

                        <!-- Grade -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-100)</label>
                            <input type="number" name="grade" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="85">
                        </div>

                        <!-- Revision Notes (conditional) -->
                        <div id="revision-notes" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Revisi</label>
                            <textarea name="revision_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Jelaskan apa yang perlu direvisi..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan
                        </button>
                    </form>

                    <!-- Timeline -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Timeline</h4>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="h-2 w-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-900">Submitted</p>
                                    <p class="text-xs text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            @if($log->viewed_at)
                            <div class="flex items-start">
                                <div class="h-2 w-2 bg-green-600 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-900">Viewed</p>
                                    <p class="text-xs text-gray-500">{{ $log->viewed_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                            @if($log->reviewed_at)
                            <div class="flex items-start">
                                <div class="h-2 w-2 bg-purple-600 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-900">Reviewed</p>
                                    <p class="text-xs text-gray-500">{{ $log->reviewed_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                            @if($log->approved_at)
                            <div class="flex items-start">
                                <div class="h-2 w-2 bg-green-600 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-900">Approved</p>
                                    <p class="text-xs text-gray-500">{{ $log->approved_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const actionSelect = document.querySelector('select[name="action"]');
            const revisionNotesDiv = document.getElementById('revision-notes');
            
            actionSelect.addEventListener('change', function() {
                if (this.value === 'request_revision') {
                    revisionNotesDiv.classList.remove('hidden');
                } else {
                    revisionNotesDiv.classList.add('hidden');
                }
            });
        });
    </script>
</x-dashboard-layout>
