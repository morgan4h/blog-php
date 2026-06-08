console.log('Dynamic CRUD system running...');

let selectedApp = null;
const updateModal = document.getElementById('updateModal');
const closeModalBtn = document.getElementById('closeModalBtn');
const updateForm = document.getElementById('updateForm');
const dynamicContainer = document.getElementById('dynamicInputContainer');

function mucrud(action, appId, extraData = {}) {
    let payload = { action: action, appId: appId };
    if (action === 'saveUpdate') {
        payload = { action: action, appId: appId, ...extraData };
    }

    fetch('../controll/curdApps.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            return;
        }

        // ================= DELETE =================
        if (action === 'delete') {
            selectedApp = data.app;
            let confirmDelete = confirm(`Delete this app?\n\nName: ${selectedApp.name || selectedApp.id}`);
            if (confirmDelete) {
                alert("Deleted successfully");
                location.reload(); 
            }
        }

        // ================= GET APP DETAILS FOR UPDATE =================
        if (action === 'getAppDetails') {
            selectedApp = data.app;
            
            document.getElementById('editAppId').value = selectedApp.id;
            
            // Wipe out any older input elements left in the modal
            dynamicContainer.innerHTML = '';

            // Run dynamically through every key field found inside the DB row entry object
            Object.keys(selectedApp).forEach(key => {
                // Skip rendering primary key ID field as a standard text-input 
                if (key === 'id') return;

                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                const label = document.createElement('label');
                label.setAttribute('for', `dynamic_${key}`);
                // Replace underscores with spaces for prettier label names
                label.textContent = key.replace('_', ' ');

                const input = document.createElement('input');
                input.type = 'text';
                input.id = `dynamic_${key}`;
                input.dataset.column = key; // Save original column name attribute string
                input.value = selectedApp[key] !== null ? selectedApp[key] : '';
                input.required = true;

                formGroup.appendChild(label);
                formGroup.appendChild(input);
                dynamicContainer.appendChild(formGroup);
            });

            updateModal.classList.add('active');
        }

        // ================= SAVE SUBMITTED UPDATE DATA =================
        if (action === 'saveUpdate') {
            alert("Application updated successfully!");
            updateModal.classList.remove('active');
            location.reload(); 
        }
    })
    .catch(err => {
        console.error("Request failed:", err);
    });
}

// Global Click Traversal Handler
addEventListener('click', function (e) {
    if (e.target.classList.contains('btn') && (e.target.classList.contains('update') || e.target.classList.contains('delete'))) {
        let text = e.target.textContent.trim();
        let appBox = e.target.closest('.app-box');
        let appId = appBox.querySelector('.app-info span').textContent.trim();

        if (text === 'Delete') {
            mucrud('delete', appId);
        }
        if (text === 'Update') {
            mucrud('getAppDetails', appId);
        }
    }
});

closeModalBtn.addEventListener('click', () => {
    updateModal.classList.remove('active');
});

// Handle dynamically built configuration submission data arrays
updateForm.addEventListener('submit', function(e) {
    e.preventDefault(); 

    const id = document.getElementById('editAppId').value;
    const updatedData = {};

    // Scan through all dynamic child inputs inside form wrapper box
    const inputs = dynamicContainer.querySelectorAll('input');
    inputs.forEach(input => {
        const columnName = input.dataset.column;
        updatedData[columnName] = input.value;
    });

    mucrud('saveUpdate', id, updatedData);
});