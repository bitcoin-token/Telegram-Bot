@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Content Manager -->
    <content-manager></content-manager>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#create_start_date').flatpickr({
            dateFormat: "m/d/y"
        });
        $('#create_end_date').flatpickr({
            dateFormat: "m/d/y"
        });
        $('#edit_start_date').flatpickr({
            dateFormat: "m/d/y"
        });
        $('#edit_end_date').flatpickr({
            dateFormat: "m/d/y"
        });
    });
</script>
@endsection
