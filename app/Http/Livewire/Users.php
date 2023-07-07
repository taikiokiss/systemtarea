<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Person;
use App\Models\Group;
use App\Models\Department;
use Illuminate\Http\Request;
use DB;

use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $email,$persona_id, $estado,$name,$last_name,$cedula,$direccion,$celular,$department,$grupo,$rol_option;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        $departmentt = Department::where('estado','ACTIVO')->get();
        $grup = Group::all();
        $roles = Role::all();

        return view('livewire.users.view', [

            'users' => DB::table('users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->latest('users.id')
                ->where('users.id','!=','1')
                ->where(function ($query) use ($keyWord) {
                    $query->where('users.email', 'LIKE', '%'.$keyWord.'%')
                          ->orWhere('persons.name', 'LIKE', '%'.$keyWord.'%')
                          ->orWhere('persons.last_name', 'LIKE', '%'.$keyWord.'%');
                })
                ->select('users.*','persons.*','departments.*','users.id as userid','users.estado as UserEstado')
                ->paginate(10),
            'departments' => $departmentt,
            'groups' => $grup,
            'roles' => $roles,

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
        $this->rol_option = null;


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

        $user = User::create([ 
			'email' => $this-> email,
            'cedula'    => $this-> cedula,
            'password' => Hash::make($this-> cedula),
            'persona_id' => $pers->id,
            'deparment_id' => $this-> department,
            'group_id' => $this-> grupo,
            'estado' => 'ACTIVO'
        ]);

        $user->assignRole($this-> rol_option);


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
        $this->cedula = $record-> cedula;
        $this->rol_option = $record->roles[0]->name;

        $this->updateMode = true;
    }

    public function update(Request $request)
    {
        $this->validate([
            'name' => 'required',
            'cedula' => 'required',
            'email' => 'required',
            'last_name' => 'required'
        ]);

        $datarol = DB::table('roles')->where('name','=',$this-> rol_option)->select('roles.*')->get();

        if ($this->selected_id) {

			$record = User::find($this->selected_id);
            $record->update([ 
			     'email' => $this-> email,
                 'cedula'    => $this-> cedula
            ]);

            $record2 = Person::find($this->selected_id);
            $record2->update([ 
                'name'      => $this-> name,
                'last_name' => $this-> last_name,
                'cedula'    => $this-> cedula
            ]);

            DB::table('model_has_roles')
                    ->where('model_id','=',$this->selected_id)
                    ->update(
                        ['role_id' => $datarol[0]->id]
                    );

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

    public function habilitar($id)
    {
        if ($id) {

            $record = User::find($id);
            $record->update([ 
                'estado' => 'ACTIVO',
            ]);
        }
    }

    public function limitarCedula()
    {
        $this->cedula = substr($this->cedula, 0, 10);
    }


}
