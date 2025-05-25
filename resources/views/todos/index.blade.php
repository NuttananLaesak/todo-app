<x-app-layout>
    <div class="py-6 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="font-semibold text-2xl text-white leading-tight text-center">
                📝 รายการ Todo List
            </h2>
            <form id="todo-form" class="space-y-5">
                @csrf
                <div>
                    <label for="todo-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        สิ่งที่ต้องทำ
                    </label>
                    <input type="text" id="todo-title" name="title" placeholder="เช่น อ่านหนังสือ..." required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div>
                    <label for="todo-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        รายละเอียดเพิ่มเติม
                    </label>
                    <textarea id="todo-description" name="description" rows="3" placeholder="รายละเอียดของสิ่งที่ต้องทำ..."
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-white font-semibold shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    เพิ่มรายการ
                </button>
            </form>

            <hr class="my-6 border-gray-300 dark:border-gray-600" />

            <ul id="todo-list" class="space-y-4">
                @forelse ($todos as $todo)
                    <li
                        class="flex flex-col bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="mb-3 md:mb-0">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $todo->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 mt-1 break-all">{{ $todo->description }}</p>
                            <span
                                class="inline-block my-2 px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full dark:bg-indigo-900 dark:text-indigo-300">
                                โดย {{ $todo->user->name }}
                            </span>
                            @if (auth()->id() === $todo->user_id)
                                <div class="flex space-x-2 mt-2">
                                    <button data-id="{{ $todo->id }}"
                                        class="edit-btn px-3 py-1 text-sm font-medium text-yellow-700 border border-yellow-700 rounded hover:bg-yellow-700 hover:text-white transition">
                                        แก้ไข
                                    </button>
                                    <button data-id="{{ $todo->id }}"
                                        class="delete-btn px-3 py-1 text-sm font-medium text-red-700 border border-red-700 rounded hover:bg-red-700 hover:text-white transition">
                                        ลบ
                                    </button>
                                </div>
                            @endif

                            <hr class="my-6 border-gray-300 dark:border-gray-600" />

                            <form class="comment-form mt-1 space-y-2" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                                <textarea name="content" rows="3"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm text-gray-100"
                                    placeholder="แสดงความคิดเห็น..."></textarea>

                                <div class="relative flex items-center space-x-2">
                                    <label for="image-upload-{{ $todo->id }}"
                                        class="cursor-pointer bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-medium transition">
                                        อัปโหลดรูปภาพ
                                    </label>
                                    <span id="filename-display-{{ $todo->id }}"
                                        class="text-sm text-white truncate max-w-xs"></span>
                                    <input type="file" id="image-upload-{{ $todo->id }}" name="image"
                                        accept="image/*"
                                        class="absolute left-0 top-0 w-full h-full opacity-0 cursor-pointer" />
                                </div>

                                <button type="submit"
                                    class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">
                                    ส่งความคิดเห็น
                                </button>
                            </form>

                            <hr class="my-6 border-gray-300 dark:border-gray-600" />
                            <ul id="comment-list-{{ $todo->id }}" class="mt-3 space-y-2">
                                @foreach ($todo->comments as $index => $comment)
                                    <li
                                        class="comment-item-{{ $todo->id }} {{ $index > 0 ? 'hidden' : '' }} bg-white dark:bg-gray-800 rounded p-2 shadow">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $comment->user->name }}</div>
                                        <div class="text-gray-700 dark:text-gray-300 text-sm">{{ $comment->content }}
                                        </div>
                                        @if ($comment->image_path)
                                            <img src="{{ asset('storage/' . $comment->image_path) }}"
                                                class="mt-2 w-32 rounded mx-auto">
                                        @endif
                                        <div class="text-center text-xs text-gray-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            @if ($todo->comments->count() > 1)
                                <button onclick="toggleComments({{ $todo->id }})"
                                    id="toggle-btn-{{ $todo->id }}"
                                    class="mt-2 text-sm text-blue-500 hover:underline">
                                    แสดงความคิดเห็นทั้งหมด
                                </button>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="text-center text-gray-500 dark:text-gray-400">
                        ยังไม่มีรายการ Todo ครับ
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    @push('scripts')
        <script>
            function bindFileInputs() {
                document.querySelectorAll('input[type="file"]').forEach(input => {
                    if (!input.dataset.bound) {
                        input.dataset.bound = "true";
                        input.addEventListener('change', function() {
                            const span = this.closest('form').querySelector('span[id^="filename-display"]');
                            if (this.files.length > 0) {
                                span.textContent = this.files[0].name;
                            } else {
                                span.textContent = '';
                            }
                        });
                    }
                });
            }

            function bindCommentForms() {
                document.querySelectorAll('.comment-form').forEach(form => {
                    if (!form.dataset.bound) {
                        form.dataset.bound = true;
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            fetch("{{ route('comments.store') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value
                                    },
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (!data.comment) {
                                        console.error('ไม่สามารถเพิ่มคอมเมนต์ได้', data);
                                        return;
                                    }
                                    const comment = data.comment;
                                    const target = document.getElementById(
                                        `comment-list-${comment.todo_id}`);
                                    const html = `
                                    <li class="bg-white dark:bg-gray-800 rounded p-2 shadow">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">${comment.user.name}</div>
                                        <div class="text-gray-700 dark:text-gray-300 text-sm">${comment.content ?? ''}</div>
                                        ${comment.image_path ? `<img src="/storage/${comment.image_path}" class="mt-2 w-32 rounded mx-auto">` : ''}
                                        <div class="text-center text-xs text-gray-400">เมื่อสักครู่</div>
                                        </li>`;
                                    target.insertAdjacentHTML('afterbegin', html);
                                    this.reset();
                                })
                                .catch(err => console.error("เกิดข้อผิดพลาด:", err));
                        });
                    }
                });
            }

            function toggleComments(todoId) {
                const comments = document.querySelectorAll(`.comment-item-${todoId}`);
                const btn = document.getElementById(`toggle-btn-${todoId}`);
                const hidden = Array.from(comments).some(el => el.classList.contains('hidden'));
                comments.forEach((el, index) => {
                    if (index === 0) return;
                    el.classList.toggle('hidden', !hidden);
                });
                btn.textContent = hidden ? 'ย่อความคิดเห็น' : 'แสดงความคิดเห็นทั้งหมด';
            }


            function bindEditButtons() {
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    if (!btn.dataset.bound) {
                        btn.dataset.bound = true;
                        btn.addEventListener('click', function() {
                            const todoId = this.dataset.id;
                            fetch(`/todos/${todoId}`)
                                .then(res => res.json())
                                .then(data => {
                                    const todo = data.todo;
                                    document.getElementById('edit-id').value = todo.id;
                                    document.getElementById('edit-title').value = todo.title;
                                    document.getElementById('edit-description').value = todo.description ??
                                        '';
                                    document.getElementById('edit-modal').classList.remove('hidden');
                                });
                        });
                    }
                });
            }

            bindCommentForms();
            bindEditButtons();
            bindFileInputs();

            document.addEventListener('click', function(e) {
                if (e.target.tagName === 'IMG' && e.target.closest('li')?.classList?.contains('comment-item-' + e.target
                        .closest('ul')?.id?.replace('comment-list-', ''))) {
                    const modal = document.getElementById('image-modal');
                    const preview = document.getElementById('image-preview');
                    preview.src = e.target.src;
                    modal.classList.remove('hidden');
                }
            });
            document.getElementById('close-image-modal').addEventListener('click', function() {
                document.getElementById('image-modal').classList.add('hidden');
                document.getElementById('image-preview').src = '';
            });
            document.getElementById('image-modal').addEventListener('click', function(e) {
                if (e.target.id === 'image-modal') {
                    e.currentTarget.classList.add('hidden');
                    document.getElementById('image-preview').src = '';
                }
            });


            document.getElementById('todo-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const title = document.getElementById('todo-title').value;
                const description = document.getElementById('todo-description').value;
                const token = document.querySelector('input[name="_token"]').value;
                fetch("{{ route('todos.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            title,
                            description
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.todo) {
                            console.error("ไม่พบ todo ใน response:", data);
                            return;
                        }

                        const todo = data.todo;
                        const html = `<li class="flex flex-col bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <div class="mb-3 md:mb-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">${todo.title}</h3>
                                ${todo.description ? `<p class="text-gray-600 dark:text-gray-300 mt-1 break-all">${todo.description}</p>` : ''}
                                <span class="inline-block my-2 px-3 py-1 text-sm font-medium bg-indigo-100 text-indigo-800 rounded-full dark:bg-indigo-900 dark:text-indigo-300">โดย ${todo.user.name}</span>
                                <div class="flex space-x-2 mt-2">
                                    <button data-id="${todo.id}" class="edit-btn px-3 py-1 text-sm font-medium text-yellow-700 border border-yellow-700 rounded hover:bg-yellow-700 hover:text-white transition">
                                        แก้ไข
                                    </button>
                                    <button data-id="${todo.id}"class="delete-btn px-3 py-1 text-sm font-medium text-red-700 border border-red-700 rounded hover:bg-red-700 hover:text-white transition">
                                        ลบ
                                    </button>
                                </div>
                            <hr class="my-6 border-gray-300 dark:border-gray-600" />
                                <form class="comment-form mt-1 space-y-2" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="${token}">
                                    <input type="hidden" name="todo_id" value="${todo.id}">
                                    <textarea name="content" rows="3"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm text-gray-100"
                                    placeholder="แสดงความคิดเห็น..."></textarea>
                                    <input type="file" name="image" accept="image/*"
                                    class="block w-full text-sm text-gray-300 dark:text-gray-400">
                                    <button type="submit"
                                    class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                                    ส่งความคิดเห็น
                                    </button>
                                </form>
                                <ul id="comment-list-${todo.id}" class="mt-3 space-y-2"></ul>
                            </div>
                        </li>`;

                        const container = document.getElementById('todo-list');
                        container.insertAdjacentHTML('afterbegin', html);

                        document.getElementById('todo-title').value = '';
                        document.getElementById('todo-description').value = '';

                        bindCommentForms();
                        bindEditButtons();
                        bindFileInputs();
                    })
                    .catch(error => {
                        console.error("เกิดข้อผิดพลาด:", error);
                    });
            });

            document.getElementById('todo-list').addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-btn')) {
                    const id = e.target.getAttribute('data-id');
                    const token = document.querySelector('input[name="_token"]').value;
                    const confirmed = confirm("คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?");
                    if (!confirmed) return;
                    fetch(`/todos/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            }
                        })
                        .then(response => response.json())
                        .then(() => {
                            e.target.closest('li').remove();
                        });
                }
            });
            document.getElementById('cancel-edit').addEventListener('click', function() {
                document.getElementById('edit-modal').classList.add('hidden');
            });
            document.getElementById('edit-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('edit-id').value;
                const title = document.getElementById('edit-title').value;
                const description = document.getElementById('edit-description').value;
                const token = document.querySelector('input[name="_token"]').value;
                fetch(`/todos/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            title,
                            description
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-modal').classList.add('hidden');
                        location.reload();
                    });
            });
        </script>
    @endpush

    <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">แก้ไข Todo</h3>
                <form id="edit-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div>
                        <label for="edit-title"
                            class="block text-sm text-gray-700 dark:text-gray-300">ชื่อเรื่อง</label>
                        <input type="text" name="title" id="edit-title" required
                            class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300">
                    </div>
                    <div>
                        <label for="edit-description"
                            class="block text-sm text-gray-700 dark:text-gray-300">รายละเอียด</label>
                        <textarea name="description" id="edit-description" rows="3"
                            class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancel-edit"
                            class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">ยกเลิก</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="image-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 ">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="relative">
                <img id="image-preview" src="" class="max-h-[90vh] max-w-[90vw] rounded shadow-lg" />
                <button id="close-image-modal"
                    class="absolute top-2 right-2 bg-white text-black rounded-full p-1 hover:bg-gray-200">
                    ✖
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
