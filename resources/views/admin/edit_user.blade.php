<x-app-layout>
    <h2 class="text-center mt-5 font-semibold text-2xl text-gray-800 leading-tight">แก้ไขข้อมูลผู้ใช้</h2>
    <div class="max-w-3xl mx-auto py-5">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">ชื่อ</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700">อีเมล</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700">รหัสผ่านใหม่
                    (ถ้าต้องการเปลี่ยน)</label>
                <input type="password" name="password" id="password"
                    class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" autocomplete="new-password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation"
                    class="block font-medium text-sm text-gray-700">ยืนยันรหัสผ่านใหม่</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" autocomplete="new-password">
            </div>

            <div class="flex justify-center space-x-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">บันทึก</button>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">ยกเลิก</a>
            </div>
        </form>
    </div>
</x-app-layout>
