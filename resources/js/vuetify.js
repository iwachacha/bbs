import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import colors from 'vuetify/lib/util/colors'
import { en, ja } from 'vuetify/locale'
import { mdi, aliases } from 'vuetify/iconsets/mdi-svg'
import { VStepper } from 'vuetify/labs/VStepper'

export const vuetify = createVuetify({
    theme: {
        themes: {
            light: {
            dark: false,
                colors: {
                    primary: colors.teal.lighten1, //#26A69A
                    secondary: colors.grey.lighten4, //#F5F5F5
                }
            },
        },
    },
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