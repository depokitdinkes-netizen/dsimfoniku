@extends('layouts.app')

@section('content')
<div class="p-3 sm:p-6 border-b flex items-center justify-between gap-5">
    <h1 class="font-extrabold sm:text-xl">Histori Hasil Inspeksi</h1>
    <img src="{{ asset('logo/depok-city.png') }}" alt="depok city" class="h-6 sm:h-9 object-cover" />
</div>

<div class="p-3 sm:p-6">
    <div class="flex justify-end gap-3 flex-wrap mb-6">
        <button class="btn btn-primary btn-outline" onclick="filter_history.showModal()">
            <i class="ri-equalizer-3-fill"></i>
            <span>FILTER</span>
        </button>
        <form method="GET" class="join">
            <button type="submit" class="btn btn-primary btn-square join-item">
                <i class="ri-search-line"></i>
            </button>
            <input type="text" name="s" class="input input-bordered join-item w-full" placeholder="Cari hasil inspeksi ..." />
        </form>

        <button class="btn btn-primary" onclick="export_history.showModal()">
            <span>RAW EXPORT</span>
            <i class="ri-upload-2-line"></i>
        </button>
    </div>

    <div class="overflow-x-auto mb-2 bg-white rounded-lg">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th></th>
                    <th>Nama Tempat</th>
                    <th>Nama Pemeriksa</th>
                    <th>Skor</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Status Operasi</th>
                    <th>Status SLHS</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if (count($inspections) == 0)
                <tr>
                    <td colspan="8" class="text-center">Tidak ada hasil inspeksi yang dapat ditampilkan</td>
                </tr>
                @endif
                @foreach ($inspections as $index => $inspection)
                <tr>
                    <th>{{ $index + 1 + (($page_index - 1) * $dpp) }}</th>
                    <td><i class="{{ $inspection['icon'] }} text-{{ $inspection['color'] }}"></i> <span>{{ $inspection['name'] }}</span></td>
                    <td>{{ $inspection['reviewer'] }}</td>
                    <td class="font-semibold">{{ number_format($inspection['score'], 0, ',', '.') }}</td>
                    <td>{{ $inspection['date'] }}</td>
                    <td>
                        @if ($inspection['operasi'])
                        <p class="border-success border text-success font-medium px-3 py-1.5 rounded-full text-xs text-center">MASIH BEROPERASI</p>
                        @else
                        <p class="border-error border text-error font-medium px-1.5 py-1 rounded-full text-xs text-center">TIDAK BEROPERASI</p>
                        @endif
                    </td>
                    <td>
                        <x-status.slhs-badge
                            :slhsExpireDate="$inspection['slhs_expire_date'] ?? null"
                            :slhsIssuedDate="$inspection['slhs_issued_date'] ?? null"
                            :showTooltip="true"
                        />
                    </td>
                    <td class="flex gap-1.5">
                        @auth
                        @if (Auth::user()->role != "USER")
                        <div class="tooltip tooltip-warning" data-tip="Ubah Informasi / Penilaian">
                            <a href="{{ $inspection['sud'] . '/edit' }}" class="btn btn-warning btn-square">
                                <i class="ri-edit-fill"></i>
                            </a>
                        </div>
                        @endif
                        @if (Auth::user()->role == "SUPERADMIN")
                        <form id="deleteForm{{ $index }}" action="{{ url($inspection['sud']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="tooltip tooltip-error" data-tip="Hapus Hasil Inspeksi">
                                <button type="button" class="btn btn-error btn-outline btn-square" onclick="showDeleteConfirmation('{{ $inspection['name'] }}', {{ $index }})">
                                    <i class="ri-delete-bin-6-line"></i>
                                </button>
                            </div>
                        </form>
                        @endif
                        @endauth

                        <div class="tooltip" data-tip="Lihat Hasil Inspeksi">
                            <a href="{{ $inspection['sud'] }}" class="btn btn-neutral">
                                <i class="ri-info-i"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="flex gap-3 mt-5 items-center justify-end">
        @auth
        @if (Auth::user()->role == "SUPERADMIN")
        <a href="{{ route('archived') }}" class="btn btn-primary btn-outline">ARCHIVED INSPEKSI</a>
        @endif
        @endauth

        <div class="join">
            @if ($page_index != 1)
            <a href="{{ route('history') . '?p=' . (int) $page_index - 1 }}" class="join-item btn rounded">
                <i class="ri-arrow-left-s-line"></i>
            </a>
            <a href="{{ route('history') . '?p=' . (int) $page_index - 1 }}" class="join-item btn rounded">
                {{ (int) $page_index - 1 }}
            </a>
            @endif
            <button type="button" class="join-item btn rounded btn-active">{{ $page_index }}</button>
            @if ($page_index != $total_pages && $total_pages != 0)
            <a href="{{ route('history') . '?p=' . (int) $page_index + 1 }}" class="join-item btn rounded">
                {{ (int) $page_index + 1 }}
            </a>
            <a href="{{ route('history') . '?p=' . (int) $page_index + 1 }}" class="join-item btn rounded">
                <i class="ri-arrow-right-s-line"></i>
            </a>
            @endif
        </div>
        <form action="{{ route('history') }}" class="join">
            <select class="select select-bordered join-item" name="dpp">
                <option value="5" @if($dpp==5) selected @endif>5</option>
                <option value="15" @if($dpp==15) selected @endif>15</option>
                <option value="25" @if($dpp==25) selected @endif>25</option>
            </select>
            <button type="submit" class="btn btn-neutral join-item rounded">Set</button>
        </form>
    </div>
</div>

<x-modal.filter-history />
<x-modal.export-history />
<x-modal.confirmation />

<script>
    function showDeleteConfirmation(inspectionName, formIndex) {
        showDeleteConfirmationModal(
            'Hapus Hasil Inspeksi',
            `Apakah Anda yakin ingin menghapus hasil inspeksi "${inspectionName}"? Data yang dihapus tidak dapat dikembalikan.`,
            function() {
                document.getElementById('deleteForm' + formIndex).submit();
            }
        );
    }
</script>

@endsection
