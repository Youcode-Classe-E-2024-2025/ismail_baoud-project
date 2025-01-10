<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

if(!empty($_SESSION["infoerr"])){
    $secces = $_SESSION["infoerr"];
}
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="public/assets/js/navigation.js"></script>
    <script src="public/assets/js/auth.js"></script>
    <script src="public/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
    };

    // Check dark mode preference
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <script>
        //sweet allert
        <?php if (!empty($secces)): ?>
            Swal.fire({
                title: 'error!',
                text: '<?php echo $secces; ?>',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'
                }
            });
        <?php endif; 
        session_destroy(); ?>
    
       
    </script>

    <!-- Navigation Bar -->

    <nav class="bg-white dark:bg-gray-800 shadow-md">

        <!-- Add your navigation content here -->
    </nav>
</body>

        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-blue-600 dark:text-blue-400">ProjectHub</a>
                </div>
                <div class="flex space-x-4 items-center">
                    <button id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                        </svg>
                    </button>
                    <a href="#" class="nav-link active text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400" onclick="showHome()">Home</a>
                    <a href="#" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400" onclick="showLogin()">Login</a>
                    <a href="#" class="nav-link text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400" onclick="showSignup()">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Home Section -->

    <div id="home-section" class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-900 dark:text-white">Discover Public Projects</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Sample Project Cards -->

            <?php 
                      $project = new _projet();
                      $projets = $project->display_public_project();
                      foreach ($projets as $projet) :
                  ?>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white"><?=$projet["title"]?></h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4"><?=$projet["description"]?></p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400"><?=$projet["status"]?></span>
                </div>
            </div>
            <?php endforeach?>

        </div>
    </div>

   

    <!-- Auth Section -->

    <div id="auth-section" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 max-w-md w-full mx-4">
            <div class="relative">

                <!-- Login Form -->

                <div id="login-form" class="auth-form">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Login</h2>
                    <form action="/login" method="post" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" class="w-full p-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" class="w-full p-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                        </div>
                        <button type="submit" name="btn_login" value="login" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Login</button>
                    </form>
                    <p class="mt-4 text-center text-gray-700 dark:text-gray-300">
                        Don't have an account? 
                        <a href="#" class="text-blue-600 dark:text-blue-400" onclick="switchForm('signup')">Sign Up</a>
                    </p>
                </div>

                

                <!-- Sign Up Form -->
                 
                <div id="signup-form" class="auth-form hidden">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Sign Up</h2>
                    <form action="/signup_handler" method="post" class="space-y-4" enctype="multipart/form-data">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                            <input type="text" name="username" class="w-full p-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" class="w-full p-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" class="w-full p-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                        </div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Foto Profile</label>
                        <input type="file" name="image">
                            
                    
                        <button type="submit" name="btn_signup" value="signUp" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Sign Up</button>
                    </form>
                    <p class="mt-4 text-center text-gray-700 dark:text-gray-300">
                        Already have an account? 
                        <a href="#" class="text-blue-600 dark:text-blue-400" onclick="switchForm('login')">Login</a>
                    </p>
                </div>

                <!-- Close Button -->
                 
                <button onclick="closeAuth()"  class="absolute -top-2 -right-2 bg-gray-200 dark:bg-gray-700 rounded-full p-2 hover:bg-gray-300 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
