@extends('backend.main')

@section('content')
    {{$dataTable->table()}}
@endsection

@push('js')
    {{$dataTable->scripts()}}
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush
