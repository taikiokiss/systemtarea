<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $name, $guard_name;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.permissions.view', [
            'permissions' => Permission::latest()
						->orWhere('name', 'LIKE', $keyWord)
						->orWhere('guard_name', 'LIKE', $keyWord)
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
		$this->guard_name = null;
    }

    public function store()
    {
        $this->validate([
		'name' => 'required',
		'guard_name' => 'required',
        ]);

        Permission::create([ 
			'name' => $this-> name,
			'guard_name' => $this-> guard_name
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Permission Successfully created.');
    }

    public function edit($id)
    {
        $record = Permission::findOrFail($id);

        $this->selected_id = $id; 
		$this->name = $record-> name;
		$this->guard_name = $record-> guard_name;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'name' => 'required',
		'guard_name' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Permission::find($this->selected_id);
            $record->update([ 
			'name' => $this-> name,
			'guard_name' => $this-> guard_name
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Permission Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Permission::where('id', $id);
            $record->delete();
        }
    }
}
