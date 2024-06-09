import axios from 'axios';
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'
import showSidebar from "./show-sidebar"
import * as Sentry from "@sentry/browser";
import Clipboard from '@ryangjchandler/alpine-clipboard' // Import it
window.Alpine.plugin(Clipboard) // Register the plugin
window.Alpine.store("showSidebar", showSidebar);
window.Alpine.bind("shareButton", (title, url) => ({
    type: 'button',
    '@click'(e) {
        console.log("tes2t", title, url)
        try {
            if (
                navigator.canShare({
                    url,
                    title,
                })
            ) {
                navigator.share({
                    url,
                    title,
                });
            }
        } catch (error) {
            console.error("Error sharing", error);
        }
    },
}));
window.Swal = Swal;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
