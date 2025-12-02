import './bootstrap'
import { createApp } from 'vue'

// Auto-register Vue components (Vue 3 + Vite)
const components = import.meta.glob('./components/**/*.vue', { eager: true })

const app = createApp({
    data() {
        return {
            user: window.User,
        }
    },
})

// Register all components automatically
for (const path in components) {
    const name = path
        .split('/')
        .pop()
        .replace('.vue', '')
        .toLowerCase()

    app.component(name, components[path].default)
}

app.mount('#app')
