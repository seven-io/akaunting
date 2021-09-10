require('./../../../../../resources/assets/js/bootstrap')

import Vue from 'vue'

import Global from './../../../../../resources/assets/js/mixins/global'
import Form from './../../../../../resources/assets/js/plugins/form'
import DashboardPlugin
    from './../../../../../resources/assets/js/plugins/dashboard-plugin'

Vue.use(DashboardPlugin)

new Vue({
    computed: {
        msgType() {
            return this.form.sms77_msg_type
        },
        maxTextLength() {
            return 'sms' === this.msgType ? 1520 : 10000
        }
    },

    data() {
        return {
            form: new Form('sms77_msg'),
            maxTextLengthh: 1520,
        }
    },

    el: '#app',

    mixins: [
        Global
    ],
})
