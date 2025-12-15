<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pengumuman - SIPESAR</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .announcement-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .announcement-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .table-row:hover {
            background-color: #f0fdfa;
        }

        .status-active {
            background-color: #ccfbf1;
            color: #065f46;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .btn-action {
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 0;
            border-radius: 1rem;
            width: 90%;
            max-width: 600px;
            animation: slideDown 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Toast Styles */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInRight 0.3s ease-out;
        }

        .toast.success {
            background-color: #10b981;
            color: white;
        }

        .toast.error {
            background-color: #ef4444;
            color: white;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .toast.hiding {
            animation: slideOutRight 0.3s ease-out;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    @include('layouts.admin.header')

    <div class="flex pt-[80px]">

        @include('layouts.admin.sidebar')

        <main class="flex-1 ml-64 p-6">
            <!-- Page Title -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Kelola Pengumuman</h2>
                        <p class="text-gray-600 mt-1">Tambah, ubah, atau hapus pengumuman untuk siswa</p>
                    </div>
                </div>
            </div>

            <!-- Announcements Table Card -->
            <div class="announcement-card bg-white rounded-2xl shadow-lg border border-teal-100">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">Daftar Pengumuman</h3>
                    <button onclick="openAddModal()"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center space-x-2 btn-action">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Pengumuman Baru</span>
                    </button>
                </div>
                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($announcements as $announcement)
                                <tr class="table-row">
                                    <td class="px-6 py-4">{{ $announcement->title }}</td>
                                    <td class="px-6 py-4">{{ $announcement->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="{{ $announcement->status === 'active' ? 'status-active' : 'status-inactive' }} px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $announcement->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <button onclick="openEditModal({{ $announcement->id }})"
                                            class="text-blue-600 hover:text-blue-900">Edit</button> |
                                        <button onclick="confirmDelete({{ $announcement->id }})"
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada pengumuman. Klik "Tambah Pengumuman Baru" untuk menambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Add/Edit Announcement -->
    <div id="announcementModal" class="modal">
        <div class="modal-content">
            <div class="bg-teal-600 text-white px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <h3 id="modalTitle" class="text-xl font-semibold">Tambah Pengumuman Baru</h3>
                <button onclick="closeModal()" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="announcementForm" class="p-6">
                @csrf
                <input type="hidden" id="announcementId" name="id">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="Masukkan judul pengumuman">
                    <span class="text-red-500 text-sm hidden" id="titleError"></span>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Pengumuman <span
                            class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="6" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="Masukkan konten pengumuman"></textarea>
                    <span class="text-red-500 text-sm hidden" id="contentError"></span>
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span
                            class="text-red-500">*</span></label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                    <span class="text-red-500 text-sm hidden" id="statusError"></span>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-medium transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Modal Functions
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Pengumuman Baru';
            document.getElementById('announcementForm').reset();
            document.getElementById('announcementId').value = '';
            document.getElementById('formMethod').value = 'POST';
            clearErrors();
            document.getElementById('announcementModal').classList.add('show');
        }

        function openEditModal(id) {
            fetch(`/admin/announcements/${id}/edit`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Pengumuman';
                    document.getElementById('announcementId').value = data.id;
                    document.getElementById('title').value = data.title;
                    document.getElementById('content').value = data.content;
                    document.getElementById('status').value = data.status;
                    document.getElementById('formMethod').value = 'PUT';
                    clearErrors();
                    document.getElementById('announcementModal').classList.add('show');
                })
                .catch(error => {
                    showToast('Gagal memuat data pengumuman', 'error');
                });
        }

        function closeModal() {
            document.getElementById('announcementModal').classList.remove('show');
            document.getElementById('announcementForm').reset();
            clearErrors();
        }

        function clearErrors() {
            document.querySelectorAll('.text-red-500').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
        }

        // Form Submit Handler
        document.getElementById('announcementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors();

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';

            const formData = new FormData(this);
            const id = document.getElementById('announcementId').value;
            const method = document.getElementById('formMethod').value;

            let url = '/admin/announcements';
            if (method === 'PUT') {
                url = `/admin/announcements/${id}`;
                formData.append('_method', 'PUT');
            }

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeModal();
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showToast('Gagal menyimpan pengumuman', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Simpan';
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        for (let field in errors) {
                            const errorElement = document.getElementById(`${field}Error`);
                            if (errorElement) {
                                errorElement.textContent = errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        }
                    } else {
                        showToast('Terjadi kesalahan saat menyimpan data', 'error');
                    }
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Simpan';
                });
        });

        // Delete Confirmation
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
                deleteAnnouncement(id);
            }
        }

        function deleteAnnouncement(id) {
            fetch(`/admin/announcements/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showToast('Gagal menghapus pengumuman', 'error');
                    }
                })
                .catch(error => {
                    showToast('Terjadi kesalahan saat menghapus data', 'error');
                });
        }

        // Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icon = type === 'success' ?
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

            toast.innerHTML = `
                ${icon}
                <span class="font-medium">${message}</span>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('announcementModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
