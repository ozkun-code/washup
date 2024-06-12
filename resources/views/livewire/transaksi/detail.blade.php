<div>
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Detail Transaksi</h3>
            <div class="py-4 space-y-4">
                <div class="flex flex-col">
                    <div class="text-sm opacity-50">Tanggal Transaksi</div>
                    <div>{{ $transaksi?->created_at->format('d F Y H:i') }}</div>
                </div>
                <div class="flex flex-col">
                    <div class="text-sm opacity-50">Nama Customer</div>
                    <div>{{ $transaksi?->customer?->name ?? '-' }}</div>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <th>Nama Service</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </thead>
                    <tbody>
                        @php
                            $totalPembelian = 0;
                            foreach (json_decode($transaksi?->items, true) ?? [] as $item) {
                                $totalPembelian += $item['price'];
                            }
                            $discountNominal = ($totalPembelian * ($transaksi?->discount ?? 0)) / 100;
                            $totalBayar = $totalPembelian - $discountNominal;
                        @endphp

                        @foreach (json_decode($transaksi?->items, true) ?? [] as $key => $item)
                            <tr class="table-row-bordered">
                                <td>{{ $key }}</td>
                                <td>{{ $item['qty'] }} @if (isset($item['unit']))
                                        {{ $item['unit'] }}
                                    @endif
                                </td>
                                <td>{{ Number::format($item['price']) }}</td>
                            </tr>
                        @endforeach
                        <tr class="table-row-bordered-thick">
                            <td>Total Pembelian</td>
                            <td>-</td>
                            <td>{{ Number::format($totalPembelian) }}</td>
                        </tr>
                        <tr class="table-row-bordered">
                            <td>Discount</td>
                            <td>{{ Number::format($transaksi?->discount ?? 0) }}%</td>
                            <td>-{{ Number::format($discountNominal) }}</td>
                        </tr>
                        <tr class="table-row-bordered">
                            <td>Total Bayar</td>
                            <td>-</td>
                            <td>{{ Number::format($totalBayar) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-action">
                <button type="button" wire:click="closeModal" class="btn btn-ghost">Close!</button>
            </div>
        </div>
    </div>
</div>
