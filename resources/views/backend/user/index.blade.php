@extends('backend.main')

@section('content')
    {{$dataTable->table()}}
@endsection

@push('js')
    {{$dataTable->scripts()}}
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush
