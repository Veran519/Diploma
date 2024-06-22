{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-users"></i> Пользователи</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-list"></i> Категории</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-shopping-cart"></i> Товары</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}"><i class="nav-icon la la-cart-arrow-down"></i> Заказы</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('feedback') }}"><i class="nav-icon la la-phone-square"></i> Обратная связь</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('review') }}"><i class="nav-icon la la-pencil"></i> Отзывы</a></li>