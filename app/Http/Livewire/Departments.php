<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department;

class Departments extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $namedt, $estado;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.departments.view', [
                'departments' => Department::latest()
                        ->where(function ($query) use ($keyWord) {
                            $query->where('namedt', 'LIKE', '%'.$keyWord.'%');
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
		$this->namedt = null;
    }

    public function store()
    {
        $this->validate([
		'namedt' => 'required',
        ]);

        Department::create([ 
			'namedt' => $this-> namedt,
			'estado' => 'ACTIVO'
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Departamento Creado Exitosamente.');
    }

    public function edit($id)
    {
        $record = Department::findOrFail($id);

        $this->selected_id = $id; 
		$this->namedt = $record-> namedt;		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'namedt' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Department::find($this->selected_id);
            $record->update([ 
			     'namedt' => $this-> namedt
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Departamento Actualizado Exitosamente.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Department::where('id', $id);
            $record->update([ 
                'estado' => 'INACTIVO',
            ]);

        }
    }

    public function habilitar($id)
    {
        if ($id) {

            $record = Department::where('id', $id);
            $record->update([ 
                'estado' => 'ACTIVO',
            ]);
        }
    }
    
}
