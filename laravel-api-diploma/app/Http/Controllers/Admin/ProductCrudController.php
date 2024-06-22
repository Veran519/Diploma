<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('товар', 'товары');
        $this->crud->orderBy('created_at', "DESC");
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('sort')->label('Сортировка');
        CRUD::column('name')->label('Наименование товара');
        CRUD::column('price')->label('Цена');
        /*CRUD::column('pricture')->type('image')->label('Фото букета');*/
        $this->crud->addColumn([
            'name'  => 'picture',
            'label' => 'Фото букета',
            'type'  => 'image',
            'prefix' => '/storage/'
        ]);
        CRUD::column('description')->label('Описание');
        $this->crud->addColumn([
            'name'  => 'isActual',
            'label' => 'Актуальность',
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name'  => 'isAvailable',
            'label' => 'Можем повторить?',
            'type'  => 'boolean',
        ]);
        /*CRUD::column('category_id')->label('Категория');*/
        $this->crud->addColumn([
            'name'  => 'category_id',
            'label' => 'Категория',
            'type'  => 'select',
            'entity' => 'category',
            'model' => 'App\Models\Category',
            'attribute' => 'name'
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
        CRUD::setValidation(ProductRequest::class);

        CRUD::field('sort')->label('Сортировка');
        CRUD::field('name')->label('Наименование товара');
        CRUD::field('price')->type('number')->label('Цена');
        $this->crud->addField([
            'name'  => 'picture',
            'label' => 'Фото букета',
            'type'  => 'upload',
            'upload' => true,
            'disk' => 'public'
        ]);
        CRUD::field('description')->label('Описание');
        $this->crud->addField([
            'name'  => 'isActual',
            'label' => 'Актуальность',
            'type'  => 'boolean',
        ]);
        $this->crud->addField([
            'name'  => 'isAvailable',
            'label' => 'Можем повторить?',
            'type'  => 'boolean',
        ]);
        $this->crud->addField([
            'label' => 'Категория',
            'type' => 'select',
            'name' => 'category_id',
            'model' => 'App\Models\Category',
            'attribute' => 'name'
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
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('sort')->label('Сортировка');
        CRUD::column('name')->label('Наименование товара');
        CRUD::column('price')->label('Цена');
        //CRUD::column('pricture')->type('image')->label('Фото букета');
        $this->crud->addColumn([
            'name'  => 'picture',
            'label' => 'Фото букета',
            'type'  => 'image',
            'prefix' => '/storage/'
        ]);
        CRUD::column('description')->label('Описание');
        $this->crud->addColumn([
            'name'  => 'isActual',
            'label' => 'Актуальность',
            'type'  => 'boolean',
        ]);
        CRUD::column('category_id')->label('Категория');
    }
}
