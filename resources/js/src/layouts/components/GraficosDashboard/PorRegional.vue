<template>
    <div>

        <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>

    </div>
</template>

<script>
import apexchart from 'vue-apexcharts'

export default {
    name: 'PorRegional',

    components: {
        apexchart
    },

    props: {
        regional: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            series: [{data: [400, 430, 448, 470, 540, 580, 500]}],
            chartOptions: {
                chart: {
                    type: "bar",
                    height: 350,
                    stacked: true,
                    stackType: "normal",
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                legend: {
                    show: false,
                },
                tooltip: {
                    theme: "dark",
                    x: {
                        show: true,
                    },
                    y: {
                        title: {
                            formatter: function () {
                                return " (N° de PDV): ";
                            },
                        },
                    },
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                        distributed: true,
                    },
                },
                xaxis: {
                    categories: [],
                    dataLabels: {
                        enabled: true,
                        textAnchor: "middle",
                        style: {
                            colors: "#FFFFFF",
                        },
                        dropShadow: {
                            enabled: true,
                        },
                    },
                    labels: {
                        style: {
                            colors: "#FFFFFF",
                            fontSize: "11px",
                            fontFamily: "Helvetica, Arial, sans-serif",
                        },
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: "#FFFFFF",
                            fontSize: "12px",
                            fontFamily: "Helvetica, Arial, sans-serif",
                            fontWeight: 40,
                            cssClass: "apexcharts-xaxis-label",
                        },
                    },
                    tooltip: {
                        enabled: true,
                    },
                },
            },
        }
    },

    watch: {
        regional: {
            handler: 'actualizarRegional',
            immediate: true
        }
    },

    methods: {
        actualizarRegional() {
            const series = []
            const labels = []

            this.regional.forEach(item => {
                series.push(item.valor)
                labels.push(item.nombre)
            })

            this.series = [{ data: series }]
            this.chartOptions = {
                ...this.chartOptions,
                xaxis: {
                    ...this.chartOptions.xaxis,
                    categories: labels
                }
            }
        }
    }
}
</script>