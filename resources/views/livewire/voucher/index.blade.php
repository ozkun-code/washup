<div class="page-wrapper">
    <div class="flex justify-between">
        <input type="search" class="input input-bordered" placeholder="pencarian" wire:model.live="search">
        <button class="btn btn-primary" wire:click="$dispatch('createVoucher')">
            <x-tabler-plus class="size-5" />
            <span>Tambah Voucher</span>
        </button>
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Voucer</th>
                    <th>Discount</th>
                    <th>Point Required</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $voucher)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $voucher->name }}</td>
                        <td>{{ $voucher->discount_percent }}</td>
                        <td>{{ $voucher->points_required }}</td>
                        <td>
                            <div class="flex justify-center gap-1">
                                <button class="btn btn-xs btn-square"
                                    wire:click="$dispatch('editVoucher', {voucher : {{ $voucher->id }}})">
                                    <x-tabler-edit class="size-4" />
                                </button>
                                <button class="btn btn-xs btn-square"
                                    wire:click="$dispatch('deleteVoucher', {voucher : {{ $voucher->id }}})">
                                    <x-tabler-trash class="size-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('voucher.actions')
</div>
