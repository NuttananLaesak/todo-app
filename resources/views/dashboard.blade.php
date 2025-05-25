<x-app-layout>
    <div class="py-6 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="font-semibold text-2xl text-white leading-tight text-center">
                📝 ยินดีต้อนรับสู่ระบบ Todo List
            </h2>

            <hr class="my-6 border-gray-300 dark:border-gray-600" />

            <div class="my-5 font-semibold sm:text-xs md:text-lg lg:text-xl text-white leading-tight text-center">
                เว็บไซต์สำหรับการในจดหรือบันทึกรายการที่เราต้องการจะทำ<br>
                ทุกคนเห็นรายการที่เราโพสเเละสามารถ Comment รายการของเราได้<br>
                มีเเค่ผสร้างเท่านี้ที่ลบรายการของตนเองได้<br>
                สามารถทดลองใช้ได้เเล้วตอนนี้<br>
                โดยกดปุ่มข้างล่างนี้ 👇
            </div>

            <div class="flex justify-center mt-4">
                <a href="{{ route('todos.index') }}"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-white font-semibold shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    ไปยังหน้ารายการ Todo List 👉
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
