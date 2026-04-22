//Force any external links to open in a new tab with proper measures for security and accessibility
function mandrExternalLinkControl() {
    const links = document.querySelectorAll("a[href]");
    const currentHost = window.location.hostname;

    links.forEach(link => {
        const href = link.getAttribute("href");

        // Skip non-http links
        if (
        !href ||
        href.startsWith("#") ||
        href.startsWith("mailto:") ||
        href.startsWith("tel:") ||
        href.startsWith("javascript:")
        ) {
        return;
        }

        let url;

        try {
        url = new URL(href, window.location.origin);
        } catch {
        return;
        }

        const isExternal = !url.hostname.endsWith(currentHost);

        if (isExternal) {
        // Add target + rel
        if (link.target !== "_blank") {
            link.target = "_blank";
        }

        const rel = link.getAttribute("rel") || "";
        if (!rel.includes("noopener")) {
            link.setAttribute("rel", (rel + " noopener noreferrer").trim());
        }

        // Add accessibility text if not already present
        if (!link.querySelector(".visually-hidden")) {
            const span = document.createElement("span");
            span.className = "visually-hidden";
            span.textContent = "This link opens in a new tab";
            link.appendChild(span);
        }
        }
    });
}
document.addEventListener("DOMContentLoaded", mandrExternalLinkControl);