<?php
session_start();

// Check if booking and payment details exist
if (!isset($_SESSION['booking']) || !isset($_SESSION['payment'])) {
    header('Location: index.php');
    exit;
}

$booking = $_SESSION['booking'];
$payment = $_SESSION['payment'];

// Generate a booking reference
$booking_reference = 'PAMOJA' . date('Ymd') . rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - PAMOJA 2025</title>
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
        
        .theme-toggle {
            transition: all 0.3s;
        }
        
        .theme-toggle.active {
            background-color: var(--primary);
        }
        
        .ticket-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
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
                <a href="booking.php" class="hover:text-white transition-colors">Book Tickets</a>
                <i class="fas fa-chevron-right text-sm"></i>
                <a href="payment.php" class="hover:text-white transition-colors">Payment</a>
                <i class="fas fa-chevron-right text-sm"></i>
                <span class="text-white">Booking Details</span>
            </div>

            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Booking Details</h1>
                <p class="text-white/60 text-lg">Your match ticket information and payment details</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Ticket Details -->
                <div class="lg:col-span-1">
                    <div class="ticket-card modern-rounded-2xl p-6 text-white relative">
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">PAMOJA 2025</h3>
                                    <p class="text-white/80 text-sm">CAF African Nations Championship</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-white/80">Booking Ref</div>
                                    <div class="font-bold text-lg"><?php echo $booking_reference; ?></div>
                                </div>
                            </div>
                            
                            <!-- Match Details -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <span class="fi fi-ke rounded-sm shadow-md text-2xl"></span>
                                        <span class="text-xl font-bold">KEN</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-white/80 text-sm">VS</div>
                                        <div class="text-xs bg-white/20 text-white px-2 py-1 modern-rounded-md mt-1">CONFIRMED</div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="text-xl font-bold">MAD</span>
                                        <span class="fi fi-mg rounded-sm shadow-md text-2xl"></span>
                                    </div>
                                </div>
                                
                                <div class="space-y-2 text-white/80 text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-3"></i>
                                        <span><?php echo $booking['date']; ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock mr-3"></i>
                                        <span><?php echo $booking['time']; ?> (EAT)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-3"></i>
                                        <span><?php echo $booking['venue']; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Customer Details -->
                            <div class="border-t border-white/20 pt-4">
                                <div class="text-sm text-white/80 mb-2">Customer</div>
                                <div class="font-semibold"><?php echo htmlspecialchars($booking['full_name']); ?></div>
                                <div class="text-sm text-white/80"><?php echo htmlspecialchars($booking['email']); ?></div>
                            </div>
                            
                            <!-- Ticket Quantity -->
                            <div class="border-t border-white/20 pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80">Tickets</span>
                                    <span class="font-bold"><?php echo $booking['quantity']; ?>x</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-white/80">Total Paid</span>
                                    <span class="font-bold text-lg">Ksh <?php echo number_format($booking['total_price']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800/50 backdrop-blur-sm modern-rounded-2xl border border-gray-700/50 p-6">
                        <h3 class="text-xl font-bold text-white mb-6">Payment Information</h3>
                        
                        <div class="space-y-6">
                            <!-- Payment Method -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-green-500 modern-rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-mobile-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Payment Method</h4>
                                    <p class="text-white/60 text-sm">M-Pesa Mobile Money</p>
                                </div>
                            </div>
                            
                            <!-- Transaction Reference -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-blue-500 modern-rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Transaction Reference</h4>
                                    <p class="text-white/60 text-sm"><?php echo isset($payment['transaction_reference']) ? $payment['transaction_reference'] : 'N/A'; ?></p>
                                </div>
                            </div>
                            
                            <!-- Payment Status -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-orange-500 modern-rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Payment Status</h4>
                                    <p class="text-white/60 text-sm">Processing - Please complete payment on your phone</p>
                                </div>
                            </div>
                            
                            <!-- Contact Support -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 bg-purple-500 modern-rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-headset text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white mb-1">Need Help?</h4>
                                    <p class="text-white/60 text-sm">Contact our support team at +254 798 984828 or hello@mookh.africa</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-8 space-y-4">
                            <a href="index.php" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 modern-rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40">
                                <i class="fas fa-home mr-3"></i>
                                Back to Home
                            </a>
                            <a href="booking.php" class="w-full bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 modern-rounded-xl transition-all duration-200 flex items-center justify-center">
                                <i class="fas fa-ticket-alt mr-3"></i>
                                Book More Tickets
                            </a>
                        </div>
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
        });
    </script>
</body>
</html> 