// Tab Navigation
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    document.getElementById(tabName + '-section').classList.remove('hidden');
    
    // Update active nav link
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');

    // Initialize charts when dashboard tab is shown
    if (tabName === 'dashboard') {
        initializeCharts();
    }
}

// Initialize Charts Function
function initializeCharts() {
    // Project Statistics Chart
    const projectStats = document.getElementById('projectStatsChart')?.getContext('2d');
    if (projectStats) {
        new Chart(projectStats, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Completed Projects',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: '#10B981',
                    tension: 0.4,
                    fill: false
                }, {
                    label: 'Active Projects',
                    data: [8, 15, 20, 18, 24, 28],
                    borderColor: '#3B82F6',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Project Progress Over Time'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Projects'
                        }
                    }
                }
            }
        });
    }

    // Task Distribution Chart
    const taskDist = document.getElementById('taskDistributionChart')?.getContext('2d');
    if (taskDist) {
        new Chart(taskDist, {
            type: 'doughnut',
            data: {
                labels: ['To Do', 'In Progress', 'Review', 'Completed'],
                datasets: [{
                    data: [25, 40, 15, 20],
                    backgroundColor: [
                        '#EF4444', // Red for To Do
                        '#F59E0B', // Yellow for In Progress
                        '#3B82F6', // Blue for Review
                        '#10B981'  // Green for Completed
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Current Task Status Distribution'
                    }
                },
                cutout: '60%'
            }
        });
    }
}

// Modal Management
function showModal(modalName) {
    document.getElementById(modalName + 'Modal')?.classList.remove('hidden');
}

function hideModal(modalName) {
    document.getElementById(modalName + 'Modal')?.classList.add('hidden');
}

// User Management Functions
function editUser(id) {
    // Add your user edit logic here
    console.log('Editing user:', id);
}

function deactivateUser(id) {
    if (confirm('Are you sure you want to deactivate this user?')) {
        // Add your user deactivation logic here
        console.log('Deactivating user:', id);
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts if dashboard is active
    if (!document.getElementById('dashboard-section')?.classList.contains('hidden')) {
        initializeCharts();
    }

    // Close modals when clicking outside
    window.addEventListener('click', (e) => {
        document.querySelectorAll('.modal').forEach(modal => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // Prevent modal close when clicking inside
    document.querySelectorAll('.modal > div').forEach(modalContent => {
        modalContent.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });

    // Handle form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const modalId = this.closest('.modal')?.id.replace('Modal', '');
            if (modalId) {
                hideModal(modalId);
            }
        });
    });

    // Dark mode integration with charts
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            // Reinitialize charts if on dashboard
            if (!document.getElementById('dashboard-section')?.classList.contains('hidden')) {
                initializeCharts();
            }
        });
    }
});