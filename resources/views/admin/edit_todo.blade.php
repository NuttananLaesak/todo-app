<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                <h2 class="text-center py-5 font-semibold text-xl text-gray-800 leading-tight">
                    แก้ไข Todo
                </h2>
                <form method="POST" action="{{ route('admin.todos.update', $todo->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">ชื่อเรื่อง</label>
                        <input type="text" name="title" value="{{ old('title', $todo->title) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">รายละเอียด</label>
                        <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $todo->description) }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="{{ route('admin.user.todos', $todo->user_id) }}"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">ย้อนกลับ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
