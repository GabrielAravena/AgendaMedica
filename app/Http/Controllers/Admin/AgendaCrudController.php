<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AgendaRequest;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Especialidad;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AgendaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AgendaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Agenda::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/agenda');
        CRUD::setEntityNameStrings('agenda', 'agendas');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns
        CRUD::filters();

        CRUD::addColumn([  
            'name'         => 'user', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Paciente', // Table column heading
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => App\Models\User::class, // foreign key model
            'searchLogic' => function ($query, $column, $searchTerm) {
                $users = User::where('name', 'like', "%".$searchTerm."%")->get();
                if($users != null){
                    foreach($users as $user){
                        $query->orWhere('user_id', $user->id);
                    }
                }
            }
         ]);
         CRUD::addColumn([  
            'name'         => 'email', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Email', // Table column heading
            'entity'    => 'user', // the method that defines the relationship in your Model
            'attribute' => 'email', // foreign key attribute that is shown to user
            'model'     => App\Models\User::class, // foreign key model
            'searchLogic' => function ($query, $column, $searchTerm) {
                $users = User::where('email', 'like', "%".$searchTerm."%")->get();
                if($users != null){
                    foreach($users as $user){
                        $query->orWhere('user_id', $user->id);
                    }
                }
            }
         ]);
         CRUD::addColumn([  
            'name'         => 'doctor', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Doctor', // Table column heading
            'entity'    => 'doctor', // the method that defines the relationship in your Model-{ñ}
            'attribute' => 'nombre', // foreign key attribute that is shown to user
            'model'     => App\Models\Doctor::class, // foreign key model
            'searchLogic' => function ($query, $column, $searchTerm) {
                $doctores = Doctor::where('nombre', 'like', "%".$searchTerm."%")->get();
                if($doctores != null){
                    foreach($doctores as $doctor){
                        $query->orWhere('doctor_id', $doctor->id);
                    }
                }
            }
         ]);
         CRUD::addColumn([  
            'name'         => 'especialidad', // name of relationship method in the model
            'type'         => 'closure',
            'label'        => 'Especialidad', // Table column heading
            'function'        => function($entry){
                return Doctor::where('id', $entry->doctor_id)->first()->especialidad->nombre;
            },
            'searchLogic' => function ($query, $column, $searchTerm) {
                $especialidad = Especialidad::where('nombre', 'like', "%".$searchTerm."%")->first();
                if($especialidad != null){
                    $doctors = $especialidad->doctors;
                    foreach($doctors as $doctor){
                        $query->orWhere('doctor_id', $doctor->id);
                    }
                }
            }
         ]);
         CRUD::addColumn([  
            'name'         => 'fecha', // name of relationship method in the model
            'type'         => 'date',
            'label'        => 'Fecha',
         ]);
         CRUD::addColumn([  
            'name'         => 'hora', // name of relationship method in the model
            'type'         => 'datetime',
            'label'        => 'Hora',
            'format'       => 'HH:mm',
         ]);
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
        CRUD::setValidation(AgendaRequest::class);

        CRUD::setFromDb(); // fields

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
        $this->setupCreateOperation();
    }
}
