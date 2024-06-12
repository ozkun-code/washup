<div class="page-wrapper">
    <div class="grid grid-cols-3 gap-12">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-tabler-calendar style="width: 3rem; height: 3rem;" />
                </div>
                <div class="stat-title">Pendaptan Bulan ini</div>
                <div class="stat-value">Rp.{{ Number::format($monthly) }} </div>


            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-tabler-calendar-check style="width: 3rem; height: 3rem;" />
                </div>
                <div class="stat-title">Pendaptan Hari ini</div>
                <div class="stat-value">Rp. {{ Number::format($today) }}</div>

            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <x-tabler-list-check style="width: 3rem; height: 3rem;" />
                </div>
                <div class="stat-title ">Pesanan Hari ini</div>
                <div class="stat-value">{{ $todayCount }} Pesanan</div>
            </div>
        </div>
    </div>
    {{-- <div class="stats shadow">
        <div class="stat">
            <h2 class="stat-value">Pesanan Berjalan</h2>
        </div>
    </div> --}}
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Customer</th>
                <th>Price</th>
                <th class="text-center">Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->created_at->format('d M H:i') }}</td>

                        <td>{{ $data->description }}</td>
                        <td>{{ $data->customer->name }}</td>
                        <td>{{ Number::format($data->price) }}</td>
                        <td class="text-center">{{ $data->status }}</td>

                        <td>
                            <div class="flex justify-center">

                                <button class="btn btn-xs btn-square"
                                    wire:click="$dispatch('editTransaksi', {transaksi : {{ $data->id }}})">
                                    <x-tabler-edit class="size-5" />
                                </button>


                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('transaksi.update')

</div>
