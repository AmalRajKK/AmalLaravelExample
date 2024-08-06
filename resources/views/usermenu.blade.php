<x-layout>
    <x-slot:title>User Menu</x-slot:title>
    <x-slot:heading>User Menu</x-slot:heading>
    <h1>WELCOME:{{Auth::user()->name }}</h1>
    <h1>USER Id:{{ Auth::user()->email}}</h1>
    <h1>BALANCE:{{ $account->balance}}</h1>
</x-layout>
