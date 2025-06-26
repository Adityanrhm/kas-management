@extends('layouts.app')

@section('content')
    <div class="mx-6 my-6">
        <x-dynamic-table :model="\App\Models\User::class" :columns="[
            ['field' => 'username', 'label' => 'Username'],
            ['field' => 'email', 'label' => 'Email'],
            ['field' => 'role.name', 'label' => 'Role'],
        ]" :filter="['role_id' => 3]" :with="['role']">
            <h2 class="text-xl font-semibold text-white">Data Siswa</h2>
        </x-dynamic-table>
    </div>
@endsection
