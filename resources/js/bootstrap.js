import axios from 'axios';
import Alpine from "alpinejs";
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'
import share from "./share"
window.Swal = Swal;
window.axios = axios;

window.Alipne = Alpine;
window.Alpine.data("share", share);
window.Alpine.start();
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
