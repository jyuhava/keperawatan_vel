<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <ion-icon name="clipboard-outline" class="text-2xl text-blue-600 mr-3"></ion-icon>
                        <h1 class="text-3xl font-bold text-gray-900">Dashboard Supervisi</h1>
                    </div>
                    <p class="text-gray-600">Kelola dan evaluasi pekerjaan mahasiswa</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('supervision.monitor') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <ion-icon name="people" class="mr-2"></ion-icon>
                        Monitor Mahasiswa
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Supervisi</p>
                        <p class="text-3xl font-bold">{{ $stats['total_supervised'] }}</p>
                    </div>
                    <ion-icon name="document-text" class="text-4xl text-blue-200"></ion-icon>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Menunggu Review</p>
                        <p class="text-3xl font-bold">{{ $stats['pending_reviews'] }}</p>
                    </div>
                    <ion-icon name="time" class="text-4xl text-yellow-200"></ion-icon>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Perlu Revisi</p>
                        <p class="text-3xl font-bold">{{ $stats['needs_revision'] }}</p>
                    </div>
                    <ion-icon name="refresh" class="text-4xl text-orange-200"></ion-icon>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Disetujui Hari Ini</p>
                        <p class="text-3xl font-bold">{{ $stats['approved_today'] }}</p>
                    </div>
                    <ion-icon name="checkmark-circle" class="text-4xl text-green-200"></ion-icon>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Pending Reviews -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Menunggu Review</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ count($pendingItems) }} items
                        </span>
                    </div>
                    <div class="p-6">
                        @forelse($pendingItems as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg mb-4 hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center mb-1">
                                    <div class="h-8 w-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xs mr-3">
                                        {{ substr($item->student_name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->student_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->student_id }}</p>
                                    </div>
                                </div>
                                <div class="ml-11">
                                    <p class="text-sm text-gray-700 font-medium">{{ $item->type }}: {{ $item->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->viewed_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('supervision.detail', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-colors">
                                <ion-icon name="eye" class="mr-1"></ion-icon>
                                Review
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <ion-icon name="checkmark-done" class="text-6xl text-gray-300 mb-4"></ion-icon>
                            <p class="text-gray-500">Tidak ada item yang menunggu review</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            @forelse($recentActivities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="h-8 w-8 bg-gradient-to-br 
                                    @if($activity->status === 'approved') from-green-400 to-green-600
                                    @elseif($activity->status === 'rejected') from-red-400 to-red-600
                                    @else from-blue-400 to-blue-600 @endif
                                    rounded-full flex items-center justify-center flex-shrink-0">
                                    @if($activity->status === 'approved')
                                        <ion-icon name="checkmark" class="text-white text-sm"></ion-icon>
                                    @elseif($activity->status === 'rejected')
                                        <ion-icon name="close" class="text-white text-sm"></ion-icon>
                                    @else
                                        <ion-icon name="eye" class="text-white text-sm"></ion-icon>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity->student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ ucfirst($activity->supervise_type) }} - {{ ucfirst($activity->status) }}</p>
                                    <p class="text-xs text-gray-400">{{ $activity->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('supervision.monitor') }}" class="block w-full text-left p-3 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <ion-icon name="people" class="text-purple-600 mr-3"></ion-icon>
                                <span class="text-sm font-medium text-gray-900">Monitor Semua Mahasiswa</span>
                            </div>
                        </a>
                        <a href="#" class="block w-full text-left p-3 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <ion-icon name="bar-chart" class="text-purple-600 mr-3"></ion-icon>
                                <span class="text-sm font-medium text-gray-900">Laporan Progress</span>
                            </div>
                        </a>
                        <a href="#" class="block w-full text-left p-3 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <ion-icon name="download" class="text-purple-600 mr-3"></ion-icon>
                                <span class="text-sm font-medium text-gray-900">Export Data</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Progress Summary -->
        @if(count($studentProgress) > 0)
        <div class="mt-12">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Ringkasan Progress Mahasiswa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disetujui</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perlu Revisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Nilai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($studentProgress as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($student->name, 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $student->student_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $student->total_submissions }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $student->approved_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->revision_count > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            {{ $student->revision_count }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">0</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($student->avg_grade)
                                        <span class="font-medium">{{ number_format($student->avg_grade, 1) }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('supervision.student', $student->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-dashboard-layout>
