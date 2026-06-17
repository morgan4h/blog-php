document.addEventListener("DOMContentLoaded", () => {
    
    // --- HELPER FUNCTION TO GET COOKIE BY NAME ---
    const getCookie = (cookieName) => {
        const nameEQ = cookieName + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
        return "Guest"; 
    };

    // --- HELPER FUNCTION TO SEND DATA TO PHP ---
    const sendLog = (logData) => {
        logData.username = getCookie("name");

        fetch('http://localhost/s1/blog-php/controll/logger.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(logData),
            keepalive: true
        })
        .then(response => {
            if (response.ok) return response.json();
            throw new Error(`HTTP error! status: ${response.status}`);
        })
        .then(result => {
            if (result.status === "success") {
                console.log(`%c[Logger] ${result.message}`, "color: #2ed573;");
                if (result.rotation_status) {
                    console.log(`%c[Storage] ${result.rotation_status}`, "color: #1e90ff; font-weight: bold;");
                }
            } else {
                console.warn(`%c[Logger Warning] ${result.message}`, "color: #ffa502;");
            }
        })
        .catch(error => {
            console.error(`%c[Logger Connection Failed] ${error.message}`, "color: #ff4757; font-weight: bold;");
        });
    };

    // 1. Log Page Views
    sendLog({
        type: "page_view",
        page: window.location.href,
        referrer: document.referrer || "Direct",
        details: `Screen Resolution: ${window.screen.width}x${window.screen.height}`
    });

    // 2. Monitor and Log Click Actions
    document.addEventListener("click", (event) => {
        const target = event.target;
        const elementTag = target.tagName.toLowerCase();
        const elementClass = target.className ? `.${target.className.trim().replace(/\s+/g, '.')}` : '';
        const elementId = target.id ? `#${target.id}` : '';
        
        const elementHref = target.getAttribute('href');
        const elementSrc = target.getAttribute('src');
        const text = target.innerText ? target.innerText.trim().substring(0, 40) : '';

        let clickDetails = `Element: <${elementTag}${elementId}${elementClass}>`;
        if (elementHref) clickDetails += ` | href="${elementHref}"`;
        if (elementSrc) clickDetails += ` | src="${elementSrc}"`;
        if (text) clickDetails += ` | Text: "${text}"`;

        sendLog({
            type: "click_action",
            page: window.location.href,
            referrer: "N/A",
            details: clickDetails
        });
    });
});