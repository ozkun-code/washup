<div>
    <input type="checkbox" class="modal-toggle" @checked($show)/>
<div class="modal" role="dialog">
  <form class="modal-box" wire:submit="simpan">
    <h3 class="font-bold text-lg">Form Add Customer!</h3>
    <div class="py-4 space-y-2">
        <label class="form-control">
            <div class="label">
              <span class="label-text">Nama Customer</span>
            </div>
            <input type="text" placeholder="Type here" @class(['input input-bordered', 'input-error' => $errors->first('form.name')]) wire:model="form.name" />
          </label>
          <label class="form-control">
            <div class="label">
              <span class="label-text">Contact</span>
            </div>
            <input type="text" placeholder="Type here" @class(['input input-bordered', 'input-error' => $errors->first('form.contact')]) wire:model="form.contact" />
          </label>
          <label class="form-control">
            <div class="label">
                <span class="label-text">User Email</span>
            </div>
            <input type="email" placeholder="Type here" @class(['input input-bordered', 'input-error' => $errors->first('form.user_email')]) wire:model="form.user_email" />
        </label>
        <input type="hidden"  wire:model="form.user_id" />
      

    </div>
    <div class="modal-action justify-between">
      <button  type="button" class="btn btn-ghost" wire:click="closeModal">Close!</button>
      <button class="btn btn-primary">
        <x-tabler-check class="size-5" />
        <span>Save</span>
      </button>
    </div>
  </form>
</div>
</div>
