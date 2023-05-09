<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Group;

class Groups extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $jefe_grupo, $miembro_grupo;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.groups.view', [
            'groups' => Group::latest()
						->orWhere('name', 'LIKE', $keyWord)
						->orWhere('jefe_grupo', 'LIKE', $keyWord)
						->orWhere('miembro_grupo', 'LIKE', $keyWord)
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
		$this->jefe_grupo = null;
		$this->miembro_grupo = null;
    }

    public function store()
    {
        $this->validate([
		'name' => 'required',
        ]);

        Group::create([ 
			'name' => $this-> name,
			'jefe_grupo' => $this-> jefe_grupo,
			'miembro_grupo' => $this-> miembro_grupo
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
            $record->delete();
        }
    }
}
