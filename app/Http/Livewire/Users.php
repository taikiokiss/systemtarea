<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Person;
use App\Models\Group;
use App\Models\Department;
use DB;


class Users extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $email,$persona_id, $estado,$name,$last_name,$cedula,$direccion,$celular,$department,$grupo;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        $departmentt = Department::all();
        $grup = Group::all();

        return view('livewire.users.view', [

            'users' => DB::table('users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->latest('users.created_at')
                ->where('users.estado','=','ACTIVO')
                ->where('users.id','!=','4')
                ->where(function ($query) use ($keyWord) {
                    $query->where('users.email', 'LIKE', '%'.$keyWord.'%')
                          ->orWhere('persons.name', 'LIKE', '%'.$keyWord.'%')
                          ->orWhere('persons.last_name', 'LIKE', '%'.$keyWord.'%');
                })
                ->select('users.*','persons.*','departments.*','users.id as userid')
                ->paginate(10),
            'departments' => $departmentt,
            'groups' => $grup,

        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->email = null;
        $this->name = null;
        $this->last_name = null;
        $this->cedula = null;
        $this->department = null;
        $this->grupo = null;

    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'cedula' => 'required',
    		'email' => 'required',
            'last_name' => 'required',
            'department' => 'required',
            'grupo' => 'required',

        ]);

        $pers = Person::create([ 
            'name'      => $this-> name,
            'last_name' => $this-> last_name,
            'cedula'    => $this-> cedula
        ]);

        User::create([ 
			'email' => $this-> email,
            'password' => Hash::make($this-> cedula),
            'persona_id' => $pers->id,
            'deparment_id' => $this-> department,
            'group_id' => $this-> grupo,
            'estado' => 'ACTIVO'
        ]);


        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Usuario registrado con exito.');
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);
        $record2 = Person::findOrFail($id);

        $this->selected_id = $id; 
		$this->email = $record-> email;
		$this->name = $record2-> name;		
        $this->last_name = $record2-> last_name;
        $this->cedula = $record2-> cedula;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'cedula' => 'required',
            'email' => 'required',
            'last_name' => 'required'
        ]);

        if ($this->selected_id) {

			$record = User::find($this->selected_id);
            $record->update([ 
			     'email' => $this-> email
            ]);

            $record2 = Person::find($this->selected_id);
            $record2->update([ 
                'name'      => $this-> name,
                'last_name' => $this-> last_name,
                'cedula'    => $this-> cedula
            ]);


            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Usuario Actualizado con exito.');
        }
    }

    public function destroy($id)
    {
        if ($id) {

            $record = User::find($id);
            $record->update([ 
            'estado' => 'INACTIVO',
            ]);
        }
    }
}
