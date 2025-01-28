@extends('auth.layouts')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Statistika</h4>
                    </div>
                    <div class="card-body">
                        <div id="comboChart"></div> <!-- Chart container -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data for the chart
        var options = {
            chart: {
                height: 550,
                type: 'area', // Use line for area and bar combo
                stacked: false,
            },
            series: [
                {
                    name: 'Sotilganlar',
                    type: 'column', // Bar/Column data
                    data: @json($counterCounts) // Replace with dynamic data if needed
                },
                {
                    name: 'Aktivlar',
                    type: 'column', // Bar/Column data
                    data: @json($activeCounterCounts) // Replace with dynamic data if needed
                },
            ],
            stroke: {
                width: [0, 3],
                curve: 'smooth' // Smooth area line
            },
            plotOptions: {
                bar: {
                    columnWidth: '30%', // Adjust the width of the bars
                }
            },
            xaxis: {
                categories: @json($dealersName), // X-axis labels
            },
            yaxis: [
                {
                    seriesName: 'Sotilganlar',
                    axisTicks: { show: true },
                    axisBorder: {
                        show: true,
                        color: '#008FFB'
                    },
                    title: {
                        text: "Sotilganlar",
                        style: {
                            color: '#008FFB',
                        }
                    }
                },
                {
                    opposite: true,
                    seriesName: 'Aktiv',
                    axisTicks: { show: true },
                    axisBorder: {
                        show: true,
                        color: '#775DD0'
                    },
                    title: {
                        text: "Aktiv",
                        style: {
                            color: '#775DD0',
                        }
                    }
                }
            ],
            colors: ['#008FFB', '#775DD0'], // Set colors for series
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.25,
                    gradientToColors: undefined, // Array of colors for the gradient
                    inverseColors: true,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100],
                },
            },
            title: {
                text: 'Dillerlar',
                align: 'center'
            }
        };

        var chart = new ApexCharts(document.querySelector("#comboChart"), options);
        chart.render();
    </script>
@endsection
