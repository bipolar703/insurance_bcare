@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">File Manager</h1>
            <div class="flex space-x-4">
                <button onclick="showUploadModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    <i class="fas fa-upload mr-2"></i>Upload File
                </button>
                <button onclick="showCreateDirModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    <i class="fas fa-folder-plus mr-2"></i>New Folder
                </button>
            </div>
        </div>

        <!-- Breadcrumbs -->
        <nav class="bg-gray-100 p-3 rounded mb-6">
            <ol class="list-reset flex text-gray-600">
                @foreach($breadcrumbs as $breadcrumb)
                    <li class="flex items-center">
                        @if(!$loop->first)
                            <svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        <a href="{{ route('file-manager.index', ['directory' => $breadcrumb['path']]) }}"
                           class="hover:text-blue-600 {{ $loop->last ? 'font-semibold' : '' }}">
                            {{ $breadcrumb['name'] }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>

        <!-- Directories -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Directories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($directories as $dir)
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded border hover:bg-gray-100">
                        <div class="flex items-center flex-1 min-w-0">
                            <i class="fas fa-folder text-yellow-500 mr-2"></i>
                            <a href="{{ route('file-manager.index', ['directory' => $dir]) }}"
                               class="text-blue-600 hover:text-blue-800 truncate">
                                {{ basename($dir) }}
                            </a>
                        </div>
                        <button onclick="deleteItem('{{ $dir }}')"
                                class="text-red-500 hover:text-red-700 ml-2"
                                title="Delete Directory">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @empty
                    <div class="col-span-3 text-gray-500 text-center py-4">
                        No directories found
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Files -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Files</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($files as $file)
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded border hover:bg-gray-100">
                        <div class="flex items-center flex-1 min-w-0">
                            <i class="fas fa-file text-gray-500 mr-2"></i>
                            <div class="truncate">
                                <div class="text-gray-700 truncate">{{ $file['name'] }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $file['size'] }} •
                                    {{ \Carbon\Carbon::createFromTimestamp($file['last_modified'])->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-2">
                            <button onclick="downloadFile('{{ $file['path'] }}')"
                                    class="text-blue-500 hover:text-blue-700"
                                    title="Download">
                                <i class="fas fa-download"></i>
                            </button>
                            <button onclick="deleteItem('{{ $file['path'] }}')"
                                    class="text-red-500 hover:text-red-700"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-gray-500 text-center py-4">
                        No files found
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 max-w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Upload File</h2>
            <button onclick="hideUploadModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                    Select File
                </label>
                <input type="file" name="file" id="file"
                       class="w-full p-2 border rounded focus:outline-none focus:border-blue-500">
                <p class="text-gray-600 text-xs mt-1">Maximum file size: 10MB</p>
            </div>
            <input type="hidden" name="directory" value="{{ $directory }}">
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="hideUploadModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Create Directory Modal -->
<div id="createDirModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 max-w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Create New Folder</h2>
            <button onclick="hideCreateDirModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="createDirForm">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="folderName">
                    Folder Name
                </label>
                <input type="text" name="path" id="folderName"
                       class="w-full p-2 border rounded focus:outline-none focus:border-blue-500"
                       placeholder="Enter folder name">
            </div>
            <input type="hidden" name="parent_directory" value="{{ $directory }}">
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="hideCreateDirModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }

    function hideUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
        document.getElementById('uploadForm').reset();
    }

    function showCreateDirModal() {
        document.getElementById('createDirModal').classList.remove('hidden');
        document.getElementById('createDirModal').classList.add('flex');
    }

    function hideCreateDirModal() {
        document.getElementById('createDirModal').classList.add('hidden');
        document.getElementById('createDirModal').classList.remove('flex');
        document.getElementById('createDirForm').reset();
    }

    document.getElementById('uploadForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("file-manager.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();
            if (response.ok) {
                window.location.reload();
            } else {
                alert(result.error || 'Upload failed');
            }
        } catch (error) {
            alert('Upload failed: ' + error.message);
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Upload';
        }
    });

    document.getElementById('createDirForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';

        try {
            const formData = new FormData(this);
            const parentDir = formData.get('parent_directory');
            const newDirName = formData.get('path');
            const path = parentDir ? `${parentDir}/${newDirName}` : newDirName;

            const response = await fetch('{{ route("file-manager.create-directory") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ path })
            });

            const result = await response.json();
            if (response.ok) {
                window.location.reload();
            } else {
                alert(result.error || 'Failed to create directory');
            }
        } catch (error) {
            alert('Failed to create directory: ' + error.message);
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Create';
        }
    });

    async function deleteItem(path) {
        if (!confirm('Are you sure you want to delete this item?')) {
            return;
        }

        try {
            const response = await fetch('{{ route("file-manager.delete") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ path })
            });

            const result = await response.json();
            if (response.ok) {
                window.location.reload();
            } else {
                alert(result.error || 'Delete failed');
            }
        } catch (error) {
            alert('Delete failed: ' + error.message);
        }
    }

    function downloadFile(path) {
        window.location.href = `{{ url('storage') }}/${path}`;
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target.id === 'uploadModal') {
            hideUploadModal();
        } else if (e.target.id === 'createDirModal') {
            hideCreateDirModal();
        }
    });

    // Handle escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideUploadModal();
            hideCreateDirModal();
        }
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
