@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
    'type'        => 'jumbotron',
    'heading'     => 'Админ панель "Элен"!',
    'content'     => 'Для того, чтобы начать работу, используйте панель слева :)',
    'button_link' => backpack_url('logout'),
    'button_text' => 'Выйти',
    ];
@endphp

@php
    $widgets['before_content'][] = [
        'type' => 'card',
        'wrapper' => ['class' => 'd-inline-block w-25'],
        'class' => 'card text-white bg-primary mb-2',
        'content'     => [
            'header' => 'Количество букетов всего: ',
            'body' => \App\Models\Product::count(),    
        ],  
    ];
@endphp

@php
    $widgets['before_content'][] = [
        'type' => 'card',
        'wrapper' => ['class' => 'd-inline-block w-25'],
        'class' => 'card text-white bg-primary mb-2',
        'content'     => [
            'header' => 'Количество заказов всего: ',
            'body' => \App\Models\Order::count(),    
        ],  
    ];
@endphp




