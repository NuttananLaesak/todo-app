<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-center my-5 font-semibold text-2xl text-gray-800 leading-tight">จัดการ User Comments</h2>

                <h3 class="text-lg font-bold mb-4">คอมเมนต์ของผู้ใช้</h3>

                @if ($comments->isEmpty())
                    <p>ผู้ใช้นี้ยังไม่ได้แสดงความคิดเห็นใด ๆ</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($comments as $comment)
                            <li class="border p-4 rounded-md">
                                <div class="flex justify-between items-center">
                                    {{-- ด้านซ้าย: เนื้อหาคอมเมนต์ --}}
                                    <div>
                                        <p class="text-gray-800">{{ $comment->content }}</p>

                                        @if ($comment->image_path)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $comment->image_path) }}"
                                                    alt="Comment Image" class="w-32 h-32 object-cover rounded-md">
                                            </div>
                                        @endif

                                        <p class="text-sm text-gray-500 mt-2">
                                            ใน Todo: <strong>{{ $comment->todo->title ?? 'ลบไปแล้ว' }}</strong> <br>
                                            เวลา: {{ $comment->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>

                                    {{-- ด้านขวา: ปุ่มต่าง ๆ อยู่กลางแนวตั้ง --}}
                                    <div class="flex flex-row items-end space-x-3 ml-4">
                                        <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                            class="text-yellow-500 text-md hover:underline">แก้ไข</a>

                                        <form action="{{ route('admin.comments.destroy', $comment->id) }}"
                                            method="POST" onsubmit="return confirm('ลบคอมเมนต์นี้ใช่ไหม?');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 text-md hover:underline">ลบ</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">&larr;
                        กลับสู่แดชบอร์ด</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
