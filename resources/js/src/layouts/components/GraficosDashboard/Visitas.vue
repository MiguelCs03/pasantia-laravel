<template>
    <div>

        <apexchart type="line" height="500" :options="chartOptions" :series="series"></apexchart>

    </div>
</template>

<script>
import apexchart from 'vue-apexcharts'

export default {
    name: 'Visitas',

    components: {
        apexchart
    },

    props: {
        visitas: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            series: [
                {name: 'Visitas Efectivas', type: 'column', data: []},
                {name: 'Visitas del Día', type: 'area', data: []},
            ],

            chartOptions: {
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    formatter: function (val, opts) {
                        return val
                    },
                },
                chart: {
                    height: 500,
                    type: 'line',
                    stacked: false,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                stroke: {
                    width: [0, 2, 5],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '70%'
                    }
                },                
                fill: {
                    opacity: [0.85, 0.25, 1],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: "vertical",
                        opacityFrom: 0.85,
                        opacityTo: 0.55,
                        stops: [0, 100, 100, 100]
                    }
                },
                labels: [],
                markers: {
                    size: 0
                },
                xaxis: {
                    type: 'date',
                    labels : {
                        style: {
                            colors: '#FFFFFF',
                            fontSize: '12px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 400,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    }
                },
                yaxis: {
                    title: {
                        text: 'Visitas',
                        style: {
                            color: '#FFFFFF'
                        }
                    },
                    min: 0,
                    labels : {
                        style: {
                            colors: '#FFFFFF',
                            fontSize: '12px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 400,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    }
                },
                legend: {
                    show: true,
                    labels: {
                        colors: ["#fff"],
                    },
                },
                tooltip: {
                    enabled: true,
                    theme: "dark",
                    shared: true,
                    intersect: false,
                    y:  {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0) + " visitas";
                            }
                            return y;                            
                        }
                    }
                }
            },
        }
    },

    watch: {
        visitas: {
            handler(newVal, oldVal) {
                this.actualizarSeries(newVal);
            },
            immediate: true
        }
    },

    methods: {
        actualizarSeries(data) {
            const labels = data.map(row => this.$moment(row['fecha']).format('DD-MM-YYYY'))
            const visitasEfectivas = data.map(row => row['metas'])
            const visitasDia = data.map(row => row['visitas'])

            this.chartOptions.labels[0] = labels[0]

            for (let index = 1; index < labels.length; index++) {
                this.chartOptions.labels[index] = labels[index]
            }

            this.series = [
                { name: 'Visitas Efectivas', type: 'column', data: visitasEfectivas },
                { name: 'Visitas del Día', type: 'area', data: visitasDia },
            ];
        }
    },
}
</script>