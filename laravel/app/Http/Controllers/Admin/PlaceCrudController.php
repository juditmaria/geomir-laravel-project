<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlaceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    
    use \App\Traits\BackpackPermissions;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Place::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/place');
        CRUD::setEntityNameStrings('place', 'places');
        $this->_denyAccessIfNoPermission();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')
            ->label(__('fields.name'));
        CRUD::column('description')
            ->label(__('fields.description'));
        CRUD::column('file_id')
            ->label(__('fields.file'));
        CRUD::column('latitude')
            ->label(__('fields.latitude'));
        CRUD::column('longitude')
            ->label(__('fields.longitude'));
        CRUD::column('visibility_id')
            ->label(__('fields.visibility'));
        CRUD::column('author_id')
            ->label(__('fields.author'));

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
        CRUD::setValidation([
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility'  => 'required|exists:visibilities,id',
        ]);
        
        CRUD::field('name')
            ->label(__('fields.name'));
        CRUD::field('description')
            ->label(__('fields.description'));
        CRUD::field('file_id')
            ->label(__('fields.file'));
        CRUD::field('latitude')
            ->label(__('fields.latitude'));
        CRUD::field('longitude')
            ->label(__('fields.longitude'));
        CRUD::field('visibility_id')
            ->label(__('fields.visibility'));
        CRUD::field('author_id')
            ->label(__('fields.author'));

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
