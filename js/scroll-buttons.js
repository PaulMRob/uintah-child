document.addEventListener("DOMContentLoaded", () => {
    // Find all scroll wrappers on the page
    const scrollWrappers = document.querySelectorAll(".scroll-wrapper");

    scrollWrappers.forEach(wrapper => {
        const container = wrapper.querySelector(".scroll-container");
        const leftBtn = wrapper.querySelector(".scroll-left");
        const rightBtn = wrapper.querySelector(".scroll-right");

        if (container && leftBtn && rightBtn) {
            leftBtn.addEventListener("click", () => {
                container.scrollBy({ left: -500, behavior: "smooth" });
            });

            rightBtn.addEventListener("click", () => {
                container.scrollBy({ left: 500, behavior: "smooth" });
            });
        } else {
            console.warn("Missing scroll elements in:", wrapper);
        }
    });
});
