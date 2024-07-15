import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

/**
 * 
 * @param {string} title 
 * @param {NotificationOptions} notificationOptions 
 */
function showNotification(title, notificationOptions) {
    if (!("Notification" in window)) {
        // Check if the browser supports notifications
        alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
        // Check whether notification permissions have already been granted;
        // if so, create a notification
        return new Notification(title, notificationOptions);
    } else if (Notification.permission !== "denied") {
        // We need to ask the user for permission
        Notification.requestPermission().then((permission) => {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                return new Notification(title, notificationOptions);
            }
        });
    }
    console.log(Notification.permission);
}
window.Echo.private(`user.${window.App.user}`).notification((notification) => {
    console.log(notification);
    showNotification(notification.title, {
        icon: '/android-chrome-512x512.png',
    }).onclick = () => {
        window.location.href = notification.url;
    };

});