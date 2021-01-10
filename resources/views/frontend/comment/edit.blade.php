@extends('frontend.main')

@section('content')
    <livewire:edit-comment-user :comment="$comment"/>
    @if(Session::has('comment_edited'))
        <input type="hidden" name="comment_edited">
    @endif
@endsection

@push('js')
    <script src="{{ asset('js/comments.js') }}"></script>
@endpush
