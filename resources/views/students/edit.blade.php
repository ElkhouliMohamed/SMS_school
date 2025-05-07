@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Student</h1>
    <form action="{{ route('students.update', $student) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="first_name" class="block text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" class="w-full border rounded p-2" value="{{ old('first_name', $student->first_name) }}">
            @error('first_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="last_name" class="block text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="w-full border rounded p-2" value="{{ old('last_name', $student->last_name) }}">
            @error('last_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full border rounded p-2" value="{{ old('email', $student->user->email) }}">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone" class="w-full border rounded p-2" value="{{ old('phone', $student->phone) }}">
            @error('phone')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address</label>
            <input type="text" name="address" id="address" class="w-full border rounded p-2" value="{{ old('address', $student->address) }}">
            @error('address')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="city" class="block text-gray-700">City</label>
            <input type="text" name="city" id="city" class="w-full border rounded p-2" value="{{ old('city', $student->city) }}">
            @error('city')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="postal_code" class="block text-gray-700">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code" class="w-full border rounded p-2" value="{{ old('postal_code', $student->postal_code) }}">
            @error('postal_code')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="country" class="block text-gray-700">Country</label>
            <input type="text" name="country" id="country" class="w-full border rounded p-2" value="{{ old('country', $student->country) }}">
            @error('country')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-gray-700">Gender</label>
            <select name="gender" id="gender" class="w-full border rounded p-2">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="marital_status" class="block text-gray-700">Marital Status</label>
            <input type="text" name="marital_status" id="marital_status" class="w-full border rounded p-2" value="{{ old('marital_status', $student->marital_status) }}">
            @error('marital_status')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="nationality" class="block text-gray-700">Nationality</label>
            <input type="text" name="nationality" id="nationality" class="w-full border rounded p-2" value="{{ old('nationality', $student->nationality) }}">
            @error('nationality')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="identity_number" class="block text-gray-700">Identity Number</label>
            <input type="text" name="identity_number" id="identity_number" class="w-full border rounded p-2" value="{{ old('identity_number', $student->identity_number) }}">
            @error('identity_number')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="guardian_name" class="block text-gray-700">Guardian Name</label>
            <input type="text" name="guardian_name" id="guardian_name" class="w-full border rounded p-2" value="{{ old('guardian_name', $student->guardian_name) }}">
            @error('guardian_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="guardian_phone" class="block text-gray-700">Guardian Phone</label>
            <input type="text" name="guardian_phone" id="guardian_phone" class="w-full border rounded p-2" value="{{ old('guardian_phone', $student->guardian_phone) }}">
            @error('guardian_phone')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="guardian_address" class="block text-gray-700">Guardian Address</label>
            <input type="text" name="guardian_address" id="guardian_address" class="w-full border rounded p-2" value="{{ old('guardian_address', $student->guardian_address) }}">
            @error('guardian_address')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="birth_date" class="block text-gray-700">Birth Date</label>
            <input type="date" name="birth_date" id="birth_date" class="w-full border rounded p-2" value="{{ old('birth_date', $student->birth_date) }}">
            @error('birth_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="class_id" class="block text-gray-700">Class</label>
            <select name="class_id" id="class_id" class="w-full border rounded p-2">
                <option value="">Select Class</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="guardian_ids" class="block text-gray-700">Guardians</label>
            <select name="guardian_ids[]" id="guardian_ids" class="w-full border rounded p-2" multiple>
                @foreach ($guardians as $guardian)
                    <option value="{{ $guardian->id }}" {{ $student->guardians->contains($guardian->id) ? 'selected' : '' }}>{{ $guardian->first_name }} {{ $guardian->last_name }}</option>
                @endforeach
            </select>
            @error('guardian_ids')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" class="w-full border rounded p-2">
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Student</button>
    </form>
@endsection