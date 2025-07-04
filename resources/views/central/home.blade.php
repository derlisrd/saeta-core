@extends('layouts.app') 

@include('layouts.mainmenu')

@section('content') 
<section class='px-4'>
    <h1 class=" text-center text-5xl font-bold my-10 text-gray-700 dark:text-gray-100">Tu propia tienda en linea</h1>
    <p class='text-center text-lg dark:text-gray-100  text-gray-700'>
        Crea tu tienda online, mejora cómo compran tus clientes y maneja todo de forma fácil y segura.
    </p>
    <div class="flex justify-center my-5">
        <a href="{{ route('signup') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-4 rounded-full my-10">
            Empezar gratis ahora
        </a>
    </div>
</section>
@endsection