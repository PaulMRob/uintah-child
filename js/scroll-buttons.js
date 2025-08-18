document.addEventListener("DOMContentLoaded", () => {
    const scrollWrappers = document.querySelectorAll(".scroll-wrapper");

    scrollWrappers.forEach(wrapper => {
        const container = wrapper.querySelector(".scroll-container");
        const leftBtn = wrapper.querySelector(".scroll-left");
        const rightBtn = wrapper.querySelector(".scroll-right");

        const scrollDistance = 800; 
        const scrollSpeed = parseInt(wrapper.dataset.scrollSpeed) || 500; 
        const autoScroll = parseInt(wrapper.dataset.autoScroll) || 0;

        //manual scrolling
        leftBtn.addEventListener("click", () => {
            container.scrollBy({ left: -scrollDistance, behavior: "smooth" });
        });

        rightBtn.addEventListener("click", () => {
            container.scrollBy({ left: scrollDistance, behavior: "smooth" });
        });

        //automatic scrolling
        if (autoScroll) {
            setInterval(() => {
                container.scrollBy({ left: scrollDistance, behavior: "smooth" });

                if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                    container.scrollTo({ left: 0, behavior: "smooth" });
                }
            }, scrollSpeed);
        }
    });
});
