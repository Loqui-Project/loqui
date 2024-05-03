export default () => ({
    share: async (user) => {
        try {
            if (
                await navigator.canShare({
                    url: user.url,
                    title: user.name,
                    text: user.name,
                })
            ) {
                await navigator.share({
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
