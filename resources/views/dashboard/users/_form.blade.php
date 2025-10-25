<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-forms.input name="name" label="Nama" :value="old('name', $user->name ?? '')" />

    <x-forms.input name="phone" label="No. Telp" :value="old('phone', $user->phone ?? '')" />

    <x-forms.input type="email" name="email" label="Email" :value="old('email', $user->email ?? '')" />

    <x-forms.select label="Role" name="role" :options="['Admin' => 'Admin', 'Pengunjung' => 'Pengunjung']" :selected="old('role', $user->role ?? 'Pengunjung')" />

    <div class="md:col-span-2">
        <x-forms.select label="Status" name="status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" :selected="old('status', $user->status ?? 'Aktif')" />
    </div>

    <x-forms.input type="password" name="password" label="Password" placeholder="Kosongkan jika tidak diubah" />
    <x-forms.input type="password" name="password_confirmation" label="Konfirmasi Password" />

</div>
