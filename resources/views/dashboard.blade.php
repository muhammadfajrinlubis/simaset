@extends('layouts.app')

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/plugin.css') }}">
@endpush

@section('content')

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
