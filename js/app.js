console.log('CRUD system running...');

let selectedApp = null;


// =========================
// MAIN CRUD FUNCTION
// =========================
function mucrud(action, appId) {

    fetch('../controll/curdApps.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: action,
            appId: appId
        })
    })
    .then(res => res.json())
    .then(data => {

        if (!data.success) {
            alert(data.message);
            return;
        }

        selectedApp = data.app;

        // ================= DELETE =================
        if (action === 'delete') {

            let confirmDelete = confirm(
                `Delete this app?\n\nName: ${selectedApp.name}`
            );

            if (confirmDelete) {
                console.log("DELETE DONE (handled by PHP)");
                alert("Deleted successfully");
            }
        }

        // ================= UPDATE =================
        if (action === 'update') {
            console.log("UPDATE clicked for app ID:", appId);
        }
    })
    .catch(err => {
        console.error("Request failed:", err);
    });
}


// =========================
// CLICK HANDLER
// =========================
addEventListener('click', function (e) {

    if (e.target.tagName === 'P') {

        let text = e.target.textContent.trim();

        let appId =
            e.target.parentElement.parentElement.children[0].children[1].textContent;

        if (text === 'Delete') {
            mucrud('delete', appId);
        }

        if (text === 'Update') {
            // ONLY PRINT IN CONSOLE (no backend call needed)
            console.log("UPDATE clicked for app ID:", appId);
        }
    }
});