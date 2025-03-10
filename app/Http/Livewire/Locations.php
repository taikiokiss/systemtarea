<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Location;

class Locations extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $estado;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.locations.view', [
                'Locations' => Location::latest()
                        ->where(function ($query) use ($keyWord) {
                            $query->where('name', 'LIKE', '%'.$keyWord.'%');
                        })
                        ->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->name = null;
    }

    public function store()
    {
        $this->validate([
		'name' => 'required',
        ]);

        Location::create([ 
			'name' => $this-> name,
			'estado' => 'ACTIVO'
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Ubicacion Creado Exitosamente.');
    }

    public function edit($id)
    {
        $record = Location::findOrFail($id);

        $this->selected_id = $id; 
		$this->name = $record-> name;		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'name' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Location::find($this->selected_id);
            $record->update([ 
			     'name' => $this-> name
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Ubicacion Actualizado Exitosamente.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Location::where('id', $id);
            $record->update([ 
                'estado' => 'INACTIVO',
            ]);

        }
    }

    public function habilitar($id)
    {
        if ($id) {

            $record = Location::where('id', $id);
            $record->update([ 
                'estado' => 'ACTIVO',
            ]);
        }
    }
    
}
