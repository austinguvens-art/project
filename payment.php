<?php
session_start();

// Check if booking details exist
if (!isset($_SESSION['booking'])) {
    header('Location: index.php');
    exit;
}

$booking = $_SESSION['booking'];

// API Configuration
define('API_KEY', '626b72e25a694bc371e3bc5623645ceaa38b4453cceeb9755c11ef864b7bc20b');
define('CHANNEL_ID', '000083');
define('CALLBACK_URL', (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/callback.php');
define('API_BASE_URL', 'https://swiftwallet.co.ke/pay-app-v2/');

// Generate a unique reference for this transaction
$external_reference = 'PAMOJA' . date('YmdHis') . rand(100, 999);

// Handle form submission
$error = '';
$success = '';
$is_processing = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_number = preg_replace('/[^0-9]/', '', $_POST['phone_number']);
    $customer_name = trim($_POST['customer_name']);
    
    // Validate inputs
    if (empty($customer_name)) {
        $error = "Please enter your full name";
    } else {
        // Validate and format phone number
        $formatted_phone = validatePhoneNumber($phone_number);
        
        if (!$formatted_phone) {
            $error = "Invalid phone number format. Please use 07XXXXXXXX or 2547XXXXXXXX";
        } else {
            // Prepare API request
            $apiData = [
                'amount' => intval($booking['total_price']),
                'phone_number' => $formatted_phone,
                'external_reference' => $external_reference,
                'customer_name' => $customer_name,
                'callback_url' => CALLBACK_URL,
                'channel_id' => CHANNEL_ID
            ];
            
            // Make API request
            $apiResponse = makeAPIRequest($apiData);
            
            if (!$apiResponse) {
                $error = "Failed to connect to payment service. Please try again.";
            } else {
                $responseData = json_decode($apiResponse['response'], true);
                
                if ($apiResponse['http_code'] === 200 || $apiResponse['http_code'] === 201) {
                    if (isset($responseData['success']) && $responseData['success']) {
                        $success = "Payment initiated successfully! Please check your phone for the M-Pesa STK Push.";
                        $is_processing = true;
                        
                        // Store transaction reference in session
                        $_SESSION['transaction_reference'] = $external_reference;
                        
                        // Store payment details in session
                        $_SESSION['payment'] = [
                            'phone_number' => $formatted_phone,
                            'customer_name' => $customer_name,
                            'payment_method' => 'mpesa',
                            'transaction_reference' => $external_reference
                        ];
                        
                        // Save transaction to localStorage for the bookings page
                        echo "<script>
                            const transaction = {
                                id: '" . $external_reference . "',
                                match: '" . addslashes($booking['match']) . "',
                                venue: '" . addslashes($booking['venue']) . "',
                                date: '" . addslashes($booking['date']) . "',
                                quantity: " . $booking['quantity'] . ",
                                total: " . $booking['total_price'] . ",
                                customerName: '" . addslashes($customer_name) . "',
                                phone: '" . $formatted_phone . "',
                                status: 'pending',
                                bookingDate: new Date().toLocaleDateString()
                            };
                            
                            // Save to localStorage
                            const existingBookings = JSON.parse(localStorage.getItem('pamoja2025Bookings')) || [];
                            existingBookings.push(transaction);
                            localStorage.setItem('pamoja2025Bookings', JSON.stringify(existingBookings));
                        </script>";
                    } else {
                        $error = isset($responseData['error']) ? $responseData['error'] : "Payment initiation failed. Please try again.";
                    }
                } else {
                    $error = "Payment service error (HTTP " . $apiResponse['http_code'] . "). Please try again.";
                    if (isset($responseData['error'])) {
                        $error .= ": " . $responseData['error'];
                    }
                }
            }
        }
    }
}

// Phone validation function
function validatePhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) === 9 && substr($phone, 0, 1) === '7') {
        return '254' . $phone;
    } elseif (strlen($phone) === 10 && substr($phone, 0, 2) === '07') {
        return '254' . substr($phone, 1);
    } elseif (strlen($phone) === 12 && substr($phone, 0, 3) === '254') {
        return $phone;
    }
    
    return false;
}

