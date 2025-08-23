<template>
    <div>

        <apexchart type="pie" height="315" :options="chartOptions" :series="series"></apexchart>

        <div class="d-flex justify-content-center">
            <b-avatar size="45px" style="background-color: #F29441;">
                <span> {{ organizacion }} </span>
            </b-avatar>
            <b-avatar size="45px" style="background-color: #0066CC;" class="mx-1">
                <span> {{ persona }} </span>
            </b-avatar>
            <b-avatar size="45px" style="background-color: #F29441;">
                <span> {{ porcentaje(organizacion, persona, 1) }}% </span>
            </b-avatar>
            <b-avatar size="45px" style="background-color: #0066CC;" class="ml-1">
                <span> {{ porcentaje(organizacion, persona, 2) }}% </span>
            </b-avatar>
        </div>

    </div>
</template>

<script>
import apexchart from 'vue-apexcharts'

export default {
    name: 'PorTipo',

    components: {
        apexchart
    },

    props: {
        persona: {
            type: Number,
            required: true
        },
        organizacion: {
            type: Number,
            required: true
        },
    },

    data() {
        return {
            series: [50, 50],
            chartOptions: {
                chart: {
                    height: 315,
                    type: 'pie',
                },
                legend: {
                    show: true,

                    labels: {
                        colors: ["#FFFFFF"],
                    },
                    horizontalAlign: 'center',
                    position: 'top'
                },
                labels: ['ORGANIZACIÓN', 'PERSONA'],
                colors: ['#F29441', '#0066CC']
            },
        }
    },

    watch: {
        persona: function(newPersona, oldPersona) {
            this.actualizarSeries();
        },
        organizacion: function(newOrganizacion, oldOrganizacion) {
            this.actualizarSeries();
        }
    },

    methods: {
        actualizarSeries() {
            this.series = [this.organizacion, this.persona];
        },
        porcentaje(org, per, tipo) {
            let total = org + per
            let resultado = 0

            if(org > 0 && per > 0) {
                if(tipo == 1) resultado = (org * 100) / total
                else resultado = (per * 100) / total

                resultado = resultado.toFixed(1)
            }
            
            return resultado
        }
    }
}
</script>