<script>
// Debug Script for Petugas Dashboard
console.log('Debug script loaded');

// Function to test system connectivity
function testSystem() {
    console.log('Testing system...');
    
    fetch('<?= base_url('petugas/test-system') ?>')
        .then(response => response.json())
        .then(data => {
            console.log('System test result:', data);
            if (data.success === false) {
                console.error('System test failed:', data);
                alert('System test failed. Check console for details.');
            } else {
                console.log('System test passed:', data);
                alert('System test passed. Check console for details.');
            }
        })
        .catch(error => {
            console.error('System test error:', error);
            alert('System test error: ' + error.message);
        });
}

// Function to debug user access
function debugUserAccess() {
    console.log('Debugging user access...');
    
    fetch('<?= base_url('petugas/debug-user-access') ?>')
        .then(response => response.json())
        .then(data => {
            console.log('User access debug:', data);
            if (data.success) {
                console.log('User ID:', data.debug_data.session_user_id);
                console.log('Role:', data.debug_data.session_role);
                console.log('Username:', data.debug_data.session_username);
                console.log('Assigned categories:', data.debug_data.assigned_categories);
                console.log('Total categories:', data.debug_data.total_categories);
                
                if (data.debug_data.total_categories === 0) {
                    alert('WARNING: User has no assigned categories! This will cause access issues.');
                } else {
                    alert('User access debug complete. Check console for details.');
                }
            } else {
                console.error('User access debug failed:', data);
                alert('User access debug failed. Check console for details.');
            }
        })
        .catch(error => {
            console.error('User access debug error:', error);
            alert('User access debug error: ' + error.message);
        });
}

// Function to test AJAX calls
function testAjaxCalls() {
    console.log('Testing AJAX calls...');
    
    // Test getKategoriInfo
    fetch('<?= base_url('petugas/get-kategori-info') ?>')
        .then(response => response.json())
        .then(data => {
            console.log('getKategoriInfo result:', data);
        })
        .catch(error => {
            console.error('getKategoriInfo error:', error);
        });
    
    // Test getDashboardSummary
    fetch('<?= base_url('petugas/get-dashboard-summary') ?>')
        .then(response => response.json())
        .then(data => {
            console.log('getDashboardSummary result:', data);
        })
        .catch(error => {
            console.error('getDashboardSummary error:', error);
        });
}

// Function to log form data before submission
function logFormData(formId) {
    const form = document.getElementById(formId);
    if (form) {
        const formData = new FormData(form);
        console.log('Form data for', formId, ':');
        for (let [key, value] of formData.entries()) {
            console.log(key + ':', value);
        }
    }
}

// Add debug buttons to the page
function addDebugButtons() {
    const debugContainer = document.createElement('div');
    debugContainer.innerHTML = `
        <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 5px; font-size: 12px;">
            <h6 style="margin: 0 0 10px 0;">Debug Tools</h6>
            <button onclick="testSystem()" style="margin: 2px; padding: 5px; font-size: 10px;">Test System</button><br>
            <button onclick="debugUserAccess()" style="margin: 2px; padding: 5px; font-size: 10px;">Debug Access</button><br>
            <button onclick="testAjaxCalls()" style="margin: 2px; padding: 5px; font-size: 10px;">Test AJAX</button><br>
            <button onclick="console.clear()" style="margin: 2px; padding: 5px; font-size: 10px;">Clear Console</button>
        </div>
    `;
    document.body.appendChild(debugContainer);
}

// Enhanced error handling for AJAX calls
function enhancedAjaxCall(url, options = {}) {
    console.log('Making AJAX call to:', url, 'with options:', options);
    
    return fetch(url, options)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            return data;
        })
        .catch(error => {
            console.error('AJAX call failed:', error);
            console.error('URL:', url);
            console.error('Options:', options);
            throw error;
        });
}

// Initialize debug tools when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Petugas dashboard loaded');
    
    // Add debug buttons in development mode
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        addDebugButtons();
    }
    
    // Log all form submissions
    document.addEventListener('submit', function(e) {
        console.log('Form submitted:', e.target.id || e.target.tagName);
        logFormData(e.target.id);
    });
    
    // Log all button clicks
    document.addEventListener('click', function(e) {
        if (e.target.tagName === 'BUTTON') {
            console.log('Button clicked:', e.target.textContent, 'ID:', e.target.id);
        }
    });
});

// Export functions for global use
window.petugasDebug = {
    testSystem,
    debugUserAccess,
    testAjaxCalls,
    logFormData,
    enhancedAjaxCall
};
</script>
