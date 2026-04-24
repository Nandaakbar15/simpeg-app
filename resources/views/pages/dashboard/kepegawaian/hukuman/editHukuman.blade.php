<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Form edit hukuman</h1>
            </div>

        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-gray-200 dark:border-gray-700 p-5">
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
                <form action="/kepegawaian/hukuman/edit_data_hukuman/{{ $hukuman->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label for="pegawai_id" class="block mb-2.5 text-sm font-medium text-heading">Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id">
                            <option value="">--Pilih Pegawai --</option>
                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('pegawai_id', $hukuman->pegawai_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="pelanggaran_yg_dilakukan"
                            class="block mb-2.5 text-sm font-medium text-heading">Pelanggaran yang dilakukan</label>

                        <textarea id="pelanggaran_yg_dilakukan" name="pelanggaran_yg_dilakukan" rows="4" cols="50"
                            placeholder="Masukan pelanggaran yang dilakukan">{{ old('pelanggaran_yg_dilakukan', $hukuman->pelanggaran_yg_dilakukan) }}</textarea>
                    </div>
                    <div class="mb-5">
                        <label for="tingkat_hukuman" class="block mb-2.5 text-sm font-medium text-heading">Tingkat
                            Hukuman</label>
                        <select name="tingkat_hukuman" id="tingkat_hukuman">
                            <option value="Ringan" {{ $hukuman->tingkat_hukuman == 'Ringan' ? 'selected' : '' }}>Ringan
                            </option>
                            <option value="Sedang" {{ $hukuman->tingkat_hukuman == 'Sedang' ? 'selected' : '' }}>Sedang
                            </option>
                            <option value="Berat" {{ $hukuman->tingkat_hukuman == 'Berat' ? 'selected' : '' }}>Berat
                            </option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="jenis_hukuman" class="block mb-2.5 text-sm font-medium text-heading">Jenis
                            Hukuman</label>
                        <select name="jenis_hukuman" id="jenis_hukuman">
                            <option value="Teguran Lisan"
                                {{ $hukuman->jenis_hukuman == 'Teguran Lisan' ? 'selected' : '' }}>Teguran Lisan
                            </option>
                            <option value="Teguran Tertulis"
                                {{ $hukuman->jenis_hukuman == 'Teguran Tertulis' ? 'selected' : '' }}>Teguran Tertulis
                            </option>
                            <option value="Tunda Kenaikan Berkala"
                                {{ $hukuman->jenis_hukuman == 'Tunda Kenaikan Berkala' ? 'selected' : '' }}>Tunda
                                Kenaikan Berkala</option>
                            <option value="Tunda Kenaikan Pangkat"
                                {{ $hukuman->jenis_hukuman == 'Tunda Kenaikan Pangkat' ? 'selected' : '' }}>Tunda
                                Kenaikan Pangkat</option>
                            <option value="Pemberhentian"
                                {{ $hukuman->jenis_hukuman == 'Pemberhentian' ? 'selected' : '' }}>Pemberhentian
                            </option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="isi_teguran" class="block mb-2.5 text-sm font-medium text-heading">Isi
                            teguran</label>

                        <textarea id="isi_teguran" name="isi_teguran" rows="4" cols="50">{{ old('isi_teguran', $hukuman->isi_teguran) }}</textarea>
                    </div>
                    <div class="mb-5">
                        <label for="pejabat_pengesahan_sk_hukuman"
                            class="block mb-2.5 text-sm font-medium text-heading">Pejabat Pengesahan Hukuman</label>
                        <input type="text" id="pejabat_pengesahan_sk_hukuman" name="pejabat_pengesahan_sk_hukuman"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Masukan pejabat pengesahan hukuman" required
                            value="{{ old('pejabat_pengesahan_sk_hukuman', $hukuman->pejabat_pengesahan_sk_hukuman) }}" />
                    </div>
                    <div class="flex items-center mb-5">
                        <label for="no_sk" class="w-1/4 text-sm font-medium text-heading">Nomor dan tanggal
                            pengesahan SK</label>
                        <div class="flex w-3/4 gap-4">
                            <input type="text" id="no_sk" name="no_sk"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="Masukan nomor SK" required value="{{ old('no_sk', $hukuman->no_sk) }}" />

                            <input type="date" id="tgl_pengesahan_sk" name="tgl_pengesahan_sk"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                required placeholder="Masukan tanggal SK"
                                value="{{ old('tgl_pengesahan_sk', $hukuman->tgl_pengesahan_sk) }}" />
                        </div>
                    </div>
                    <div class="flex items-center mb-5">
                        <label for="tmt_hukuman_mulai" class="w-1/4 text-sm font-medium text-heading">TMT
                            Hukuman</label>
                        <div class="flex w-3/4 gap-4">
                            <input type="date" id="tmt_hukuman_mulai" name="tmt_hukuman_mulai"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="Dari" required
                                value="{{ old('tmt_hukuman_mulai', $hukuman->tmt_hukuman_mulai) }}" />

                            <input type="date" id="tmt_hukuman_pemulihan" name="tmt_hukuman_pemulihan"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                required placeholder="Sampai"
                                value="{{ old('tmt_hukuman_pemulihan', $hukuman->tmt_hukuman_pemulihan) }}" />
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="pejabat_pemulihan_hukuman"
                            class="block mb-2.5 text-sm font-medium text-heading">Pejabat Pemulihan Hukuman</label>
                        <input type="text" id="pejabat_pemulihan_hukuman" name="pejabat_pemulihan_hukuman"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Masukan pejabat pemulihan hukuman" required
                            value="{{ old('pejabat_pemulihan_hukuman', $hukuman->pejabat_pemulihan_hukuman) }}" />
                    </div>
                    <div class="flex items-center mb-5">
                        <label for="no_sk" class="w-1/4 text-sm font-medium text-heading">Nomor dan tanggal
                            pemulihan hukuman</label>
                        <div class="flex w-3/4 gap-4">
                            <input type="text" id="no_pemulihan_hukuman" name="no_pemulihan_hukuman"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                placeholder="Masukan nomor pemulihan hukuman" required
                                value="{{ old('no_pemulihan_hukuman', $hukuman->no_pemulihan_hukuman) }}" />

                            <input type="date" id="tgl_pemulihan_hukuman" name="tgl_pemulihan_hukuman"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                required placeholder="Masukan tanggal pemulihan hukuman"
                                value="{{ old('tgl_pemulihan_hukuman', $hukuman->tgl_pemulihan_hukuman) }}" />
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-500 box-border border border-transparent hover:bg-blue-700 focus:ring-4 rounded-lg focus:ring-brand-medium shadow-lg font-medium leading-5 rounded-base text-sm px-4 py-2 focus:outline-none">Save</button>
                </form>
            </div>

            <div class="mt-5">
                <a href="/kepegawaian/hukuman"
                    class="inline-block rounded-lg shadow-lg text-white px-4 py-2 bg-slate-500 hover:bg-slate-700">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
