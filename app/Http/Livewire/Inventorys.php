<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Type;
use App\Models\Location;
use App\Models\User;
use App\Models\Inventory;
use DB;
use Illuminate\Support\Facades\Auth;

class Inventorys extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $type, $serial, $modelo, $location, $description, $estado;

    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';

        $list_user = DB::table('users')
            ->Join('persons', 'persons.id', 'users.persona_id')
                ->select('users.*','persons.*')
                ->get();

        $tipo = Type::where('estado', 'ACTIVO')->get();
        $ubicacion = Location::where('estado', 'ACTIVO')->get();

        return view('livewire.inventorys.view', [
            'inventorys' => DB::table('inventorys')
                ->join('types', 'types.id', '=', 'inventorys.type')
                ->join('locations', 'locations.id', '=', 'inventorys.location')
                ->select('inventorys.id as idg','inventorys.name as nombre','locations.name as loca_name','types.name as type_name','inventorys.estado as estado')
                ->where(function ($query) use ($keyWord) {
                    $query->where('inventorys.name', 'LIKE', $keyWord);
                })
                ->paginate(10),
            'users' => $list_user,
            'types' => $tipo,
            'locations' => $ubicacion,
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
        $this->type = null; 
        $this->serial = null; 
        $this->modelo = null; 
        $this->location = null; 
        $this->description = null; 

    }

    public function store()
    {
        $this->validate([
		'name' => 'required',
        ]);

        Inventory::create([ 

            'name' => $this-> name,
            'type' => $this-> type,
            'serial' => $this-> serial,
            'modelo' => $this-> modelo,
            'location' => $this-> location,
            'description' => $this-> description,   
            'user_create' => Auth::id(),
            'estado' => 'ACTIVO'

        ]);
        


        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Successfully created.');
    }

    public function edit($id)
    {
        $record = Inventory::findOrFail($id);
        
        $this->selected_id = $id; 
        $this->name =$record-> name;
        $this->type =$record-> type;
        $this->serial =$record-> serial;
        $this->modelo =$record-> modelo;
        $this->location =$record-> location;
        $this->description =$record-> description;
        $this->estado =$record-> estado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		  'name' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Inventory::find($this->selected_id);
            $record->update([

                'name' => $this-> name,
                'type' => $this-> type,
                'serial' => $this-> serial,
                'modelo' => $this-> modelo,
                'location' => $this-> location,
                'description' => $this-> description,

            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Inventory::where('id', $id);
            $record->update([ 
                'estado' => 'INACTIVO',
            ]);
        }
    }

    public function habilitar($id)
    {
        if ($id) {

            $record = Inventory::where('id', $id);
            $record->update([ 
                'estado' => 'ACTIVO',
            ]);
        }
    }

}
