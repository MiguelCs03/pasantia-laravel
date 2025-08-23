import Vue from 'vue'
import utils from './utils/index'
import i18n from '@/libs/i18n'
import router from './router'
import store from './store'
import App from './App.vue'
Vue.use(require('vue-moment'))

import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios, axios)
window.axios = axios

axios.defaults.baseURL = '/api/auth'
Vue.prototype.$utils = utils

import { ToastPlugin, ModalPlugin, BRow, BCol, BLink, BFormGroup, BFormInput, BInputGroupAppend, 
  BInputGroup, BFormCheckbox, BCardText, BCardTitle, BImg, BForm, BButton, BCard, BCardHeader, BTable,
  BCardBody, BBadge, VBTooltip, BFormSelect, BOverlay, BPagination, BSpinner, BFormDatepicker, BFormTextarea,
  BFormFile, BCollapse, VBToggle, BFormRadio, BAvatar, BMedia, BMediaAside, BMediaBody
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import * as validar from '@validations'
import Cleave from 'vue-cleave-component'
import flatPickr from 'vue-flatpickr-component'
import VueCompositionAPI from '@vue/composition-api'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import { ValidationProvider, ValidationObserver } from 'vee-validate'

// Axios Mock Adapter
import '@/@fake-db/db'
// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'
import '@/libs/sweet-alerts'

// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)

Vue.component('cleave', Cleave)

Vue.component('b-row', BRow)
Vue.component('b-col', BCol)
Vue.component('b-img', BImg)
Vue.component('b-link', BLink)
Vue.component('b-form', BForm)
Vue.component('b-card', BCard)
Vue.component('b-media', BMedia)
Vue.component('b-table', BTable)
Vue.component('b-badge', BBadge)
Vue.component('b-avatar', BAvatar)
Vue.component('b-button', BButton)
Vue.component('v-select', vSelect)
Vue.component('b-overlay', BOverlay)
Vue.component('b-spinner', BSpinner)
Vue.component('b-collapse', BCollapse)
Vue.component('flat-pickr', flatPickr)
Vue.component('vuexy-logo', VuexyLogo)
Vue.component('b-card-body', BCardBody)
Vue.component('b-card-text', BCardText)
Vue.component('b-form-file', BFormFile)
Vue.component('b-media-body', BMediaBody)
Vue.component('b-card-title', BCardTitle)
Vue.component('b-form-group', BFormGroup)
Vue.component('b-form-input', BFormInput)
Vue.component('b-form-radio', BFormRadio)
Vue.component('b-pagination', BPagination)
Vue.component('b-card-header', BCardHeader)
Vue.component('b-input-group', BInputGroup)
Vue.component('b-form-select', BFormSelect)
Vue.component('b-media-aside', BMediaAside)
Vue.component('b-form-checkbox', BFormCheckbox)
Vue.component('b-form-textarea', BFormTextarea)
Vue.component('b-form-datepicker', BFormDatepicker)
Vue.component('b-input-group-append', BInputGroupAppend)
Vue.component('validation-provider', ValidationProvider)
Vue.component('validation-observer', ValidationObserver)

Vue.directive('b-toggle', VBToggle)
Vue.directive('b-tooltip', VBTooltip)

Vue.mixin(togglePasswordVisibility)

// Composition API
Vue.use(VueCompositionAPI)

// import core styles
require('@resources/scss/core.scss')

// import assets styles
require('@resources/assets/scss/style.scss')

// Vue.config.productionTip = true
Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  render: h => h(App),
}).$mount('#app')
