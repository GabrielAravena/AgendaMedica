<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DoctorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Hora;
use App\Models\Horario;
use App\Models\Especialidad;

/**
 * Class DoctorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DoctorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { 
        update as traitUpdate; 
    }    
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Doctor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/doctor');
        CRUD::setEntityNameStrings('Doctor', 'Doctores');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns
        $this->crud->filters();


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DoctorRequest::class);

        //CRUD::setFromDb(); // fields

        $horas = Hora::all()->pluck("hora");
        $horas_array = [];
        foreach ($horas as $hora) {
            $horas_array += [$hora => $hora];
        }
        
        CRUD::addField([
            'name' => 'nombre',
            'type' => 'text',
            'tab' => 'Personal'
        ]);
        CRUD::addField([
            'label'     => "Especialidad",
            'type'      => 'select2',
            'name'      => 'especialidad_id',
            'tab'       => 'Personal', 
            'entity'    => 'especialidad', 
            'model'     => "App\Models\Especialidad", 
            'attribute' => 'nombre', 
            'default'   => 1,
          ]);

          for ($i = 1; $i < 8; $i++) {
            CRUD::addField([
                'name' => $i,
                'value' => 0,
                'type' => 'checkbox',
                'label' => $this->getNombreDia($i),
                'tab' => 'Horarios',
                'wrapper' => [
                    'class' => 'form-group col-md-6 mt-3',
                ],
            ]);
            CRUD::addField([
                'name'    => 'desde'.$i,
                'label'   => 'Desde',
                'type'    => 'select_from_array',
                'options' => $horas_array,
                'tab' => 'Horarios',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ]);
            CRUD::addField([
                'name'    => 'hasta'.$i,
                'label'   => 'Hasta',
                'type'    => 'select_from_array',
                'options' => $horas_array,
                'tab' => 'Horarios',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ]);
        }


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(DoctorRequest::class);

        $horas = Hora::all()->pluck("hora");
        $horas_array = [];
        foreach ($horas as $hora) {
            $horas_array += [$hora => $hora];
        }

        $horarios = Horario::where('doctor_id', $this->crud->getCurrentEntry()->id)->get()->toArray();
        //dd($horarios);

        //dd(array_search(1, array_column($horarios, 'dia')));
        
        CRUD::addField([
            'name' => 'nombre',
            'type' => 'text',
            'tab' => 'Personal'
        ]);
        CRUD::addField([
            'label'     => "Especialidad",
            'type'      => 'select2',
            'name'      => 'especialidad_id',
            'tab'       => 'Personal', 
            'entity'    => 'especialidad', 
            'model'     => "App\Models\Especialidad", 
            'attribute' => 'nombre', 
            'default'   => 1,
        ]);

        for ($i = 1; $i < 8; $i++) {
            $key = array_search($i, array_column($horarios, 'dia'));
            if(!($key === false)){
                CRUD::addField([
                    'name' => $i,
                    'value' => 1,
                    'type' => 'checkbox',
                    'label' => $this->getNombreDia($i),
                    'tab' => 'Horarios',
                    'wrapper' => [
                        'class' => 'form-group col-md-6 mt-3',
                    ],
                ]);
                CRUD::addField([
                    'name'    => 'desde'.$i,
                    'value'   => $horarios[$key]["desde"],
                    'label'   => 'Desde',
                    'type'    => 'select_from_array',
                    'options' => $horas_array,
                    'tab' => 'Horarios',
                    'wrapper' => [
                        'class' => 'form-group col-md-3',
                    ],
                ]);
                CRUD::addField([
                    'name'    => 'hasta'.$i,
                    'value'   => $horarios[$key]["hasta"],
                    'label'   => 'Hasta',
                    'type'    => 'select_from_array',
                    'options' => $horas_array,
                    'tab' => 'Horarios',
                    'wrapper' => [
                        'class' => 'form-group col-md-3',
                    ],
                ]);
            }else {
                CRUD::addField([
                    'name' => $i,
                    'value' => 0,
                    'type' => 'checkbox',
                    'label' => $this->getNombreDia($i),
                    'tab' => 'Horarios',
                    'wrapper' => [
                        'class' => 'form-group col-md-6 mt-3',
                    ],
                ]);
                CRUD::addField([
                    'name'    => 'desde'.$i,
                    'label'   => 'Desde',
                    'type'    => 'select_from_array',
                    'options' => $horas_array,
                    'tab' => 'Horarios',
                    'wrapper' => [
                        'class' => 'form-group col-md-3',
                    ],
                ]);
                CRUD::addField([
                    'name'    => 'hasta'.$i,
                    'label'   => 'Hasta',
                    'type'    => 'select_from_array',
                    'options' => $horas_array,
                    'tab' => 'Horarios',
                    'wrapper' => [
                        'class' => 'form-group col-md-3',
                    ],
                ]);
            }
        }
    }

    public function store(DoctorRequest $request)
    {
        $response = $this->traitStore();
        $id = $this->crud->entry->id;

        for ($i = 1; $i < 8; $i++) {
            if ($request->$i) {
                Horario::create([
                    'doctor_id' => $id,
                    'dia' => $i,
                    'desde' => Request("desde".$i),
                    'hasta' => Request("hasta".$i),
                ]);
            }
        }

        return $response;
    }
    public function update(DoctorRequest $request)
    {
        $response = $this->traitUpdate();
        $id = $this->crud->entry->id;

        Horario::where('doctor_id', $id)->delete();
        //dd($request);
        for ($i = 1; $i < 8; $i++) {
            if ($request->$i) {
                Horario::create([
                    'doctor_id' => $id,
                    'dia' => $i,
                    'desde' => Request("desde".$i),
                    'hasta' => Request("hasta".$i),
                ]);
            }
        }

        return $response;
    }

    public function getNombreDia(int $dia){
        switch($dia){
            case 1:
                return 'Lunes';
            case 2:
                return 'Martes';
            case 3:
                return 'Miércoles';
            case 4:
                return 'Jueves';
            case 5:
                return 'Viernes';
            case 6:
                return 'Sábado';
            case 7:
                return 'Domingo';
            default:
                return null;
        }
    }
}
