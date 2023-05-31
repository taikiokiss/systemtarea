<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Departments_descrip;
use App\Models\Group;
use App\Models\User;
use DB;

class Departments_descrips extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $departments_id, $subtarea_descrip, $usuario_asignado, $tiempo_demora, $estado;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';

        $list_user = DB::table('users')
            ->Join('persons', 'persons.id', 'users.persona_id')
            ->where('users.estado','=','ACTIVO')
                ->select('users.*','persons.*')
                ->get(); 

        return view('livewire.departments_descrips.view', [

            'Departments_descrips' => DB::table('departments_descrip')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users', 'users.id', '=', 'departments_descrip.usuario_asignado')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->select('departments.namedt as nombredepartamento','persons.*','departments_descrip.*')
                ->where(function ($query) use ($keyWord) {
                    $query->where('departments_descrip.subtarea_descrip', 'LIKE', $keyWord);
                })
                ->paginate(10),
            'users' => $list_user,

        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->departments_id = null;
		$this->subtarea_descrip = null;
		$this->usuario_asignado = null;
		$this->tiempo_demora = null;
		$this->estado = null;
    }

    public function store()
    {
        $this->validate([
		'departments_id' => 'required',
		'subtarea_descrip' => 'required',
		'usuario_asignado' => 'required',
		'tiempo_demora' => 'required',
        ]);

        Departments_descrip::create([ 
			'departments_id' => $this-> departments_id,
			'subtarea_descrip' => $this-> subtarea_descrip,
			'usuario_asignado' => $this-> usuario_asignado,
			'tiempo_demora' => $this-> tiempo_demora,
			'estado' => $this-> estado
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Departments_descrip Successfully created.');
    }

    public function edit($id)
    {
        $record = Departments_descrip::findOrFail($id);

        $this->selected_id = $id; 
		$this->departments_id = $record-> departments_id;
		$this->subtarea_descrip = $record-> subtarea_descrip;
		$this->usuario_asignado = $record-> usuario_asignado;
		$this->tiempo_demora = $record-> tiempo_demora;
		$this->estado = $record-> estado;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'departments_id' => 'required',
		'subtarea_descrip' => 'required',
		'usuario_asignado' => 'required',
		'tiempo_demora' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Departments_descrip::find($this->selected_id);
            $record->update([ 
			'departments_id' => $this-> departments_id,
			'subtarea_descrip' => $this-> subtarea_descrip,
			'usuario_asignado' => $this-> usuario_asignado,
			'tiempo_demora' => $this-> tiempo_demora,
			'estado' => $this-> estado
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Departments_descrip Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Departments_descrip::where('id', $id);
            $record->delete();
        }
    }
}
