<div>
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <form class="modal-box" wire:submit="updateStatus">
            <h3 class="font-bold text-lg">Update Status</h3>
            <div class="py-4 space-y-2">
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">status</span>
                    </div>
                    <select type="number" placeholder="Type here" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.status'),
                    ])
                        wire:model="form.status">
                        <option value=""></option>
                        @foreach ($statuss as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="modal-action justify-between">
                <button type="button" class="btn btn-ghost" wire:click="closeModal">Close!</button>
                <button class="btn btn-primary">
                    <x-tabler-check class="size-5" />
                    <span>Update</span>
                </button>
            </div>
        </form>
    </div>
</div>
