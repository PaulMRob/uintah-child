document.addEventListener("DOMContentLoaded", () => {
    const scrollContainer = document.querySelector(".scroll-container");
    const scrollLeftBtn = document.querySelector(".scroll-left");
    const scrollRightBtn = document.querySelector(".scroll-right");

    if (scrollContainer && scrollLeftBtn && scrollRightBtn) {
        scrollLeftBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({ left: -500, behavior: "smooth" });
        });

        scrollRightBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({ left: 500, behavior: "smooth" });
        });
    } else {
        console.warn("Scroll buttons or container not found.");
    }
});
