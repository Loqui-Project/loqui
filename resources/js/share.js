export default () => ({
    type: "button",
    "@click"(title, url) {
        this.share();
    },
    share() {
        try {
            if (
                navigator.canShare({
                    url: "#",
                    title: "#",
                })
            ) {
                navigator.share({
                    url: "#",
                    title: "#",
                });
            }
        } catch (error) {
            console.error("Error sharing", error);
        }
    },
});