// API request function
function makeAPIRequest($data) {
    $url = API_BASE_URL . 'payments.php';
    
    $headers = [
        'Authorization: Bearer ' . API_KEY,
        'Content-Type: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return false;
    }
    
    return [
        'http_code' => $httpCode,
        'response' => $response
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - PAMOJA 2025</title>
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
        
        .mpesa-card {
            background: linear-gradient(135deg, #00a651 0%, #008a44 100%);
            position: relative;
            overflow: hidden;
        }
        
        .mpesa-card::before {
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
        <div class="max-w-6xl mx-auto px-6">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-white/60 mb-8">
                <a href="index.php" class="hover:text-white transition-colors">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-sm"></i>
                <a href="booking.php" class="hover:text-white transition-colors">Book Tickets</a>
                <i class="fas fa-chevron-right text-sm"></i>
                <span class="text-white">Payment</span>
            </div>

            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Complete Your Payment</h1>
                <p class="text-white/60 text-lg">Secure payment for your match tickets via M-Pesa</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-900/20 border border-red-500/30 modern-rounded-xl p-4 mb-8">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                        <span class="text-red-400 font-medium">Payment Error</span>
                    </div>
                    <p class="text-white/80 mt-2"><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-900/20 border border-green-500/30 modern-rounded-xl p-4 mb-8">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-400"></i>
                        <span class="text-green-400 font-medium">Payment Initiated</span>
                    </div>
                    <p class="text-white/80 mt-2"><?php echo $success; ?></p>
                </div>
                
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 modern-rounded-full mb-6">
                        <i class="fas fa-mobile-alt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Check Your Phone</h3>
                    <p class="text-white/60 text-lg mb-8">You will receive an M-Pesa STK Push notification on your phone. Please enter your M-Pesa PIN to complete the payment.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="index.php" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 modern-rounded-xl transition-all duration-200">
                            <i class="fas fa-home mr-2"></i> Return Home
                        </a>
                        <a href="success.php" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 modern-rounded-xl transition-all duration-200">
                            <i class="fas fa-ticket-alt mr-2"></i> View Booking
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-800/50 backdrop-blur-sm modern-rounded-2xl border border-gray-700/50 p-6 sticky top-24">
                            <h3 class="text-xl font-bold text-white mb-6">Order Summary</h3>
                            
                            <div class="space-y-6">
                                <!-- Match Details -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <span class="fi fi-ke rounded-sm shadow-md text-xl"></span>
                                            <span class="font-bold text-white">KEN</span>
                                        </div>
                                        <span class="text-white/60">VS</span>
                                        <div class="flex items-center space-x-3">
                                            <span class="font-bold text-white">MAD</span>
                                            <span class="fi fi-mg rounded-sm shadow-md text-xl"></span>
                                        </div>
                                    </div>
                                    <div class="text-white/60 text-sm">
                                        <div><?php echo $booking['date']; ?> • <?php echo $booking['time']; ?></div>
                                        <div><?php echo $booking['venue']; ?></div>
                                    </div>
                                </div>
                                
                                <!-- Customer Details -->
                                <div class="border-t border-gray-700 pt-4">
                                    <h4 class="text-white font-semibold mb-3">Customer Details</h4>
                                    <div class="space-y-2 text-white/80 text-sm">
                                        <div><?php echo htmlspecialchars($booking['full_name']); ?></div>
                                        <div><?php echo htmlspecialchars($booking['email']); ?></div>
                                        <div><?php echo htmlspecialchars($booking['phone']); ?></div>
                                    </div>
                                </div>
                                
                                <!-- Ticket Details -->
                                <div class="border-t border-gray-700 pt-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-white/80">Tickets (<?php echo $booking['quantity']; ?>x)</span>
                                        <span class="text-white">Ksh <?php echo number_format($booking['price_per_ticket']); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center text-lg font-bold">
                                        <span class="text-white">Total Amount</span>
                                        <span class="text-white">Ksh <?php echo number_format($booking['total_price']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-800/50 backdrop-blur-sm modern-rounded-2xl border border-gray-700/50 p-8">
                            <h3 class="text-2xl font-bold text-white mb-6">M-Pesa Payment</h3>
                            
                            <form method="POST" action="" class="space-y-6">
                                <!-- Customer Name -->
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-white/80 mb-2">
                                        Full Name <span class="text-red-400">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="customer_name" 
                                        name="customer_name" 
                                        required
                                        class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-white/40"
                                        placeholder="Enter your full name"
                                        value="<?php echo isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : htmlspecialchars($booking['full_name']); ?>"
                                    >
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-white/80 mb-2">
                                        M-Pesa Phone Number <span class="text-red-400">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="phone_number" 
                                        name="phone_number" 
                                        required
                                        class="w-full bg-gray-700/50 border border-gray-600 modern-rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent placeholder-white/40"
                                        placeholder="e.g., 07XXXXXXXX or 2547XXXXXXXX"
                                        value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : htmlspecialchars($booking['phone']); ?>"
                                    >
                                    <p class="text-white/60 text-sm mt-2">You will receive a payment request on this number</p>
                                </div>

                                <!-- M-Pesa Payment Method -->
                                <div>
                                    <label class="block text-sm font-medium text-white/80 mb-4">Payment Method</label>
                                    <div class="mpesa-card modern-rounded-xl p-6 text-white relative">
                                        <div class="relative z-10">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 bg-white/20 modern-rounded-full flex items-center justify-center">
                                                    <i class="fas fa-mobile-alt text-2xl"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-lg">M-Pesa</div>
                                                    <div class="text-white/80 text-sm">Pay via M-Pesa STK Push</div>
                                                </div>
                                            </div>
                                            <div class="mt-4 text-sm text-white/80">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Instant payment confirmation</span>
                                                </div>
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Secure and encrypted</span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>No additional fees</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Notice -->
                                <div class="bg-green-900/20 border border-green-500/30 modern-rounded-xl p-4">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-shield-alt text-green-400"></i>
                                        <span class="text-green-400 font-medium">Secure Payment</span>
                                    </div>
                                    <p class="text-white/80 text-sm mt-2">Your payment is processed securely through M-Pesa. We never store your payment details.</p>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-6">
                                    <button 
                                        type="submit" 
                                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-4 px-6 modern-rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 text-lg"
                                    >
                                        <i class="fas fa-mobile-alt mr-3"></i>
                                        Pay Ksh <?php echo number_format($booking['total_price']); ?> via M-Pesa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
            const phoneInput = document.getElementById('phone_number');
            
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
            
            // Format phone number as user types
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    
                    if (value.startsWith('254')) {
                        if (value.length > 12) value = value.substring(0, 12);
                    } else if (value.startsWith('0')) {
                        if (value.length > 10) value = value.substring(0, 10);
                    } else {
                        if (value.length > 9) value = value.substring(0, 9);
                    }
                    
                    e.target.value = value;
                });
                
                // Auto-format on blur
                phoneInput.addEventListener('blur', function() {
                    let phone = this.value.replace(/\D/g, '');
                    
                    if (phone.length === 9 && phone.startsWith('7')) {
                        this.value = '254' + phone;
                    } else if (phone.length === 10 && phone.startsWith('07')) {
                        this.value = '254' + phone.substring(1);
                    }
                });
            }
        });
    </script>
</body>
</html> 