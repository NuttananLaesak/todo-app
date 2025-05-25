<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-center my-5 font-semibold text-2xl text-gray-800 leading-tight">จัดการ User Todos</h2>

                <h3 class="text-lg font-bold mb-4">รายการ Todos ของผู้ใช้</h3>

                @if ($todos->isEmpty())
                    <p>ยังไม่มี Todo สำหรับผู้ใช้นี้</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($todos as $todo)
                            <li class="border p-4 rounded-md">
                                <h4 class="font-semibold text-lg">{{ $todo->title }}</h4>
                                <p>{{ $todo->description }}</p>

                                <div class="mt-3 flex space-x-4">
                                    <a href="{{ route('admin.todos.edit', $todo->id) }}"
                                        class="text-yellow-500 hover:underline">แก้ไข Todo</a>

                                    <form action="{{ route('admin.todos.destroy', $todo->id) }}" method="POST"
                                        onsubmit="return confirm('คุณแน่ใจว่าต้องการลบ Todo นี้หรือไม่?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">ลบ Todo</button>
                                    </form>
                                </div>

                                {{-- แสดง Comment --}}
                                @if ($todo->comments->isNotEmpty())
                                    <div class="mt-3 border-t pt-3">
                                        <h5 class="font-semibold">คอมเมนต์:</h5>
                                        <ul class="list-disc pl-5 space-y-2">
                                            @foreach ($todo->comments as $comment)
                                                <li class="flex justify-between items-center">
                                                    <div>
                                                        {{ $comment->content }}
                                                        <span class="text-xs text-gray-400">-
                                                            {{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                                            class="text-yellow-500 text-md hover:underline">แก้ไข</a>

                                                        <form
                                                            action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('ลบคอมเมนต์นี้ใช่ไหม?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-500 text-md hover:underline">ลบ</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="mt-3 text-gray-500">ไม่มีคอมเมนต์สำหรับ Todo นี้</p>
                                @endif
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
