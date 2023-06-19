<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Group;
use App\Models\User;
use DB;

class Groups extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $jefe_grupo, $miembro_grupo, $estado;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';

        $list_user = DB::table('users')
            ->Join('persons', 'persons.id', 'users.persona_id')
                ->select('users.*','persons.*')
                ->get(); 

        return view('livewire.groups.view', [
            'groups' => DB::table('groups')
                ->join('users', 'users.id', '=', 'groups.jefe_grupo')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->select('groups.id as idg','groups.name as nombregrupo','groups.miembro_grupo as miembrogrupo','persons.*','groups.estado as estado')
                ->where(function ($query) use ($keyWord) {
                    $query->where('groups.name', 'LIKE', $keyWord)
                          ->orWhere('groups.jefe_grupo', 'LIKE', $keyWord)
                          ->orWhere('groups.miembro_grupo', 'LIKE', $keyWord);
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
		$this->name = null;
		$this->jefe_grupo = null;
		$this->miembro_grupo = null;
        $this->estado = null;

    }

    public function store()
    {
        $this->validate([
		'name' => 'required',
        ]);

        Group::create([ 
			'name' => $this-> name,
			'jefe_grupo' => $this-> jefe_grupo,
			'miembro_grupo' => $this-> miembro_grupo,
            'estado' => 'ACTIVO'

        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Group Successfully created.');
    }

    public function edit($id)
    {
        $record = Group::findOrFail($id);

        $this->selected_id = $id; 
		$this->name = $record-> name;
		$this->jefe_grupo = $record-> jefe_grupo;
		$this->miembro_grupo = $record-> miembro_grupo;

		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'name' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Group::find($this->selected_id);
            $record->update([ 
			'name' => $this-> name,
			'jefe_grupo' => $this-> jefe_grupo,
			'miembro_grupo' => $this-> miembro_grupo
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Group Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Group::where('id', $id);
            $record->update([ 
                'estado' => 'INACTIVO',
            ]);
        }
    }

    public function habilitar($id)
    {
        if ($id) {

            $record = Group::where('id', $id);
            $record->update([ 
                'estado' => 'ACTIVO',
            ]);
        }
    }

}
