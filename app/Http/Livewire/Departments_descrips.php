<?php

namespace App\Http\Livewire;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Departments_descrip;
use App\Models\Group;
use App\Models\User;
use App\Models\Person;
use App\Models\Department;
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

        $userss = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.persona_id')
            ->join('departments', 'departments.id', '=', 'users.deparment_id')
            ->where('users.estado','=','ACTIVO','AND')
            ->where('users.id','!=',1)
            ->select('persons.*','departments.*','persons.id as idperson','departments.id as idpersondepar')
            ->get();

        $departamento = Department::where('estado', 'ACTIVO')->get();

        $datos = [
            'departma' => $departamento,
            'opciones' => $userss,
        ];

        return view('livewire.departments_descrips.view', [

            'Departments_descrips' => DB::table('departments_descrip')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users', 'users.id', '=', 'departments_descrip.usuario_asignado')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->where('departments_descrip.old_new','!=',2)
                ->select('departments.namedt as nombredepartamento','persons.*','departments_descrip.*')
                ->where(function ($query) use ($keyWord) {
                    $query->where('departments_descrip.subtarea_descrip', 'LIKE', $keyWord);
                })
                ->paginate(10),
            'datos' => $datos,

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
			'estado' => 'ACTIVO',
            'old_new' => '1'

        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Registro creado con exito.');
    }

    public function edit($id)
    {
        $record  = Departments_descrip::findOrFail($id);
        $record2 = Person::findOrFail($record->usuario_asignado);
        $record3 = Department::findOrFail($record->departments_id);

        $this->selected_id = $id; 
        $this->departments_id = $record3-> namedt;
        $this->subtarea_descrip = $record-> subtarea_descrip;
        $this->usuario_asignado = $record2-> name .' '.$record2-> last_name;
		$this->tiempo_demora = $record-> tiempo_demora;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
    		'subtarea_descrip' => 'required',
    		'tiempo_demora' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Departments_descrip::find($this->selected_id);
            $record->update([ 
    			'subtarea_descrip' => $this-> subtarea_descrip,
    			'tiempo_demora' => $this-> tiempo_demora
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Registro actualizado con exito.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Departments_descrip::where('id', $id);
            $record->update([ 
                'estado' => 'INACTIVO',
            ]);

        }
    }

    public function habilitar($id)
    {
        if ($id) {

            $record = Departments_descrip::where('id', $id);
            $record->update([ 
                'estado' => 'ACTIVO',
            ]);
        }
    }
    
}
