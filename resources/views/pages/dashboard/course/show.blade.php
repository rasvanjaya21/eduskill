<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Course &raquo; {{ $course->title }}
        </h2>

    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX DataTable
            var datatable = $('#crudTable').DataTable({
                devug: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '5%'
                    },
                    {
                        data: 'title',
                        name: 'title'

                    },
                    {
                        data: 'video_count',
                        name: 'video_count'

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%'
                    },
                ],
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-10">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class="flex-none text-center">
                            <div class="px-2 py-2 border border-black-500">
                                <img style="width: 320px; height:180px; object-fit:cover"
                                    src="{{ Storage::url($course->thumbnail) }}" alt="Photo {{ $course->title }}">
                            </div>

                            <div class="flex-row ml-3">
                                <a class="mt-3 inline-block border font-medium text-sm border-gray-500 bg-gray-500 text-white rounded-s-sm px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-700 hover:border-gray-700 focus:outline-none focus:shadow-outline change-poster-button"
                                    href="javascript:void(0);">
                                    Change Photo
                                </a>
                                <a class=" inline-block border font-medium text-sm border-blue-500 bg-blue-500 text-white rounded-s-sm px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-700 hover:border-blue-700 focus:outline-none focus:shadow-outline change-poster-button"
                                    href="{{ route('dashboard.course.edit', $course->id) }}">
                                    Edit Data
                                </a>
                            </div>

                            <!-- Modal -->
                        </div>


                        <div class="flex-grow ml-2">
                            <table class="table-auto w-full ml-4">
                                <tbody>
                                    <tr>
                                        <th class="border px-6 py-4 text-left">Judul Course</th>
                                        <td class="border px-6 py-4">{{ $course->title }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border px-6 py-4 text-left">Kategori</th>
                                        <td class="border px-6 py-4">{{ $course->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border px-6 py-4 text-left">Harga</th>
                                        <td class="border px-6 py-4">
                                            {{ $formattedAmount = 'Rp. ' . number_format($course->price) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border px-6 py-4 text-left">Deskripsi</th>
                                        <td class="border px-6 py-4">{{ $course->description }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div id="myModal" style="display:none"
                                class="modal fixed bg-gray-900 bg-opacity-50 inset-0 flex items-center justify-center z-50">
                                <div class="modal-content bg-white p-8 rounded shadow-md">
                                    <h2 class="text-2xl mb-4 font-bold">Change Thumbnail</h2>
                                    <form id="posterForm" action="{{ route('dashboard.course.update', $course->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <!-- Input field for image file -->
                                        <input type="file" name="thumbnail"
                                            class="border border-gray-500 px-2 py-2 rounded mb-4" accept="image/*"
                                            class="mb-4">
                                        <!-- Tombol submit dan cancel -->
                                        <div class="flex justify-end">
                                            <button type="button"
                                                class="px-4 py-2 bg-green-500 hover:bg-green-700 font-semibold text-white border rounded-md"
                                                onclick="validateForm()">Submit</button>
                                            <button type="button" onclick="closeModal()"
                                                class="px-4 py-2 bg-gray-400 text-white font-semibold ml-4 rounded hover:bg-gray-600">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <script>
                                function validateForm() {
                                    // Dapatkan elemen input file
                                    var fileInput = document.querySelector('input[name="thumbnail"]');

                                    // Periksa apakah input file kosong
                                    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                                        // Tampilkan alert jika input file kosong
                                        alert('Anda harus memilih file gambar sebelum mengirimkan formulir.');
                                    } else {
                                        // Kirim formulir jika input file terisi
                                        document.getElementById('posterForm').submit();
                                    }
                                }

                                // Mendapatkan modal element
                                var modal = document.getElementById('myModal');

                                // Mendapatkan tombol Change Poster element
                                var btn = document.querySelector('.change-poster-button');

                                // Ketika tombol Change Poster diklik, tampilkan modal
                                btn.addEventListener('click', function() {
                                    modal.style.display = '';
                                });

                                // Fungsi untuk menutup modal
                                function closeModal() {
                                    modal.style.display = 'none';
                                }
                            </script>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mb-10">
                <a href="{{ route('dashboard.course.lesson.create', $course->id) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Add Lesson
                </a>
            </div>
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sub Bab</th>
                                <th>Jumlah Video</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
