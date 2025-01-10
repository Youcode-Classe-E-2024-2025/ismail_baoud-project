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
    // Project Progress Chart
    const progressCtx = document.getElementById('projectProgressChart')?.getContext('2d');
    if (progressCtx) {
        new Chart(progressCtx, {
            type: 'bar',
            data: {
                labels: ['Project A', 'Project B', 'Project C', 'Project D', 'Project E'],
                datasets: [{
                    label: 'Progress (%)',
                    data: [75, 60, 90, 30, 45],
                    backgroundColor: '#3B82F6',
                    borderRadius: 5
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
                        text: 'Project Progress Overview'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Completion Percentage'
                        }
                    }
                }
            }
        });
    }

    // Resource Allocation Chart
    const resourceCtx = document.getElementById('resourceAllocationChart')?.getContext('2d');
    if (resourceCtx) {
        new Chart(resourceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Development', 'Design', 'Testing', 'Management', 'Infrastructure'],
                datasets: [{
                    data: [40, 20, 15, 15, 10],
                    backgroundColor: [
                        '#3B82F6', // Blue
                        '#10B981', // Green
                        '#F59E0B', // Yellow
                        '#EF4444', // Red
                        '#8B5CF6'  // Purple
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
                        text: 'Resource Allocation'
                    }
                },
                cutout: '60%'
            }
        });
    }
}


// Form Submissions
function handleFormSubmission(formId, endpoint) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.text();
            if (result === 'success') {
                showNotification('Success!', 'success');
                hideModal(formId.replace('Form', ''));
                form.reset();
                
                // Refresh relevant section based on form type
                if (formId.includes('project')) {
                    refreshProjects();
                } else if (formId.includes('task')) {
                    refreshAssignments();
                } else if (formId.includes('category')) {
                    refreshCategories();
                }
            } else {
                throw new Error(result);
            }
        } catch (error) {
            showNotification('Error: ' + error.message, 'error');
        }
    });
}

// Task Assignment Functions
function editAssignment(taskId) {
    fetch(`/api/tasks/${taskId}`, {
        method: 'GET'
    })
    .then(response => response.text())
    .then(data => {
        const task = parseFormData(data);
        document.getElementById('taskTitle').value = task.title || '';
        document.getElementById('taskDescription').value = task.description || '';
        document.getElementById('taskProject').value = task.project_id || '';
        document.getElementById('taskAssignee').value = task.assignee_id || '';
        document.getElementById('taskPriority').value = task.priority || 'medium';
        document.getElementById('taskDueDate').value = task.due_date || '';
        
        // Add task ID to form for update
        const form = document.getElementById('assignTaskForm');
        let taskIdInput = form.querySelector('input[name="task_id"]');
        if (!taskIdInput) {
            taskIdInput = document.createElement('input');
            taskIdInput.type = 'hidden';
            taskIdInput.name = 'task_id';
            form.appendChild(taskIdInput);
        }
        taskIdInput.value = taskId;
        
        // Show modal
        showModal('assignTask');
    })
    .catch(error => {
        showNotification('Error loading task details: ' + error.message, 'error');
    });
}

function deleteAssignment(taskId) {
    if (confirm('Are you sure you want to delete this task assignment?')) {
        const formData = new FormData();
        formData.append('task_id', taskId);
        
        fetch(`/api/tasks/delete`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                showNotification('Task assignment deleted successfully', 'success');
                refreshAssignments();
            } else {
                throw new Error(result);
            }
        })
        .catch(error => {
            showNotification('Error deleting task: ' + error.message, 'error');
        });
    }
}

async function refreshAssignments() {
    try {
        const response = await fetch('/api/tasks/assigned');
        const text = await response.text();
        const tbody = document.querySelector('#assign-tasks-section table tbody');
        tbody.innerHTML = text;
    } catch (error) {
        showNotification('Error refreshing task assignments: ' + error.message, 'error');
    }
}

// Helper function to parse form data from response
function parseFormData(text) {
    const data = {};
    text.split('&').forEach(pair => {
        const [key, value] = pair.split('=');
        if (key && value) {
            data[decodeURIComponent(key)] = decodeURIComponent(value);
        }
    });
    return data;
}

// Notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    } text-white`;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Data Refresh Functions
async function refreshProjects() {
    try {
        const response = await fetch('/api/projects');
        const projects = await response.json();
        updateProjectsUI(projects);
    } catch (error) {
        showNotification('Error refreshing projects: ' + error.message, 'error');
    }
}

async function refreshTasks() {
    try {
        const response = await fetch('/api/tasks');
        const tasks = await response.json();
        updateTasksUI(tasks);
    } catch (error) {
        showNotification('Error refreshing tasks: ' + error.message, 'error');
    }
}

async function refreshCategories() {
    try {
        const response = await fetch('/api/categories');
        const categories = await response.json();
        updateCategoriesUI(categories);
    } catch (error) {
        showNotification('Error refreshing categories: ' + error.message, 'error');
    }
}

// Modal Management
function showModal(modalName) {
    document.getElementById(modalName + 'Modal').classList.remove('hidden');
}

function hideModal(modalName) {
    document.getElementById(modalName + 'Modal').classList.add('hidden');
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts if dashboard is active
    if (!document.getElementById('dashboard-section')?.classList.contains('hidden')) {
        initializeCharts();
    }

    // Initialize Kanban board
    initializeKanbanBoard();
    
    // Initial load of assignments

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
});

// Helper function to escape HTML and prevent XSS
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
