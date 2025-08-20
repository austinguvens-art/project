<?php
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store booking details in session
    $_SESSION['booking'] = [
        'full_name' => $_POST['full_name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'quantity' => $_POST['quantity'] ?? 1,
        'match' => 'Kenya vs Madagascar',
        'date' => '22 Aug 2025',
        'time' => '17:00',
        'venue' => 'Moi International Sports Centre',
        'price_per_ticket' => 250,
        'total_price' => ($_POST['quantity'] ?? 1) * 250
    ];
    
    // Redirect to payment page
    header('Location: payment.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets - PAMOJA 2025</title>
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
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        
        .select-custom {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23fff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px;
        }
        
        body.light-mode .select-custom {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%231e293b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        }
        
        .theme-toggle {
            transition: all 0.3s;
        }
        
        .theme-toggle.active {
            background-color: var(--primary);
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Header -->
    <header class="bg-black py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <a href="index.php" class="flex items-center">
                    <img src="logo.png" alt="CAF African Nations Championship" class="h-10 w-auto">
                </a>
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

    <!-- Main Content -->
    <main class="min-h-screen bg-black py-12">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-white/60 mb-8">
                <a href="index.php" class="hover:text-white transition-colors">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-sm"></i>
                <span class="text-white">Book Tickets</span>
            </div>

            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Book Your Tickets</h1>
                <p class="text-white/60 text-lg">Complete your booking details to secure your match experience</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Match Details Card -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800/50 backdrop-blur-sm modern-rounded-2xl border border-gray-700/50 p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-white mb-6">Match Details</h3>
                        
                        <div class="space-y-6">
                            <!-- Teams -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="fi fi-ke rounded-sm shadow-md text-2xl"></span>
                                    <span class="text-lg font-bold text-white">KEN</span>
                                </div>
                                
                                <div class="text-white/60 text-sm font-medium">VS</div>
                                
                                <div class="flex items-center space-x-3">
                                    <span class="text-lg font-bold text-white">MAD</span>
                                    <span class="fi fi-mg rounded-sm shadow-md text-2xl"></span>
                                </div>
                            </div>
                            
                            <!-- Date & Time -->
                            <div class="space-y-3">
                                <div class="flex items-center text-white/80">
                                    <i class="fas fa-calendar mr-3"></i>
                                    <span>22 August 2025</span>
                                </div>
                                <div class="flex items-center text-white/80">
                                    <i class="fas fa-clock mr-3"></i>
                                    <span>17:00 (EAT)</span>
                                </div>
                                <div class="flex items-center text-white/80">
                                    <i class="fas fa-map-marker-alt mr-3"></i>
                                    <span>Moi International Sports Centre</span>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="border-t border-gray-700 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80">Price per ticket:</span>
                                    <span class="text-xl font-bold text-white">Ksh 250</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-800/50 backdrop-blur-sm modern-rounded-2xl border border-gray-700/50 p-8">
                        <h3 class="text-2xl font-bold text-white mb-6">Personal Information</h3>
                        
                        <form method="POST" action="booking.php" class="space-y-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-white/80 mb-2">
                                    Full Name <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="full_name" 
                                    name="full_name" 
                                    required
                                    class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-white/40"
                                    placeholder="Enter your full name"
                                >
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-white/80 mb-2">
                                    Email Address <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required
                                    class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-white/40"
                                    placeholder="Enter your email address"
                                >
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-white/80 mb-2">
                                    Phone Number <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    required
                                    class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-white/40"
                                    placeholder="Enter your phone number"
                                >
                            </div>

                            <!-- Ticket Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-white/80 mb-2">
                                    Number of Tickets <span class="text-red-400">*</span>
                                </label>
                                <select 
                                    id="quantity" 
                                    name="quantity" 
                                    required
                                    class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 select-custom appearance-none pr-10"
                                >
                                    <option value="1">1 Ticket</option>
                                    <option value="2">2 Tickets</option>
                                    <option value="3">3 Tickets</option>
                                    <option value="4">4 Tickets</option>
                                    <option value="5">5 Tickets</option>
                                    <option value="6">6 Tickets</option>
                                    <option value="7">7 Tickets</option>
                                    <option value="8">8 Tickets</option>
                                    <option value="9">9 Tickets</option>
                                    <option value="10">10 Tickets</option>
                                </select>
                            </div>

                            <!-- Total Price Display -->
                            <div class="bg-gray-700/30 modern-rounded-xl p-4 border border-gray-600/50">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80">Total Amount:</span>
                                    <span class="text-2xl font-bold text-white" id="total-price">Ksh 250</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button 
                                    type="submit" 
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-4 px-6 modern-rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 text-lg"
                                >
                                    <i class="fas fa-credit-card mr-3"></i>
                                    Proceed to Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t border-gray-800 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
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
            const quantitySelect = document.getElementById('quantity');
            const totalPriceElement = document.getElementById('total-price');
            const pricePerTicket = 250;
            
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
            
            // Update total price when quantity changes
            function updateTotalPrice() {
                const quantity = parseInt(quantitySelect.value);
                const total = quantity * pricePerTicket;
                totalPriceElement.textContent = `Ksh ${total.toLocaleString()}`;
            }
            
            quantitySelect.addEventListener('change', updateTotalPrice);
            
            // Initialize total price
            updateTotalPrice();
        });
    </script>
</body>
</html> 