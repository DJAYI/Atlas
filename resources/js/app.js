import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

// OLD PAGE LOGIC
window.addEventListener("pageswap", async (e) => {
    if (e.viewTransition) {
        const targetUrl = new URL(e.activation.entry.url);

        // Navigating to a profile page
        if (isProfilePage(targetUrl)) {
            const profile = extractProfileNameFromUrl(targetUrl);

            // Set view-transition-name values on the clicked row
            // Clean up after the page got replaced
            setTemporaryViewTransitionNames(
                [
                    [document.querySelector(`#${profile} span`), "name"],
                    [document.querySelector(`#${profile} img`), "avatar"],
                ],
                e.viewTransition.finished
            );
        }
    }
});

// NEW PAGE LOGIC
window.addEventListener("pagereveal", async (e) => {
    if (e.viewTransition) {
        const fromURL = new URL(navigation.activation.from.url);
        const currentURL = new URL(navigation.activation.entry.url);

        // Navigating from a profile page back to the homepage
        if (isProfilePage(fromURL) && isHomePage(currentURL)) {
            const profile = extractProfileNameFromUrl(currentURL);

            // Set view-transition-name values on the elements in the list
            // Clean up after the snapshots have been taken
            setTemporaryViewTransitionNames(
                [
                    [document.querySelector(`#${profile} span`), "name"],
                    [document.querySelector(`#${profile} img`), "avatar"],
                ],
                e.viewTransition.ready
            );
        }
    }
});

Alpine.start();
