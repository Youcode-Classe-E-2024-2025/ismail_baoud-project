<?php
if ($_SESSION["role"] !== "member") {
    header('location: error/404.php ');
}
if (!empty($_SESSION["login_success"])) {
    $secces = $_SESSION["login_success"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectHub - Member Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Drag and Drop library -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.12/lib/draggable.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#1a1a1a',
                            card: '#2d2d2d',
                            text: '#ffffff'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-dark-bg transition-colors duration-200">
    <script>
        <?php if (!empty($secces)): ?>
            Swal.fire({
                title: 'success!',
                text: '<?php echo $secces; ?>',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'
                }
            });
        <?php endif;
        unset($_SESSION["login_success"]);
        ?>
    </script>
    <!-- Navigation Bar -->
    <nav class="bg-white dark:bg-dark-card shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-blue-600">ProjectHub</a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <!-- Sun Icon -->
                        <svg class="w-6 h-6 hidden dark:block text-gray-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon -->
                        <svg class="w-6 h-6 block dark:hidden text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                    <div class="flex space-x-4">
                        <a href="#" class="nav-link active">My Tasks</a>
                        <a href="#" class="nav-link" onclick="showProfileModal()">Profile</a>
                        <a href="/logOut" class="nav-link">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>



    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-center mb-4">Welcome Back, <span
                    class="text-blue-600"><?= $_SESSION["fullname"] ?></span></h1>
            <p class="text-center text-gray-600 dark:text-gray-300">Here are your assigned tasks</p>
        </div>

        <!-- Task Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-2">Todo</h3>
            </div>
            <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-2">In Progress</h3>
            </div>
            <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-2">Completed</h3>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Todo Column -->
            <div class="flex-1">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-4">Todo</h2>
                    <div class="kanban-column" data-status="todo">
                        <!-- Task Card -->
                        <?php
                        $res = new tache_member();
                        $taches = $res->display_todo_taches($_SESSION["member_id"]);
                        if ($taches == null) {
                            $taches = [];
                        }

                        foreach ($taches as $tache):
                            ?>
                            <div class="task-card bg-white dark:bg-dark-card rounded-lg shadow-md p-4 mb-4 cursor-move">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-semibold"><?= $tache["title"] ?></h3>
                                    <span class="text-sm text-blue-600 dark:text-blue-400"><?= $tache["tag"] ?></span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-3"><?= $tache["description"] ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400"><?= $tache["date"] ?></span>
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded text-sm"><?= $tache["name"] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- More todo tasks here -->
                    </div>
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="flex-1">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-4">In Progress</h2>
                    <div class="kanban-column" data-status="in-progress">
                        <!-- Task Card -->
                        <?php
                        $res = new tache_member();
                        $taches = $res->display_doing_taches($_SESSION["member_id"]);
                        if ($taches == null) {
                            $taches = [];
                        }

                        foreach ($taches as $tache):
                            ?>
                            <div class="task-card bg-white dark:bg-dark-card rounded-lg shadow-md p-4 mb-4 cursor-move">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-semibold"><?= $tache["title"] ?></h3>
                                    <span class="text-sm text-blue-600 dark:text-blue-400"><?= $tache["tag"] ?></span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-3"><?= $tache["description"] ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400"><?= $tache["date"] ?></span>
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded text-sm"><?= $tache["name"] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- More in-progress tasks here -->
                    </div>
                </div>
            </div>

            <!-- Completed Column -->
            <div class="flex-1">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-4">Completed</h2>
                    <div class="kanban-column" data-status="completed">
                        <!-- Task Card -->
                        <?php
                        $res = new tache_member();
                        $taches = $res->display_done_taches($_SESSION["member_id"]);
                       
                        if ($taches == null) {
                            $taches = [];
                        }

                        foreach ($taches as $tache):
                            ?>
                            <div class="task-card bg-white dark:bg-dark-card rounded-lg shadow-md p-4 mb-4 cursor-move">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-semibold"><?= $tache["title"] ?></h3>
                                    <span class="text-sm text-blue-600 dark:text-blue-400"><?= $tache["tag"] ?></span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-3"><?= $tache["description"] ?></p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400"><?= $tache["date"] ?></span>
                                    <span
                                        class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded text-sm"><?= $tache["name"] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- More completed tasks here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div id="taskDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold">Task Details</h3>
                <button onclick="hideTaskModal()"
                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Task Name</label>
                    <p id="taskName" class="font-semibold">Frontend Development</p>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Project</label>
                    <p id="taskProject" class="text-blue-600 dark:text-blue-400">E-Commerce Platform</p>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <p id="taskDescription" class="text-gray-600 dark:text-gray-300">Implement new user interface
                        components</p>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Due Date</label>
                    <p id="taskDueDate" class="text-gray-600 dark:text-gray-300">Dec 31, 2024</p>
                </div>
                <form method="post" action="">
                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select id="taskStatus" name="taskStatus"
                        class="w-full p-2 border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg">
                        <option value="todo">Todo</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg">Update
                        Status</button>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="hideTaskModal()"
                    class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600">
                    Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <?php
    $res = new info_member();
    $members = $res->get_memberinfo($_SESSION["member_id"]);

    if ($members == null) {
        $members = [];
    }
    foreach ($members as $tache):
        $imageData = base64_encode($tache['image']);
        $imageSrc = "data:image/jpeg;base64,{$imageData}";
        ?>
        <div id="profileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md max-h-[90vh] flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold">My Profile</h3>
                </div>

                <div class="overflow-y-auto flex-1 custom-scrollbar">
                    <!-- Profile Picture -->
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div>
                                <img src="<?= $imageSrc ?>" class="rounded-full" alt="Member Image" />
                            </div>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <form class="space-y-4">

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Full name</label>
                            <input type="text" value="<?= $_SESSION["fullname"] ?>"
                                class="w-full p-2 border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" value="<?= $_SESSION["email"] ?>"
                                class="w-full p-2 border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Role</label>
                            <input type="text" value="<?= $_SESSION["role"] ?>"
                                class="w-full p-2 border dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg"
                                readonly>
                        </div>


                    </form>
                </div>

                <div class="flex justify-end space-x-2 mt-6 pt-4 border-t">
                    <button type="button" onclick="hideProfileModal()"
                    class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600">
                    Close
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <style>
        .nav-link {
            @apply text-gray-600 dark: text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition-colors;
        }

        .nav-link.active {
            @apply text-blue-600 dark: text-blue-400;
        }

        /* Dark mode styles */
        .dark .bg-white {
            @apply bg-dark-card text-gray-100;
        }

        .dark .text-gray-600 {
            @apply text-gray-300;
        }

        .dark .text-gray-500 {
            @apply text-gray-400;
        }

        .dark .border {
            @apply border-gray-600;
        }

        .dark .hover\:bg-gray-50:hover {
            @apply hover: bg-gray-700;
        }

        .kanban-column {
            min-height: 200px;
            /* Ensure columns have height even when empty */
            transition: background-color 0.2s ease;
        }

        .kanban-column.draggable-container--is-dragging {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .task-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .task-card.draggable--is-dragging {
            transform: scale(1.05);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

    <script>
        // Dark mode functionality
        const darkModeToggle = document.getElementById('darkModeToggle');

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' ||
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }

        // Toggle dark mode
        darkModeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const containers = document.querySelectorAll('.kanban-column');

            if (typeof Draggable !== 'undefined') {
                const sortable = new Draggable.Sortable(containers, {
                    draggable: '.task-card',
                    handle: '.task-card',
                    mirror: {
                        constrainDimensions: true,
                    }
                });

                sortable.on('drag:start', (evt) => {
                    evt.source.style.opacity = '0.5';
                });

                sortable.on('drag:stop', (evt) => {
                    evt.source.style.opacity = '1';
                });

                sortable.on('sortable:stop', (evt) => {
                    const task = evt.data.dragEvent.data.source;
                    const newStatus = evt.data.newContainer.dataset.status;

                    // Update task styling based on new status
                    updateTaskStyle(task, newStatus);
                });
            }
        });
        œ
        // Update task card styling based on status
        function updateTaskStyle(taskElement, status) {
            const statusBadge = taskElement.querySelector('.status-badge');
            if (statusBadge) {
                statusBadge.className = 'status-badge px-2 py-1 rounded text-sm';
                switch (status) {
                    case 'todo':
                        statusBadge.classList.add('bg-gray-100', 'text-gray-600');
                        statusBadge.textContent = 'Todo';
                        break;
                    case 'in-progress':
                        statusBadge.classList.add('bg-yellow-100', 'text-yellow-600');
                        statusBadge.textContent = 'In Progress';
                        break;
                    case 'completed':
                        statusBadge.classList.add('bg-green-100', 'text-green-600');
                        statusBadge.textContent = 'Completed';
                        break;
                }
            }
        }

        // Show task detail modal
        function showTaskModal(taskId) {
            document.getElementById('taskDetailModal').classList.remove('hidden');
            // Here you would typically fetch task details from the server
        }

        // Hide task detail modal
        function hideTaskModal() {
            document.getElementById('taskDetailModal').classList.add('hidden');
        }

        // Profile Modal Functions
        function showProfileModal() {
            document.getElementById('profileModal').classList.remove('hidden');
        }

        function hideProfileModal() {
            document.getElementById('profileModal').classList.add('hidden');
        }

        function togglePasswordSection() {
            const passwordSection = document.getElementById('passwordSection');
            const passwordArrow = document.getElementById('passwordArrow');
            passwordSection.classList.toggle('hidden');
            passwordSection.classList.toggle('show');
            passwordArrow.classList.toggle('rotate-180');
        }

        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            const profileModal = document.getElementById('profileModal');
            const taskDetailModal = document.getElementById('taskDetailModal');

            if (e.target === profileModal) {
                hideProfileModal();
            }
            if (e.target === taskDetailModal) {
                hideTaskModal();
            }
        });

        // Prevent modal close when clicking inside the modal content
        document.querySelectorAll('.modal > div').forEach(modalContent => {
            modalContent.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });

    </script>
</body>

</html>