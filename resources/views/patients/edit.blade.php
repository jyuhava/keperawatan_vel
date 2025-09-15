<x-dashboard-layout>
    <x-slot name="title">Edit Data Pasien - {{ $patient->name }}</x-slot>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('patients.show', $patient) }}" 
               class="text-gray-600 hover:text-gray-900 flex items-center">
                <ion-icon name="arrow-back" class="text-xl mr-2"></ion-icon>
                Kembali
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Data Pasien</h2>
                <p class="text-gray-600">{{ $patient->name }} - {{ $patient->medical_record_number }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 p-3 rounded-xl">
                                <ion-icon name="pencil" class="text-2xl text-white"></ion-icon>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">Edit Data Pasien</h3>
                                <p class="text-gray-600">{{ $patient->name }} - {{ $patient->medical_record_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('patients.update', $patient) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information Section -->
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <ion-icon name="person" class="text-blue-600 mr-2"></ion-icon>
                                Informasi Pribadi
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" required
                                           value="{{ old('name', $patient->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap pasien">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>
                                    <select name="gender" id="gender" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gender') border-red-500 @enderror">
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" required
                                           value="{{ old('date_of_birth', $patient->date_of_birth) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror">
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="tel" name="phone" id="phone"
                                           value="{{ old('phone', $patient->phone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                           placeholder="08xxxxxxxxxx">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="address" id="address" required rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                              placeholder="Masukkan alamat lengkap pasien">{{ old('address', $patient->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact Section -->
                        <div class="bg-red-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <ion-icon name="call" class="text-red-600 mr-2"></ion-icon>
                                Kontak Darurat
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Kontak Darurat
                                    </label>
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                           value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('emergency_contact_name') border-red-500 @enderror"
                                           placeholder="Nama keluarga/kerabat terdekat">
                                    @error('emergency_contact_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon Darurat
                                    </label>
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('emergency_contact_phone') border-red-500 @enderror"
                                           placeholder="08xxxxxxxxxx">
                                    @error('emergency_contact_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information Section -->
                        <div class="bg-green-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <ion-icon name="medical" class="text-green-600 mr-2"></ion-icon>
                                Informasi Medis
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Medical History -->
                                <div>
                                    <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">
                                        Riwayat Penyakit
                                    </label>
                                    <textarea name="medical_history" id="medical_history" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('medical_history') border-red-500 @enderror"
                                              placeholder="Riwayat penyakit yang pernah diderita">{{ old('medical_history', $patient->medical_history) }}</textarea>
                                    @error('medical_history')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Allergies -->
                                <div>
                                    <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alergi
                                    </label>
                                    <textarea name="allergies" id="allergies" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('allergies') border-red-500 @enderror"
                                              placeholder="Alergi obat, makanan, atau lainnya">{{ old('allergies', $patient->allergies) }}</textarea>
                                    @error('allergies')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Current Medications -->
                                <div class="md:col-span-2">
                                    <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-2">
                                        Obat yang Sedang Dikonsumsi
                                    </label>
                                    <textarea name="current_medications" id="current_medications" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_medications') border-red-500 @enderror"
                                              placeholder="Daftar obat yang sedang dikonsumsi pasien">{{ old('current_medications', $patient->current_medications) }}</textarea>
                                    @error('current_medications')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Admission Information Section -->
                        <div class="bg-blue-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <ion-icon name="calendar" class="text-blue-600 mr-2"></ion-icon>
                                Informasi Perawatan
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Admission Date -->
                                <div>
                                    <label for="admission_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Masuk <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="admission_date" id="admission_date" required
                                           value="{{ old('admission_date', $patient->admission_date) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admission_date') border-red-500 @enderror">
                                    @error('admission_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Discharge Date -->
                                <div>
                                    <label for="discharge_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Pulang
                                    </label>
                                    <input type="date" name="discharge_date" id="discharge_date"
                                           value="{{ old('discharge_date', $patient->discharge_date) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discharge_date') border-red-500 @enderror">
                                    @error('discharge_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                                        <option value="">Pilih status</option>
                                        <option value="active" {{ old('status', $patient->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="discharged" {{ old('status', $patient->status) == 'discharged' ? 'selected' : '' }}>Pulang</option>
                                        <option value="transferred" {{ old('status', $patient->status) == 'transferred' ? 'selected' : '' }}>Pindah</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Room Number -->
                                <div>
                                    <label for="room_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Kamar
                                    </label>
                                    <input type="text" name="room_number" id="room_number"
                                           value="{{ old('room_number', $patient->room_number) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('room_number') border-red-500 @enderror"
                                           placeholder="Contoh: 101A, 205B">
                                    @error('room_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Chief Complaint -->
                                <div class="md:col-span-2">
                                    <label for="chief_complaint" class="block text-sm font-medium text-gray-700 mb-2">
                                        Keluhan Utama
                                    </label>
                                    <textarea name="chief_complaint" id="chief_complaint" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('chief_complaint') border-red-500 @enderror"
                                              placeholder="Keluhan utama yang dialami pasien">{{ old('chief_complaint', $patient->chief_complaint) }}</textarea>
                                    @error('chief_complaint')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('patients.show', $patient) }}" 
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                                <ion-icon name="close" class="mr-2"></ion-icon>
                                Batal
                            </a>
                            
                            <button type="submit" 
                                    class="px-8 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-colors flex items-center">
                                <ion-icon name="save" class="mr-2"></ion-icon>
                                Update Data Pasien
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
