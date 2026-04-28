<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Form edit data pangkat</h1>
            </div>

        </div>

        <div x-data="{ openPangkat: false, openPangkat: false }"
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
                <form action="/kepegawaian/pangkat/edit_data_pangkat/{{ $pangkat->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label for="pegawai_id" class="block mb-2.5 text-sm font-medium text-heading">Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id">
                            <option value="">--Pilih Pegawai --</option>
                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('pegawai_id', $pangkat->pegawai_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="master_pangkat_id"
                            class="block mb-2.5 text-sm font-medium text-heading">Pangkat</label>
                        <div x-data="pangkatComponent()">
                            <div class="flex gap-2">
                                <select name="master_pangkat_id" id="master_pangkat_id"
                                    class="flex-1 rounded-lg border-gray-300 shadow-sm">
                                    @foreach ($masterPangkat as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('master_pangkat_id', $pangkat->master_pangkat_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_pangkat }}</option>
                                    @endforeach
                                </select>

                                <button type="button" @click="openPangkat = true"
                                    class="bg-orange-500 text-white px-3 py-1 rounded shadow hover:bg-orange-600 transition shrink-0">
                                    + ADD PAN
                                </button>

                                <div x-show="openPangkat" class="fixed inset-0 z-50 overflow-y-auto"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-10"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-10"
                                    class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                                    <div class="flex items-center justify-center min-h-screen p-4">
                                        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                                            @click="openPangkat = false">
                                        </div>
                                        <div class="relative bg-white rounded-lg shadow-xl sm:max-w-4xl sm:w-full">
                                            <div class="px-4 py-3 border-b flex justify-between items-center">
                                                <h3 class="text-lg font-bold text-blue-600">Master Nama Pangkat</h3>
                                                <button @click="openPangkat = false" class="text-2xl">&times;</button>
                                            </div>
                                            <div class="p-6">

                                                <!-- FORM TAMBAH -->
                                                <div class="flex gap-2 mb-4">
                                                    <input type="text" x-model="nama_pangkat"
                                                        class="border rounded px-3 py-2 w-full"
                                                        placeholder="Masukan nama pangkat">

                                                    <button type="button" @click="addPangkat"
                                                        class="bg-blue-500 text-white px-4 rounded">
                                                        Save
                                                    </button>
                                                </div>

                                                <!-- LIST DATA -->
                                                <table class="w-full text-sm border-collapse border border-gray-300">
                                                    <thead>
                                                        <tr class="bg-gray-100">
                                                            <th class="border p-2 text-left w-12">No</th>
                                                            <th class="border p-2 text-left">Nama Pangkat</th>
                                                            <th class="border p-2 text-left w-40">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="(item, index) in listPangkat"
                                                            :key="item.id">
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="border p-2 text-center" x-text="index + 1">
                                                                </td>
                                                                <td class="border p-2" x-text="item.nama_pangkat"></td>
                                                                <td class="border p-2 space-x-2">
                                                                    <a href="/kepegawaian/master_pangkat/edit_master_pangkat/(item.id)"
                                                                        class="inline-block bg-blue-500 text-white rounded-lg shadow-lg py-2 px-3 hover:bg-blue-500">Edit</a>
                                                                    <button @click="deletePangkat(item.id)"
                                                                        class="inline-block bg-red-500 text-white rounded-lg shadow-lg py-2 px-3 hover:bg-red-700">
                                                                        Delete
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="master_golongan_id"
                            class="block mb-2.5 text-sm font-medium text-heading">Golongan</label>
                        <div x-data="golonganComponent()">
                            <div class="flex gap-2">
                                <select name="master_golongan_id" id="master_golongan_id"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm">
                                    @foreach ($masterGolongan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('master_golongan_id', $pangkat->master_golongan_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_golongan }}</option>
                                    @endforeach
                                </select>
                                <button type="button" @click="openGolongan = true"
                                    class="bg-orange-500 text-white px-3 py-1 rounded shadow hover:bg-orange-600 transition shrink-0">
                                    + ADD GOL
                                </button>

                                <div x-show="openGolongan" class="fixed inset-0 z-50 overflow-y-auto"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-10"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-10"
                                    class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                                    <div class="flex items-center justify-center min-h-screen p-4">
                                        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                                            @click="openGolongan = false">
                                        </div>
                                        <div class="relative bg-white rounded-lg shadow-xl sm:max-w-4xl sm:w-full">
                                            <div class="px-4 py-3 border-b flex justify-between items-center">
                                                <h3 class="text-lg font-bold text-green-600">Master Data Golongan</h3>
                                                <button @click="openGolongan = false" class="text-2xl">&times;</button>
                                            </div>
                                            <div class="p-6">

                                                <!-- FORM TAMBAH -->
                                                <div class="flex gap-2 mb-4">
                                                    <input type="text" x-model="nama_golongan"
                                                        class="border rounded px-3 py-2 w-full"
                                                        placeholder="Masukan nama eselon">

                                                    <button type="button" @click="addGolongan"
                                                        class="bg-blue-500 text-white px-4 rounded">
                                                        Save
                                                    </button>
                                                </div>

                                                <!-- LIST DATA -->
                                                <table class="w-full text-sm border-collapse border border-gray-300">
                                                    <thead>
                                                        <tr class="bg-gray-100">
                                                            <th class="border p-2 text-left w-12">No</th>
                                                            <th class="border p-2 text-left">Nama Golongan</th>
                                                            <th class="border p-2 text-left w-40">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="(item, index) in listGolongan"
                                                            :key="item.id">
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="border p-2 text-center" x-text="index + 1">
                                                                </td>
                                                                <td class="border p-2" x-text="item.nama_golongan">
                                                                </td>
                                                                <td class="border p-2 space-x-2">
                                                                    <a href="/kepegawaian/master_golongan/edit_master_golongan/(item.id)"
                                                                        class="inline-block bg-blue-500 text-white rounded-lg shadow-lg py-2 px-3 hover:bg-blue-500">Edit</a>
                                                                    <button @click="deleteGolongan(item.id)"
                                                                        class="inline-block bg-red-500 text-white rounded-lg shadow-lg py-2 px-3 hover:bg-red-700">
                                                                        Delete
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="jenis_pangkat" class="block mb-2.5 text-sm font-medium text-heading">Jenis
                            Pangkat</label>
                        <input type="text" id="jenis_pangkat" name="jenis_pangkat"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Masukan jenis pangkat" required
                            value="{{ old('jenis_pangkat', $pangkat->jenis_pangkat) }}" />
                    </div>
                    <div class="flex items-center mb-5">
                        <label for="tmt_pangkat_mulai" class="w-1/4 text-sm font-medium text-heading">TMT
                            Pangkat</label>
                        <div class="flex w-3/4 gap-4">
                            <input type="date" id="tmt_pangkat_mulai" name="tmt_pangkat_mulai"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="Dari" required
                                value="{{ old('tmt_pangkat_mulai', $pangkat->tmt_pangkat_mulai) }}" />

                            <input type="date" id="tmt_pangkat_selesai" name="tmt_pangkat_selesai"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                required value="{{ old('tmt_pangkat_selesai', $pangkat->tmt_pangkat_selesai) }}" />
                        </div>
                    </div>
                    <div class="flex items-center mb-5">
                        <label for="no_sk" class="w-1/4 text-sm font-medium text-heading">Nomor dan tanggal
                            SK</label>
                        <div class="flex w-3/4 gap-4">
                            <input type="text" id="no_sk" name="no_sk"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="Masukan nomor SK" required
                                value="{{ old('no_sk', $pangkat->no_sk) }}" />

                            <input type="date" id="tgl_sk" name="tgl_sk"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                required value="{{ old('tgl_sk', $pangkat->tgl_sk) }}" />
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="pejabat_pengesah_sk" class="block mb-2.5 text-sm font-medium text-heading">Pejabat
                            Pengesah SK</label>
                        <input type="text" id="pejabat_pengesah_sk" name="pejabat_pengesah_sk"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Diterbikan oleh" required
                            value="{{ old('pejabat_pengesah_sk', $pangkat->pejabat_pengesah_sk) }}" />
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-500 box-border border border-transparent hover:bg-blue-700 focus:ring-4 rounded-lg focus:ring-brand-medium shadow-lg font-medium leading-5 rounded-base text-sm px-4 py-2 focus:outline-none">Save</button>
                </form>
            </div>

            <div class="mt-5">
                <a href="/kepegawaian/pangkat"
                    class="inline-block rounded-lg shadow-lg text-white px-4 py-2 bg-slate-500 hover:bg-slate-700">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function pangkatComponent() {
        return {
            openPangkat: false,
            nama_pangkat: '',
            listPangkat: @json($masterPangkat),

            async addPangkat() {
                if (!this.nama_pangkat) return;

                let res = await fetch('/kepegawaian/master_pangkat/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nama_pangkat: this.nama_pangkat
                    })
                });

                let data = await res.json();

                this.listPangkat.push(data);
                this.nama_pangkat = '';
            }
        }
    }

    function golonganComponent() {
        return {
            openGolongan: false,
            nama_golongan: '',
            listGolongan: @json($masterGolongan),

            async addGolongan() {
                if (!this.nama_golongan) return;

                let res = await fetch('/kepegawaian/master_golongan/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nama_golongan: this.nama_golongan
                    })
                });

                let data = await res.json();

                this.listGolongan.push(data);
                this.nama_golongan = '';
            }
        }
    }
</script>
