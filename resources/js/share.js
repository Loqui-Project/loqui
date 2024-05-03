export default () => ({
    share: (user) => {
        try {
            if (
                navigator.canShare({
                    url: user.url,
                    title: user.name,
                    text: user.name,
                })
            ) {
                navigator.share({
                    url: user.url,
                    title: user.name,
                    text: user.name,
                });
            }
        } catch (error) {
            console.error("Error sharing", error);
        }
    },
});
