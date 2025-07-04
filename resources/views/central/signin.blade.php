@extends('layouts.app')

@include('layouts.loginmenu')

@section('content')
<main class="flex items-center justify-center bg-gray-100 dark:bg-dark">
    <div class="max-w-md w-full p-8 bg-white dark:bg-dark rounded-xl shadow-lg border border-gray-400">
        <h1 class="text-center text-xl font-extrabold text-gray-900 dark:text-white uppercase">
            Iniciar sesión
        </h1>
        <form class="mt-8 space-y-6" action="{{ route('signin') }}" method="POST">
            @csrf
           <div class='flex flex-col gap-3'>
            <input type='email' name='email' placeholder='Correo' class='text-sm p-2 rounded-lg placeholder:text-gray-500 w-full dark:bg-dark border border-gray-500 text-black dark:text-white' required />
            <input type='password' name='password' placeholder='Contrasena' class='text-sm p-2 rounded-lg placeholder:text-gray-500 w-full dark:bg-dark border border-gray-500 text-black dark:text-white' required />
            <button type='submit' class='bg-green-800 hover:bg-green-600 transition-colors ease-in-out duration-200 text-white font-bold py-2 px-4 rounded-lg w-full'>Iniciar sesión</button>
        </div>
        </form>
    </div>
</main>
@endsection
