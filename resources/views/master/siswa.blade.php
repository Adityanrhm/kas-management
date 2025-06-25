@extends('layouts.app')

@section('content')
    <livewire:dynamic-table :model="\App\Models\User::class" :columns="[
        ['field' => 'username', 'label' => 'Username'],
        ['field' => 'email', 'label' => 'Email'],
        ['field' => 'roles.name', 'label' => 'Role'],
    ]" :filter="['roles_id' => 3]" :with="['roles']" />
@endsection
