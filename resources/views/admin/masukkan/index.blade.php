@extends('admin.layout.app')

@section('title', 'Masukkan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Masukkan</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola masukkan masyarakat dari database.</p>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Masukkan</p>
        <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $masukan->count() }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[980px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Pengadu</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Isi Aduan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($masukan as $item)
                        <tr class="hover:bg-gray-50/80 transition align-top">
                            <td class="px-6 py-4 font-bold text-[#35635b]">{{ $item->nama_pengadu }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nomor_pengadu }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->email }}</td>
                            <td class="px-6 py-4 text-gray-700 max-w-md">{{ $item->isi_aduan }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.masukkan.update', $item->id_datamasukan) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold outline-none focus:border-[#35635b]">
                                        @foreach (['Pending', 'Di Baca', 'Selesai'] as $status)
                                            <option value="{{ $status }}" @selected($item->status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="rounded-lg bg-[#35635b] px-3 py-2 text-xs font-bold text-white hover:bg-[#2b4f49]">Simpan</button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.masukkan.destroy', $item->id_datamasukan) }}" class="flex justify-center" onsubmit="return confirm('Hapus masukkan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-100">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data masukkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
