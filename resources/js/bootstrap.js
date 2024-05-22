import axios from 'axios';
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'
import showSidebar from "./show-sidebar"
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import Clipboard from '@ryangjchandler/alpine-clipboard' // Import it
Alpine.plugin(Clipboard) // Register the plugin
Alpine.store("showSidebar", showSidebar);
Alpine.bind("shareButton", (title, url) => ({
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
Livewire.start()
window.Swal = Swal;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
