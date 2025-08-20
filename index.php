<?php
// You can add any PHP logic here if needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAMOJA 2025 - CAF African Nations Championship</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">
    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #e05a2a;
            --secondary: #f7931e;
            --accent: #ff4500;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        
        body.light-mode {
            background-color: #f8fafc;
            color: #1e293b;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%);
        }
        
        .trophy-container {
            background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 70%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .search-container {
            transform: none;
            margin-top: 0;
        }
        
        .match-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        
        .hero-content {
            min-height: 50vh;
        }
        
        .hero-bg {
            background-image: url('banner_mobile.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        @media (min-width: 768px) {
            .hero-bg {
                background-image: url('banner.png');
            }
        }
        
        .theme-toggle {
            transition: all 0.3s;
        }
        
        .theme-toggle.active {
            background-color: var(--primary);
        }
        
        .select-custom {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23fff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px;
        }
        
        body.light-mode .select-custom {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%231e293b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        }
        
        /* Modern rounded corners for all interactive elements */
        .modern-rounded {
            border-radius: 1rem;
        }
        
        .modern-rounded-lg {
            border-radius: 1.5rem;
        }
        
        .modern-rounded-xl {
            border-radius: 2rem;
        }
        
        .modern-rounded-2xl {
            border-radius: 2.5rem;
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Header -->
    <header class="bg-black py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="logo.png" alt="CAF African Nations Championship" class="h-10 w-auto">
            </div>
            <div class="flex items-center space-x-4">
                <!-- Dark/Light mode toggle -->
                <div class="flex items-center bg-gray-800 rounded-full p-1 theme-toggle-container">
                    <button id="dark-mode-toggle" class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center theme-toggle active">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                    <button id="light-mode-toggle" class="w-8 h-8 rounded-full flex items-center justify-center theme-toggle">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden hero-content hero-bg">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/40 to-black/80"></div>
        
        <!-- Content -->

    </section>

    <!-- Search Section -->
    <div class="bg-black -mt-8">
        <div class="max-w-5xl mx-auto px-6 search-container relative z-20">
            <div class="bg-gray-800/90 backdrop-blur-sm modern-rounded-2xl p-6 border border-gray-700/50 shadow-2xl">
                <h2 class="text-2xl font-bold text-white mb-6 text-center">Find Your Match Experience</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Search Team</label>
                        <select class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 select-custom appearance-none pr-10">
                            <option value="">Select Team</option>
                            <option value="kenya">Kenya</option>
                            <option value="madagascar">Madagascar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Location</label>
                        <select class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 select-custom appearance-none pr-10">
                            <option value="">Select Location</option>
                            <option value="nairobi">Moi International Sports Centre</option>

                        </select>
                    </div>
                    <div class="flex items-end">
                        <button id="find-matches-btn" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 modern-rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40">
                            <i class="fas fa-search mr-2"></i> Find Matches
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Matches Section -->
    <section class="bg-black py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-start items-center mb-12">
                <h2 class="text-4xl font-bold text-white">Upcoming Matches</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Match Card -->
                <div class="bg-gray-800/50 backdrop-blur-sm modern-rounded-2xl border border-gray-700/50 overflow-hidden match-card">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div class="text-white/60 text-sm font-medium mx-auto">22 Aug 2025</div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <span class="fi fi-ke rounded-sm shadow-md text-2xl"></span>
                                <span class="text-xl font-bold text-white">KEN</span>
                            </div>
                            
                            <div class="flex flex-col items-center">
                                <div class="text-white/60 text-sm">17:00</div>
                                <div class="text-xs bg-gray-700 text-white/80 px-2 py-1 modern-rounded-md mt-1">UPCOMING</div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <span class="text-xl font-bold text-white">MAD</span>
                                <span class="fi fi-mg rounded-sm shadow-md text-2xl"></span>
                            </div>
                        </div>
                        
                        <div class="text-center mb-4">
                            <div class="text-white/60 text-sm flex items-center justify-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> Moi International Sports Centre
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-white">
                                <span class="text-sm text-white/60">from </span>
                                <span class="font-bold">Ksh 250</span>
                            </div>
                            <a href="booking.php" class="js-buy-ticket bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 modern-rounded-lg transition-colors duration-200 text-sm flex items-center">
                                <i class="fas fa-ticket-alt mr-2"></i> Buy Tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-black border-t border-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo -->
                <div class="col-span-1">
                    <img src="logo.png" alt="CAF African Nations Championship" class="h-10 w-auto mb-4">
                    <p class="text-white/60 text-sm">The premier African football championship bringing together nations in celebration of sport and unity.</p>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Contact</h3>
                    <div class="space-y-2 text-white/60 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i> hello@mookh.africa
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-2"></i> +254 798 984828
                        </div>
                    </div>
                </div>
                
                <!-- Socials -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-orange-500 transition-colors border border-gray-700/50">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-orange-500 transition-colors border border-gray-700/50">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-orange-500 transition-colors border border-gray-700/50">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Stay Updated</h3>
                    <div class="flex">
                        <input type="email" placeholder="Your email" class="bg-gray-800 text-white px-4 py-2 modern-rounded-l-lg focus:outline-none focus:ring-2 focus:ring-orange-500 w-full">
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 modern-rounded-r-lg transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-white/40 text-sm">
                    © 2025 CAF African Nations Championship. All rights reserved.
                </div>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-white/60 hover:text-white text-sm">Privacy Policy</a>
                    <a href="#" class="text-white/60 hover:text-white text-sm">Terms of Service</a>
                    <a href="#" class="text-white/60 hover:text-white text-sm">Cookie Policy</a>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <div class="text-white/40 text-sm">
                    powered by <span class="text-orange-500 font-semibold">mookh.</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const lightModeToggle = document.getElementById('light-mode-toggle');
            const body = document.body;
            
            // Check for saved theme preference or respect OS preference
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                body.classList.remove('light-mode');
                darkModeToggle.classList.add('active');
                lightModeToggle.classList.remove('active');
            } else {
                body.classList.add('light-mode');
                lightModeToggle.classList.add('active');
                darkModeToggle.classList.remove('active');
            }
            
            // Dark mode toggle
            darkModeToggle.addEventListener('click', function() {
                body.classList.remove('light-mode');
                localStorage.theme = 'dark';
                darkModeToggle.classList.add('active');
                lightModeToggle.classList.remove('active');
            });
            
            // Light mode toggle
            lightModeToggle.addEventListener('click', function() {
                body.classList.add('light-mode');
                localStorage.theme = 'light';
                lightModeToggle.classList.add('active');
                darkModeToggle.classList.remove('active');
            });
            
            // Countdown timer
            function updateCountdown() {
                const eventDate = new Date('2025-08-22T17:00:00');
                const now = new Date();
                const diff = eventDate - now;
                
                if (diff > 0) {
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    document.getElementById('days').textContent = days;
                    document.getElementById('hours').textContent = hours;
                    document.getElementById('minutes').textContent = minutes;
                    document.getElementById('seconds').textContent = seconds;
                }
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
            
            // Find matches button
            const findMatchesBtn = document.getElementById('find-matches-btn');
            if (findMatchesBtn) {
                findMatchesBtn.addEventListener('click', function() {
                    // Add your search logic here
                    alert('Searching for matches...');
                });
            }
        });
    </script>
</body>
</html>