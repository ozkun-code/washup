<div>
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <form class="modal-box" wire:submit="simpan">
            <h3 class="font-bold text-lg">Form Add Service!</h3>
            <div class="py-4 space-y-2">
                <div class="flex justify-center">
                    <label for="pickphoto" class="avatar">
                        <div class="w-32 rounded-2xl">
                            <img src="{{ $photo ? $photo->temporaryUrl() : url('noimage.png') }}" />
                        </div>
                    </label>
                </div>
                <input type="file" class="hidden" id="pickphoto" wire:model="photo" />
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Service Name</span>
                    </div>
                    <input type="text" placeholder="Type here" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.name'),
                    ]) wire:model="form.name" />
                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Price</span>
                    </div>
                    <input type="number" placeholder="Type here" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.price'),
                    ])
                        wire:model="form.price" />
                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Satuan</span>
                    </div>
                    <select type="number" placeholder="Type here" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.unit'),
                    ]) wire:model="form.unit">
                        <option value=""></option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}">{{ $unit }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Estimed Completion</span>
                    </div>
                    <input type="text" placeholder="Type here" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.estimated_completion_time'),
                    ])
                        wire:model="form.estimated_completion_time" />
                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Description</span>
                    </div>
                    <textarea placeholder="Tulis keterangan Service disini" @class([
                        'textarea textarea-bordered',
                        'input-error' => $errors->first('form.description'),
                    ]) wire:model="form.description"></textarea>
                </label>
            </div>
            <div class="modal-action justify-between">
                <button type="button" class="btn btn-ghost" wire:click="closeModal">Close!</button>
                <button class="btn btn-primary">
                    <x-tabler-check class="size-5" />
                    <span>Save</span>
                </button>
            </div>
        </form>
    </div>
</div>
