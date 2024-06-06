<?php

namespace App\Livewire\Service;

use App\Livewire\Forms\SeriviceForm;
use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\on;

use Livewire\WithFileUploads;

class Actions extends Component
{
    use WithFileUploads;

    public $photo;

    public $show = false;

    public SeriviceForm $form;

    #[On('createService')]

    public function createService()
    {
        $this->show = true;
    }

    #[On('editService')]

    public function editService(Service $service)
    {   
  
        $this->form->setService($service);
  
        $this->show = true;
        $this->dispatch('reload');

    }
    #[On('deletService')]

    public function deletService(Service $service)
    {   
        $service->delete();
        $this->dispatch('reload');


    }
    public function simpan()
    {
        if($this->photo){
            $this->form->photo = $this->photo->store('service','public');
        }
        if(isset($this->form->service)){
            $this->form->update();    
        }
        else{
            $this->form->store();           
        }
        $this->closeModal();
        $this->dispatch('reload');
    }

    public function closeModal()
    {
        $this->show = false;
        $this->photo = null;
        $this->form->reset();
    }
    public function closeAlert()
    {
        $this->dispatch('reload');
    }

    public function render()
    {
        return view('livewire.service.actions',[
            'units' => Service::$unit,
        ]);
    }
}

