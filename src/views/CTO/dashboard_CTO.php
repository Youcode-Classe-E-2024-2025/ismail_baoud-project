<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION["role"] !== "CTO") {
    header('location: error/404.php ');
}

if (!empty($_SESSION["login_success"])) {
    $secces = $_SESSION["login_success"];
}

$CSRF = generateCsrfToken();

?>
<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectHub - CTO Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.12/lib/draggable.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <style type="text/tailwindcss">
        @layer components {
            .nav-link {
                @apply text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition-colors;
            }
            .nav-link.active {
                @apply text-blue-600 dark:text-blue-400;
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
                @apply hover:bg-gray-700;
            }
        }
    </style>
    <script src="/public/assets/js/theme.js"></script>
    <script src="/public/assets/js/cto.js"></script>
</head>

<body class="bg-gray-50 dark:bg-dark-bg min-h-screen transition-colors duration-200">
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
                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <!-- Dark SVG Icon -->
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <!-- Light SVG Icon -->
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                            </path>
                        </svg>
                    </button>
                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" type="button"
                            class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                            <!-- Dark SVG Icon -->
                            <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <!-- Light SVG Icon -->
                            <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                                </path>
                            </svg>
                        </button>
                        <div class="flex space-x-4">
                            <a href="#" class="nav-link active" onclick="showTab('projects')">Projects</a>
                            <a href="#" class="nav-link" onclick="showTab('team')">Team</a>
                            <a href="#" class="nav-link" onclick="showTab('assign-tasks')">Assign Tasks</a>
                            <a href="#" class="nav-link" onclick="showTab('categories')">Categories</a>
                            <a href="#" class="nav-link" onclick="showTab('permession')">permessions</a>
                            <a href="/logOut" class="nav-link">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Projects Section -->

        <div id="projects-section" class="tab-content">
            <h1 class="text-4xl font-bold text-center mb-8">Welcome,<?= $_SESSION["fullname"] ?></h1>


            <div class="flex justify-end mb-6">
                <button onclick="showModal('createProject')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Create New Project
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Sample Project Cards -->
                <?php
                $project = new _projet();
                $projets = $project->display_project($_SESSION["cto_id"]);
                if ($projets == null) {
                    $projets = [];
                }
                foreach ($projets as $projet):
                    ?>
                    <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-semibold mb-2"><?= $projet["title"] ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4"><?= $projet["description"] ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400"><?= $projet["status"] ?></span>
                            <span class="text-sm text-gray-500 dark:text-gray-400"><?= $projet["visibility"] ?></span>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">Edit</button>
                            <form action="/delete_by_CTO" method="POST">
                                <input type="text" name="projet_id" value="<?= $projet["id"] ?>" class="hidden" required>

                                <button name="deactive_projet"
                                    class="text-red-600 dark:text-red-500 hover:text-red-800">Deactivate</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>


        <!-- Team Section -->
        <div id="team-section" class="tab-content hidden">
            <h1 class="text-4xl font-bold text-center mb-8">Team Management</h1>
            <div class="flex justify-end mb-6">
                <button onclick="showModal('addMember')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Add Team Member
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Sample Team Member Card -->
                <?php
                $res = new equipe_handling();
                $members = $res->_display($_SESSION["cto_id"]);
                foreach ($members as $member): ?>
                    <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                MR
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold"><?= $member["fullname"] ?></h3>

                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4"><?= $member["email"] ?></p>
                        <div class="flex justify-end space-x-2">
                            <form action="/delete_by_CTO" method="POST">
                                <input type="text" name="member_id" value="<?= $member["member_id"] ?>" class="hidden"
                                    required>

                                <button name="deactive_member"
                                    class="text-red-600 dark:text-red-500 hover:text-red-800">Deactivate</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Assign Tasks Section -->
        <div id="assign-tasks-section" class="tab-content hidden">
            <h1 class="text-4xl font-bold text-center mb-8">Task Assignment</h1>
            <div class="flex justify-end mb-6">
                <button onclick="showModal('assignTask')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Assign New Task
                </button>
            </div>
            <div class="grid grid-cols-1 gap-6">
                <!-- Task Assignment List -->
                <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-3 px-4">Task</th>
                                    <th class="text-left py-3 px-4">Project</th>
                                    <th class="text-left py-3 px-4">Assigned To</th>
                                    <th class="text-left py-3 px-4">Due Date</th>
                                    <th class="text-left py-3 px-4">Status</th>
                                    <th class="text-left py-3 px-4">Actions</th>
                                </tr>
                                <?php
                                $res = new _tache();

                                $taches = $res->display_taches();

                                if ($taches == null) {
                                    $taches = [];
                                }

                                foreach ($taches as $tache):
                                    ?>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="text-left py-3 px-4"><?= $tache["title"] ?></td>
                                        <td class="text-left py-3 px-4"><?= $tache["projet_name"] ?></td>
                                        <td class="text-left py-3 px-4"><?= $tache["fullname"] ?></td>
                                        <td class="text-left py-3 px-4"><?= $tache["date"] ?></td>
                                        <td class="text-left py-3 px-4"><?= $tache["status"] ?></td>
                                        <td class="text-left py-3 px-4">
                                            <button
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">Edit
                                                | </button>
                                            <form action="/delete_by_CTO" method="POST">
                                                <input type="text" name="tache_id" value="<?= $tache["id"] ?>"
                                                    class="hidden" required>

                                                <button name="deactive_tache"
                                                    class="text-red-600 dark:text-red-500 hover:text-red-800">Deactivate</button>
                                            </form>
                                        </td>


                                    </tr>
                                <?php endforeach; ?>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div id="categories-section" class="tab-content hidden">
            <h1 class="text-4xl font-bold text-center mb-8">Categories Management</h1>
            <div class="flex justify-end mb-6">
                <button onclick="showModal('createCategory')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Create Category
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Sample Category Card -->
                <?php

                $categories = category_handling::display($_SESSION["cto_id"]);
                if ($projets == null) {
                    $projets = [];
                }

                foreach ($categories as $category):
                    ?>
                    <div class="bg-white dark:bg-dark-card rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-semibold mb-2"><?= $category["name"] ?></h3>
                        <div class="flex justify-between items-center">
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

                    
    
     <!-- Team Section -->
    <div id="permession-section" class="tab-content hidden">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full">
                
                        <h1 class="text-4xl font-bold  mb-8 text-center">Role Management</h1>
                    <form action="/permessions" method="post">
                        <div>
                            <label class="block text-sm text-center font-bold mb-1" for="projectName">Project Name</label>
                            <input type="text" id="projectName" name="role_create" required
                            class="w-full p-2 text-center border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        </div> 
                            <div class="flex justify-center mb-6 mt-6 " >
                        <button type="submit" name="btn_role"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Create Role
                        </button>
                    </form>
                    </div>
    <h1 class="text-4xl font-bold  mb-8 text-center">ROLE Management</h1>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center mb-4 flex justify-center">
            <h2 class="text-xl font-semibold text-center">Manage Roles and Permissions</h2>
        </div>
        <p class="text-gray-600 dark:text-gray-300 mb-4 text-center">Select the permissions for each role below:</p>
        <div class="flex justify-center space-x-2">
            <form action="/permessions" method="POST" class="w-full">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 text-left text-center">ROLE</th>
                            <th class="py-2 text-left">Create</th>
                            <th class="py-2 text-left">Delete</th>
                            <th class="py-2 text-left">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                         $res = new role_permession();
                         $result = $res->get_roles();
                            foreach($result as $res):
                        ?>
                          <tr class="border-b border-gray-300">
        <td class="py-2 flex justify-center">
            <input type="hidden" name="roles[]" value="<?=$res["role_id"]?>">
            <span class="outline-none text-center"><?=$res["role_name"]?></span>
        </td>
        <td class="py-2">
            <input type="checkbox" value="1" name="role<?=$res["role_id"]?>_permission1">
        </td>
        <td class="py-2">
            <input type="checkbox" value="2" name="role<?=$res["role_id"]?>_permission2">
        </td>
        <td class="py-2">
            <input type="checkbox" value="3" name="role<?=$res["role_id"]?>_permission3">
        </td>
    </tr>
                        <?php endforeach; ?>
                        <div class="flex justify-end space-x-2">
                    
                </div>
                      
                    </tbody>
                </table>
                <div class="flex justify-center mb-6 mt-6 " >
    <button type="submit" name="btn_permession"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Change Permessions
                    </button>
    </div>
            </form>
        </div>
    </div>
