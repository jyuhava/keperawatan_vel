<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <ion-icon name="create-outline" class="mr-2"></ion-icon>
                    Edit
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- User Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="flex-shrink-0 h-20 w-20">
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                <ion-icon name="person-outline" class="text-3xl text-gray-600"></ion-icon>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                       ($user->role == 'dosen' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->email_verified_at ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Personal Information</h4>
                            <div class="space-y-2">
                                @if($user->student_id)
                                    <div>
                                        <span class="font-medium text-gray-700">Student ID:</span>
                                        <span class="text-gray-900">{{ $user->student_id }}</span>
                                    </div>
                                @endif
                                @if($user->phone)
                                    <div>
                                        <span class="font-medium text-gray-700">Phone:</span>
                                        <span class="text-gray-900">{{ $user->phone }}</span>
                                    </div>
                                @endif
                                @if($user->address)
                                    <div>
                                        <span class="font-medium text-gray-700">Address:</span>
                                        <span class="text-gray-900">{{ $user->address }}</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-medium text-gray-700">Member since:</span>
                                    <span class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Quick Actions</h4>
                            <div class="space-y-2">
                                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm font-medium rounded-md
                                        {{ $user->email_verified_at ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        <ion-icon name="{{ $user->email_verified_at ? 'ban' : 'checkmark' }}-outline" class="mr-2"></ion-icon>
                                        {{ $user->email_verified_at ? 'Deactivate User' : 'Activate User' }}
                                    </button>
                                </form>
                                
                                <button onclick="document.getElementById('passwordModal').style.display='block'" 
                                        class="w-full text-left px-3 py-2 text-sm font-medium rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200">
                                    <ion-icon name="key-outline" class="mr-2"></ion-icon>
                                    Reset Password
                                </button>

                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                                class="w-full text-left px-3 py-2 text-sm font-medium rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                            <ion-icon name="trash-outline" class="mr-2"></ion-icon>
                                            Delete User
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            @if(!empty($stats))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-4">
                            @if($user->isMahasiswa())
                                Student Activity Statistics
                            @elseif($user->isDosen())
                                Supervisor Statistics
                            @endif
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            @foreach($stats as $key => $value)
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">{{ $value }}</div>
                                    <div class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $key) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Password Reset Modal -->
    <div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display:none;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Reset Password</h3>
            <form method="POST" action="{{ route('users.update-password', $user) }}">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="password" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           required>
                </div>

                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="password_confirmation" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           required>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('passwordModal').style.display='none'" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
