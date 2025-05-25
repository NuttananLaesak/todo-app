<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                <h2 class="text-center py-5 font-semibold text-xl text-gray-800 leading-tight">
                    แก้ไข Comment
                </h2>
                <form method="POST" action="{{ route('admin.comments.update', $comment->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">ข้อความ</label>
                        <textarea name="content" rows="4" class="w-full border rounded px-3 py-2">{{ old('content', $comment->content) }}</textarea>
                        @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="{{ route('admin.user.comments', $comment->user_id) }}"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">ย้อนกลับ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