</div>
    <!-- Modals -->
    <!-- Create Project Modal -->
    <div id="createProjectModal"
        class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Create New Project</h3>
            <form action="/projet_create" method="post" id="createProjectForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="projectName">Project Name</label>
                    <input type="text" id="projectName" name="name" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="projectDescription">Description</label>
                    <textarea id="projectDescription" name="description" rows="3" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="projectDescription">visibility</label>
                    <select id="taskAssignee" name="visibility" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">Select visibility</option>
                        <option value="private">private</option>
                        <option value="public">public</option>

                    </select>
                </div>
                <input type="hidden" name="csrf_token" value="<?= $CSRF ?>">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('createProject')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100">
                        Cancel
                    </button>
                    <button type="submit" name="btn_project"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div id="addMemberModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Add Team Member</h3>
            <form action="/manage_equipe" method="post" id="addMemberForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="memberRole">Select Member</label>

                    <select id="memberRole" name="role" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">Select a role</option>
                        <?php
                        try {
                            $res = new equipe_handling();
                            $members = $res->display($_SESSION["cto_id"]);
                            foreach ($members as $member) {

                                echo '<option value="' . htmlspecialchars($member['member_id']) . '">' .
                                    htmlspecialchars($member['fullname']) .
                                    '</option>';
                            }
                        } catch (Exception $e) {
                            error_log("Error loading categories: " . $e->getMessage());
                        }
                        ?>
                    </select>

                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('addMember')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100">
                        Cancel
                    </button>
                    <button type="submit" name="btn_equipe"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Add Member
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Task Modal -->
    <div id="assignTaskModal"
        class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Assign New Task</h3>
            <form action="/tache" method="post" id="assignTaskForm" class="space-y-4" method="post"
                action="/api/tasks/assign">
                <div>
                    <label class="block text-sm font-medium mb-1" for="taskTitle">Task Title</label>
                    <input type="text" id="taskTitle" name="title" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="taskDescription">Description</label>
                    <textarea id="taskDescription" name="description" rows="3" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="taskProject">Project</label>
                    <select id="taskProject" name="projet_id" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <option name="">Select a project</option>
                        <?php
                        $project = new _projet();
                        $projets = $project->display_project($_SESSION["cto_id"]);
                        if ($projets == null) {
                            $projets = [];
                        }
                        foreach ($projets as $projet): ?>
                            <option value="<?= htmlspecialchars($projet['id']) ?>">
                                <?= htmlspecialchars($projet['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="taskAssignee">Assign To</label>
                    <select id="taskAssignee" name="member_id" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">Select member</option>
                        <?php
                        try {
                            $res = new equipe_handling();
                            $members = $res->_display($_SESSION["cto_id"]);
                            if ($members == null) {
                                $members = [];
                            }

                            foreach ($members as $member) {

                                echo '<option value="' . htmlspecialchars($member['member_id']) . '">' .
                                    htmlspecialchars($member['fullname']) .
                                    '</option>';
                            }
                        } catch (Exception $e) {
                            error_log("Error loading categories: " . $e->getMessage());
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="taskPriority">Priority</label>
                    <select id="taskPriority" name="priority" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">priority</option>
                        <option value="BASIQUE">BASIQUE</option>
                        <option value="BUG">BUG</option>
                        <option value="FONCTIONNALITE">FONCTIONNALITE</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="projectCategory">Category</label>
                    <select id="projectCategory" name="category_id" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">Select a category</option>
                        <?php
                        try {
                            $categories = category_handling::display($_SESSION["cto_id"]);
                            foreach ($categories as $category) {
                                echo '<option value="' . htmlspecialchars($category['category_id']) . '">' .
                                    htmlspecialchars($category['name']) .
                                    '</option>';
                            }
                        } catch (Exception $e) {
                            error_log("Error loading categories: " . $e->getMessage());
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="taskDueDate">Due Date</label>
                    <input type="date" id="taskDueDate" name="date" required
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('assignTask')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100">
                        Cancel
                    </button>
                    <button type="submit" name="btn_tache" value="tache"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Assign Task
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Category Modal -->
    <div id="createCategoryModal"
        class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-dark-card rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Create New Category</h3>
            <form action="/category" method="post" id="createCategoryForm" class="space-y-4">
                <div id="fields-container">
                    <label class="block text-sm font-medium mb-1" for="categoryName">Category Name</label>
                    <input type="text" id="categoryName" placeholder="Entrez une catégorie" name="dynamic_fields[]"
                        required
                        class="w-full p-2 border rounded-lg focus:ring-2 mb-3 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="addField()"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Add Field
                    </button>
                    <button type="button" onclick="hideModal('createCategory')"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100">
                        Cancel
                    </button>
                    <button type="submit" name="btn_category" value="category"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="public/assets/js/main.js"></script>
    <script src="public/assets/js/navigation.js"></script>

    <script>
        // Initialize drag and drop
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

        // Tab switching functionality
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabName + '-section').classList.remove('hidden');

            // Update active tab styling
   document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // ... la formulaire dinamique ...
        function addField() {
            const container = document.getElementById("fields-container");

            // Créer un nouveau champ input
            const newField = document.createElement("input");
            newField.type = "text";
            newField.name = "dynamic_fields[]"; // Utilisation d'un tableau pour plusieurs champs
            newField.placeholder = "Entrez une catégorie";
            newField.required = true; // Rendre le champ obligatoire
            newField.classList.add("w-full", "p-2", "mb-3", "border", "rounded-lg", "focus:ring-2", "focus:ring-blue-500",
                "dark:bg-gray-700", "dark:border-gray-600");

            // Ajouter le champ au conteneur
            container.appendChild(newField);

            // Ajouter un saut de ligne pour la lisibilité
            container.appendChild(document.createElement("br"));


            // Fonction pour cacher un modal (optionnel)
            function hideModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>