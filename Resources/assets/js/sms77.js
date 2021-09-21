require('./../../../../../resources/assets/js/bootstrap')

import Vue from 'vue'

import Global from './../../../../../resources/assets/js/mixins/global'
import Form from './../../../../../resources/assets/js/plugins/form'
import DashboardPlugin
    from './../../../../../resources/assets/js/plugins/dashboard-plugin'

Vue.use(DashboardPlugin)

new Vue({
    computed: {
        isSMS() {
            return 'sms' === this.msgType
        },
        msgType() {
            return this.form.sms77_msg_type
        },
        maxTextLength() {
            return this.isSMS ? 1520 : 10000
        }
    },

    data() {
        return {
            form: new Form('sms77_msg'),
        }
    },

    el: '#app',

    mixins: [
        Global
    ],
})
