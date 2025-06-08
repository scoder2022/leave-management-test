@extends('employee.layouts.app')

@push('css')
    <style>
        canvas {
            max-width: 100%;
            height: auto !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h3>Welcome Admin Leave Stats</h3>
        <div class="row mb-4">
            <div class="col">
                <div class="card bg-info text-white">
                    <div class="card-body">Total Leaves: {{ $totalLeaves }}</div>
                </div>
            </div>
        </div>

        {{-- Charts Side by Side --}}

        <div class="row">
            <div class="col-md-6">
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="typeChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

        {{-- <div style="color: rgb(30, 119, 97)" class="row"> --}}


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($leaveCountsByMonth->toArray())) !!},
            datasets: [{
                label: 'Leaves Per Month',
                data: {!! json_encode(array_values($leaveCountsByMonth->toArray())) !!},
                backgroundColor: 'rgb(30, 119, 97)'
            }]
        }
    });

    const leaveTypeLabels = {!! json_encode(array_keys($leaveCountsByType->toArray())) !!};
    const leaveTypeData = {!! json_encode(array_values($leaveCountsByType->toArray())) !!};

    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            colors.push(`rgb(${r}, ${g}, ${b})`);
        }
        return colors;
    }

    const typeChart = new Chart(document.getElementById('typeChart'), {
        type: 'pie',
        data: {
            labels: leaveTypeLabels,
            datasets: [{
                label: 'Leave Types',
                data: leaveTypeData,
                backgroundColor: generateColors(leaveTypeLabels.length)
            }]
        }
    });

</script>
@endpush
