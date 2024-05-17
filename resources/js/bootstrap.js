import axios from 'axios';
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'
import share from "./share"
import showSidebar from "./show-sidebar"

window.Swal = Swal;
window.axios = axios;
window.Alpine.data("share", share);
window.Alpine.store("showSidebar", showSidebar);
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
