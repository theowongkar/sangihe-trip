<div class="grid grid-cols-1 gap-4">

    <div x-data="{
        fileUrl: '{{ isset($article) && $article->image_path ? asset('storage/' . $article->image_path) : '' }}',
        handleFile(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.fileUrl = URL.createObjectURL(file);
            // Remove old_image_path value when new file is selected
            if ($refs.oldImageInput) {
                $refs.oldImageInput.value = '';
            }
        },
        removeFile() {
            this.fileUrl = '';
            $refs.fileInput.value = '';
            // Remove old_image_path value when file is removed
            if ($refs.oldImageInput) {
                $refs.oldImageInput.value = '';
            }
        }
    }">
        <label for="image_path" class="block mb-1 text-sm font-medium text-gray-700">Thumbnail
            Artikel</label>
        <div class="relative flex items-center justify-center border-2 border-dashed rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 border-blue-300 overflow-hidden"
            @click="$refs.fileInput.click()">
            <input type="file" id="image_path" name="image_path" accept="image/png,image/jpeg" class="hidden"
                x-ref="fileInput" @change="handleFile">
            {{-- Hidden input to track existing image in edit mode --}}
            @if (isset($article) && $article->image_path)
                <input type="hidden" name="old_image_path" x-ref="oldImageInput" value="{{ $article->image_path }}">
            @endif
            <div x-show="fileUrl" class="w-full max-h-56 overflow-auto bg-white">
                <img :src="fileUrl" alt="Preview" class="w-full h-auto">
            </div>
            <div x-show="!fileUrl" class="flex flex-col items-center justify-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="mb-2 text-blue-500 w-6 h-6"
                    viewBox="0 0 16 16">
                    <path
                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                    <path
                        d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                </svg>
                <span class="text-sm text-blue-600 font-medium">Upload File</span>
                <span class="text-xs text-gray-600">Format: JPG, JPEG, PNG. Max 2MB.</span>
            </div>
        </div>

        <!-- Tombol Hapus -->
        <div x-show="fileUrl" class="flex justify-center mt-2">
            <button @click="removeFile" type="button"
                class="px-2 py-1 bg-red-600 text-white text-sm rounded-md cursor-pointer hover:bg-red-700">
                Hapus
            </button>
        </div>

        <div>
            @error('image_path')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <x-forms.input name="title" label="Judul" :value="old('title', $article->title ?? '')" />

    <x-forms.select label="Status" name="status" :options="['Draf' => 'Draf', 'Terbit' => 'Terbit', 'Arsip' => 'Arsip']" :selected="old('status', $article->status ?? 'Draf')" />

    <x-forms.textarea name="content" label="Isi Konten" :value="old('content', $article->content ?? '')" />
</div>
