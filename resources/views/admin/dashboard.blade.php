<x-app-layout>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-center my-5 font-semibold text-2xl text-gray-800 leading-tight">Admin Dashboard</h2>
                <h3 class="text-lg font-bold mb-4">รายชื่อผู้ใช้</h3>
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">ชื่อ</th>
                            <th class="border px-4 py-2">อีเมล</th>
                            <th class="border px-4 py-2">Todos</th>
                            <th class="border px-4 py-2">Comments</th>
                            <th class="border px-4 py-2">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">{{ $user->todos_count }}</td>
                                <td class="border px-4 py-2">{{ $user->comments_count }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.user.todos', $user->id) }}"
                                        class="text-blue-500 hover:underline">Todos</a> |
                                    <a href="{{ route('admin.user.comments', $user->id) }}"
                                        class="text-green-500 hover:underline">Comments</a>

                                    @if ($user->role !== 'admin')
                                        | <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="text-yellow-600 hover:underline">แก้ไข</a>
                                        | <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            style="display:inline"
                                            onsubmit="return confirm('คุณแน่ใจว่าต้องการลบผู้ใช้นี้หรือไม่?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline bg-transparent border-none p-0 cursor-pointer">ลบ</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
