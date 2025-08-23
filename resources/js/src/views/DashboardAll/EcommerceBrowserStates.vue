<template>
  <b-card
    no-body
    class="card-browser-states"
  >
    <b-card-header>
      <div>
        <b-card-title>Comparativo de Presuspuesto</b-card-title>
        <b-card-text class="font-small-2">
          MARZO 2022
        </b-card-text>
      </div>

      <b-dropdown
        variant="link"
        no-caret
        class="chart-dropdown"
        toggle-class="p-0"
      >
        <template #button-content>
          <feather-icon
            icon="MoreVerticalIcon"
            size="18"
            class="text-body cursor-pointer"
          />
        </template>
        <b-dropdown-item href="#">
          ENERO
        </b-dropdown-item>
        <b-dropdown-item href="#">
          FEBRERO
        </b-dropdown-item>
        <b-dropdown-item href="#">
          MARZO
        </b-dropdown-item>
      </b-dropdown>
    </b-card-header>

    <b-card-body>
       
      <div
        v-for="(browser,index) in browserData"
        :key="browser.browserImg"
        class="browser-states" >

        <b-media no-body >
          <b-media-aside class="mr-1">
            <b-img
              :src="browser.browserImg"
              alt="browser img"
            />
          </b-media-aside>
          <b-media-body>
            <h6 class="align-self-center my-auto">
              {{ browser.name }}
            </h6>
          </b-media-body>
        </b-media>
       
          <div class="d-flex align-items-center" >
            <span class="font-weight-bold text-body-heading mr-1">{{ browser.cantidad }}</span>
          
          </div>

            <div class="d-flex align-items-center">
              <span class="font-weight-bold text-body-heading mr-1">{{browser.porcentaje }}</span>
            </div>

          <div class="d-flex align-items-center">
            <span class="font-weight-bold text-body-heading mr-1">{{ browser.usage }}</span>
            <vue-apex-charts
              type="radialBar"
              height="80"
              width="80"
              :options="chartData[index].options"
              :series="chartData[index].series"
            />
        </div>
      </div>
    </b-card-body>
    <!--/ body -->
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardTitle, BCardText, BCardBody, BMedia, BMediaAside, BMediaBody, BImg, BDropdown, BDropdownItem,
} from 'bootstrap-vue'
import VueApexCharts from 'vue-apexcharts'
import { $themeColors } from '@themeConfig'

/* eslint-disable global-require */
const $trackBgColor = '#e9ecef'
export default {
  components: {
    BCard,
    BCardHeader,
    BCardTitle,
    BCardText,
    BCardBody,
    BMedia,
    BMediaAside,
    BMediaBody,
    BImg,
    BDropdown,
    BDropdownItem,
    VueApexCharts,
  },
  data() {
    return {
      chartData: [],
      chartClone: {},
      chartColor: [$themeColors.primary, $themeColors.warning, $themeColors.secondary, $themeColors.info, $themeColors.danger],
      chartSeries: [54.4, 6.1, 14.6, 4.2, 8],
      browserData: [
        {
          browserImg: require('@/assets/images/icons/google-chrome.png'),
          name: 'INDEFINIDOS',
          usage: '280',
          cantidad: '279',
          porcentaje:'99,6',

        },
        {
          browserImg: require('@/assets/images/icons/mozila-firefox.png'),
          name: 'TEMPORALES',
          usage: '42',
            cantidad: '29',
            porcentaje:'69,0' 
        },
        {
          browserImg: require('@/assets/images/icons/apple-safari.png'),
          name: 'a Plazo Fijo',
          usage: '0',
          cantidad: '0',
          porcentaje:'0',
        },
        
      ],
      chart: {
        series: [65],
        options: {
          grid: {
            show: false,
            padding: {
              left: -15,
              right: -15,
              top: -12,
              bottom: -15,
            },
          },
          colors: [$themeColors.RED],
          plotOptions: {
            radialBar: {
              hollow: {
                size: '35%',
              },
              track: {
                background: $trackBgColor,
              },
              dataLabels: {
                showOn: 'always',
                name: {
                  show: false,
                },
                value: {
                  show: true,
                },
              },
            },
          },
          stroke: {
            lineCap: 'round',
          },
        },
      },
    }
  },
  created() {
    for (let i = 0; i < this.browserData.length; i += 1) {
      const chartClone = JSON.parse(JSON.stringify(this.chart))
      chartClone.options.colors[0] = this.chartColor[i]
      chartClone.series[0] = this.chartSeries[i]
      this.chartData.push(chartClone)
    }
  },
}
</script>
