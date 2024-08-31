import axios from "axios";
import Swal from "sweetalert2";
import "sweetalert2/src/sweetalert2.scss";
import showSidebar from "./show-sidebar";
import * as Sentry from "@sentry/browser";
import Clipboard from "@ryangjchandler/alpine-clipboard"; // Import it
window.Alpine.plugin(Clipboard); // Register the plugin
window.Alpine.store("showSidebar", showSidebar);
window.Alpine.bind("shareButton", (title, url) => ({
    type: "button",
    "@click"(e) {
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
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});