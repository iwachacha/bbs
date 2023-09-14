import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import { en, ja } from 'vuetify/locale'
import { mdi, aliases } from 'vuetify/iconsets/mdi-svg'
import { VStepper } from 'vuetify/labs/VStepper'

export const vuetify = createVuetify({
    components: {
        VStepper
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
    locale: {
        locale: 'ja',
        fallback: 'en',
        messages: { ja },
    },
})