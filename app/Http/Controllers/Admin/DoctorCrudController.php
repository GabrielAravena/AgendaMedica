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

        CRUD::addField([
            'name' => '1',
            'type' => 'checkbox',
            'label' => 'Lunes',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde1',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta1',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '2',
            'type' => 'checkbox',
            'label' => 'Martes',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde2',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta2',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '3',
            'type' => 'checkbox',
            'label' => 'Miércoles',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde3',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta3',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '4',
            'type' => 'checkbox',
            'label' => 'Jueves',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde4',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta4',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '5',
            'type' => 'checkbox',
            'label' => 'Viernes',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde5',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta5',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '6',
            'type' => 'checkbox',
            'label' => 'Sábado',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde6',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta6',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '7',
            'type' => 'checkbox',
            'label' => 'Domingo',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde7',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta7',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);


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
        dd($this->crud);
        CRUD::setValidation(DoctorRequest::class);

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

        CRUD::addField([
            'name' => '1',
            'type' => 'checkbox',
            'label' => 'Lunes',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde1',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta1',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '2',
            'type' => 'checkbox',
            'label' => 'Martes',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde2',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta2',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '3',
            'type' => 'checkbox',
            'label' => 'Miércoles',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde3',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta3',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '4',
            'type' => 'checkbox',
            'label' => 'Jueves',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde4',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta4',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '5',
            'type' => 'checkbox',
            'label' => 'Viernes',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde5',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta5',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '6',
            'type' => 'checkbox',
            'label' => 'Sábado',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde6',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta6',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);

        CRUD::addField([
            'name' => '7',
            'type' => 'checkbox',
            'label' => 'Domingo',
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-6 mt-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'desde7',
            'label'   => 'Desde',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
        CRUD::addField([
            'name'    => 'hasta7',
            'label'   => 'Hasta',
            'type'    => 'select_from_array',
            'options' => $horas_array,
            'tab' => 'Horarios',
            'wrapper' => [
                'class' => 'form-group col-md-3',
            ],
        ]);
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
}
