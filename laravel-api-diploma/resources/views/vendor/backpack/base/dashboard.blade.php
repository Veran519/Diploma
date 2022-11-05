@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type' => 'card',
        'wrapper' => ['class' => 'd-inline-block w-25'],
        'class' => 'card text-white bg-primary mb-2',
        'content'     => [
            'header' => 'Количество цветов всего: ',
            'body' => $productCount    
        ],  
    ];
@endphp

@php
    $widgets['before_content'][] = [
        'type' => 'card',
        'wrapper' => ['class' => 'd-inline-block w-25'],
        'class' => 'card text-white bg-primary mb-2',
        'content'     => [
            'header' => 'header',
            'body' => 'body'    
        ],  
    ];
@endphp

@php
    $widgets['before_content'][] = [
        'type' => 'card',
        'wrapper' => ['class' => 'd-inline-block w-25'],
        'class' => 'card text-white bg-primary mb-2',
        'content'     => [
            'header' => 'header',
            'body' => 'body'    
        ],  
    ];
@endphp

@php
    $widgets['before_content'][] = [
        'type' => 'progress',
        'wrapper' => ['class' => 'w-25'],
        'class' => 'card text-white bg-info mb-2',
        'description' => 'Товаров всего в наличии',
        'progress' => 60,
        'hint' => 'Подсказка тебе'  
    ];
@endphp

@section('content')
    <p>Административная модель магазина:</p>
@endsection