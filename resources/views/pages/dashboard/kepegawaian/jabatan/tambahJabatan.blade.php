<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Form tambah data jabatan</h1>
            </div>

        </div>

        <div x-data="{ openJabatan: false, openEselon: false }"
            class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-5">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="/jabatan/tambah_data_jabatan" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="pegawai_id" class="block mb-2.5 text-sm font-medium text-heading">Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id">
                            <option value="">--Pilih Pegawai -- </option>
                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="jabatan" class="block mb-2.5 text-sm font-medium text-heading">Jabatan</label>
                        <div class="flex gap-2">
                            <select name="jabatan" id="jabatan" class="flex-1 rounded-md border-gray-300 shadow-sm">
                                @foreach ($masterJabatan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                                @endforeach
                            </select>

                            <button type="button" @click="openJabatan = true"
                                class="bg-orange-500 text-white px-3 py-1 rounded shadow hover:bg-orange-600 transition shrink-0">
                                + ADD JAB
                            </button>

                            <div x-show="openJabatan" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="openJabatan = false">
                                    </div>
                                    <div class="relative bg-white rounded-lg shadow-xl sm:max-w-4xl sm:w-full">
                                        <div class="px-4 py-3 border-b flex justify-between items-center">
                                            <h3 class="text-lg font-bold text-blue-600">Master Nama Jabatan</h3>
                                            <button @click="openJabatan = false" class="text-2xl">&times;</button>
                                        </div>
                                        <div class="p-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="eselon" class="block mb-2.5 text-sm font-medium text-heading">Eselon</label>
                        <div class="flex gap-2">
                            <select name="eselon" id="eselon" class="flex-1 rounded-md border-gray-300 shadow-sm">
                                @foreach ($eselon as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_eselon }}</option>
                                @endforeach
                            </select>
                            <button type="button" @click="openEselon = true"
                                class="bg-orange-500 text-white px-3 py-1 rounded shadow hover:bg-orange-600 transition shrink-0">
                                + ADD ESL
                            </button>

                            <div x-show="openEselon" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="openEselon = false">
                                    </div>
                                    <div class="relative bg-white rounded-lg shadow-xl sm:max-w-4xl sm:w-full">
                                        <div class="px-4 py-3 border-b flex justify-between items-center">
                                            <h3 class="text-lg font-bold text-green-600">Master Data Eselon</h3>
                                            <button @click="openEselon = false" class="text-2xl">&times;</button>
                                        </div>
                                        <div class="p-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="jenis_jabatan" class="block mb-2.5 text-sm font-medium text-heading">Jenis
                            Jabatan</label>
                        <select name="jenis_jabatan" id="jenis_jabatan">
                            <option value="Jabatan Struktural">Jabatan Struktural</option>
                            <option value="Jabatan Fungsional Tertentu">Jabatan Fungsional Tertentu</option>
                            <option value="Jabatan Fungsional Umum">Jabatan Fungsional Umum</option>
                        </select>
                    </div>
                    <div class="flex items-center mb-5">
                        <label for="tmt_jabatan_mulai" class="w-1/4 text-sm font-medium text-heading">TMT
                            Jabatan</label>
                        <div class="flex w-3/4 gap-4">
                            <input type="date" id="tmt_jabatan_mulai" name="tmt_jabatan_mulai"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="Dari" required />

                            <input type="date" id="tmt_jabatan_selesai" name="tmt_jabatan_selesai"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                required />
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="tahun_ke" class="block mb-2.5 text-sm font-medium text-heading">Tahun Ke</label>
                        <select name="tahun_ke" id="tahun_ke">
                            <option value="-">-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="Sudah Selesai">Sudah Selesai</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="periode_ke" class="block mb-2.5 text-sm font-medium text-heading">Periode Ke</label>
                        <select name="periode_ke" id="periode_ke">
                            <option value="Jabatan Struktural">-</option>
                            <option value="Jabatan Fungsional Tertentu">I</option>
                            <option value="Jabatan Fungsional Umum">II</option>
                            <option value="Sudah Selesai">Sudah Selesai</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-500 box-border border border-transparent hover:bg-blue-700 focus:ring-4 rounded-lg focus:ring-brand-medium shadow-lg font-medium leading-5 rounded-base text-sm px-4 py-2 focus:outline-none">Save</button>
                </form>
            </div>

            <div class="mt-5">
                <a href="/riwayat_pendidikan/sekolah_lanjut"
                    class="inline-block rounded-lg shadow-lg text-white px-4 py-2 bg-slate-500 hover:bg-slate-700">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
