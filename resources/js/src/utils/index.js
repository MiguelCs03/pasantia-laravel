import Vue from 'vue'

export default {
    dateFormat(date) {
        let fecha = Vue.moment().format('DD-MM-YYYY')
        if(date != null) fecha = Vue.moment(date).format('DD-MM-YYYY')

        return fecha
    },

    dateYear(date) {
        let edad = 0

        if(date != null) {
            let today = Vue.moment()
            let birthDate = Vue.moment(date, 'YYYY-MM-DD')
            edad = today.diff(birthDate, 'years')
        }

        return edad
    }
}