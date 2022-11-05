<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('заказ', 'заказы');
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
        CRUD::column('id')->label('Номер заказа');
        CRUD::column('name')->label('Заказчик');
        CRUD::column('adress')->label('Адрес доставки');
        CRUD::column('phone')->type('phone')->label('Номер телефона');
        $this->crud->addColumn([
            'name'  => 'delivery',
            'label' => 'Доставка',
            'type'        => 'boolean',
            'options'     => [
                0 => 'Самовывоз',
                1 => 'Доставка'
            ]
        ]);
        CRUD::column('product_id')->label('Товар');

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
        CRUD::setValidation(OrderRequest::class);

        CRUD::field('name')->label('Имя заказчика');
        CRUD::field('adress')->label('Адрес доставки');
        CRUD::field('phone')->label('Номер телефона');
        $this->crud->addField([
            'name'  => 'delivery',
            'label' => 'Доставка',
            'type'        => 'radio',
            'options'     => [
                0 => 'Самовывоз',
                1 => 'Доставка'
            ]
        ]);
        $this->crud->addField([
            'label' => 'Товар',
            'type' => 'select',
            'name' => 'product_id',
            'model' => 'App\Models\Product',
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
        CRUD::column('id')->label('Номер заказа');
        CRUD::column('name')->label('Заказчик');
        CRUD::column('adress')->label('Адрес доставки');
        CRUD::column('phone')->type('phone')->label('Номер телефона');
        $this->crud->addColumn([
            'name'  => 'delivery',
            'label' => 'Доставка',
            'type'        => 'boolean',
            'options'     => [
                0 => 'Самовывоз',
                1 => 'Доставка'
            ]
        ]);
        CRUD::column('product_id')->label('Товар');
    }
}
