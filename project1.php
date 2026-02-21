// ============================================
// FILE 1: search.php
// ============================================
<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'aurora_tourism';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

if (isset($_GET['query']) || isset($_POST['query'])) {
    
    $search_query = isset($_GET['query']) ? $_GET['query'] : $_POST['query'];
    $search_query = mysqli_real_escape_string($conn, $search_query);
    
    if (empty($search_query)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a search query']);
        exit();
    }
    
    $sql = "SELECT * FROM packages 
            WHERE (country LIKE '%$search_query%' 
            OR package_name LIKE '%$search_query%' 
            OR destination LIKE '%$search_query%'
            OR type LIKE '%$search_query%')
            AND status = 'active'
            ORDER BY price ASC";
    
    $result = $conn->query($sql);
    $packages = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $packages[] = [
                'id' => $row['id'],
                'package_name' => $row['package_name'],
                'country' => $row['country'],
                'destination' => $row['destination'],
                'type' => $row['type'],
                'duration' => $row['duration_days'] . ' Days / ' . $row['duration_nights'] . ' Nights',
                'price' => number_format($row['price'], 2),
                'max_members' => $row['max_members'],
                'description' => $row['description'],
                'features' => $row['features'],
                'image_url' => $row['image_url']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'count' => count($packages),
            'search_query' => $search_query,
            'packages' => $packages
        ]);
        
    } else {
        echo json_encode([
            'success' => false,
            'count' => 0,
            'message' => 'No packages found for "' . htmlspecialchars($search_query) . '"',
            'packages' => []
        ]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'No search query provided']);
}

$conn->close();
?>


// ============================================
// FILE 2: process_booking.php
// ============================================
<?php
session_start();
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'aurora_tourism';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $members = (int)$_POST['members'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $startdate = mysqli_real_escape_string($conn, $_POST['startdate']);
    $enddate = mysqli_real_escape_string($conn, $_POST['enddate']);
    $passport = isset($_POST['passport']) ? mysqli_real_escape_string($conn, $_POST['passport']) : '';
    $visa_required = isset($_POST['visa']) ? 1 : 0;
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $total_amount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0;
    
    if (empty($fullname) || empty($email) || empty($phone) || empty($package)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
        exit();
    }
    
    $upload_dir = "uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $aadhar_path = "";
    if (isset($_FILES['aadhar']) && $_FILES['aadhar']['error'] == 0) {
        $aadhar_name = time() . "_aadhar_" . basename($_FILES['aadhar']['name']);
        $aadhar_path = $upload_dir . $aadhar_name;
        move_uploaded_file($_FILES['aadhar']['tmp_name'], $aadhar_path);
    }
    
    $license_path = "";
    if (isset($_FILES['license']) && $_FILES['license']['error'] == 0) {
        $license_name = time() . "_license_" . basename($_FILES['license']['name']);
        $license_path = $upload_dir . $license_name;
        move_uploaded_file($_FILES['license']['tmp_name'], $license_path);
    }
    
    $passport_file_path = "";
    if (isset($_FILES['passport_copy']) && $_FILES['passport_copy']['error'] == 0) {
        $passport_file_name = time() . "_passport_" . basename($_FILES['passport_copy']['name']);
        $passport_file_path = $upload_dir . $passport_file_name;
        move_uploaded_file($_FILES['passport_copy']['tmp_name'], $passport_file_path);
    }
    
    $visa_path = "";
    if (isset($_FILES['visa_copy']) && $_FILES['visa_copy']['error'] == 0) {
        $visa_file_name = time() . "_visa_" . basename($_FILES['visa_copy']['name']);
        $visa_path = $upload_dir . $visa_file_name;
        move_uploaded_file($_FILES['visa_copy']['tmp_name'], $visa_path);
    }
    
    $booking_reference = 'AUR' . date('Ymd') . rand(1000, 9999);
    
    $sql = "INSERT INTO bookings (
        booking_reference, fullname, email, phone, members, address, 
        package_name, start_date, end_date, 
        passport_number, visa_required, 
        payment_method, total_amount, 
        aadhar_path, license_path, passport_path, visa_path,
        booking_status, booking_date
    ) VALUES (
        '$booking_reference', '$fullname', '$email', '$phone', $members, '$address',
        '$package', '$startdate', '$enddate',
        '$passport', $visa_required,
        '$payment_method', $total_amount,
        '$aadhar_path', '$license_path', '$passport_file_path', '$visa_path',
        'pending', NOW()
    )";
    
    if ($conn->query($sql) === TRUE) {
        $booking_id = $conn->insert_id;
        
        if ($payment_method == 'upi') {
            $upi_id = isset($_POST['upi_id']) ? mysqli_real_escape_string($conn, $_POST['upi_id']) : '';
            $transaction_id = isset($_POST['transaction_id']) ? mysqli_real_escape_string($conn, $_POST['transaction_id']) : '';
            
            $payment_sql = "INSERT INTO payments (booking_id, payment_method, upi_id, transaction_id, amount, payment_status, payment_date)
                           VALUES ($booking_id, 'UPI', '$upi_id', '$transaction_id', $total_amount, 'pending', NOW())";
            $conn->query($payment_sql);
            
        } elseif ($payment_method == 'bank') {
            $account_number = isset($_POST['account_number']) ? mysqli_real_escape_string($conn, $_POST['account_number']) : '';
            $ifsc = isset($_POST['ifsc']) ? mysqli_real_escape_string($conn, $_POST['ifsc']) : '';
            $transaction_id = isset($_POST['bank_transaction_id']) ? mysqli_real_escape_string($conn, $_POST['bank_transaction_id']) : '';
            
            $payment_sql = "INSERT INTO payments (booking_id, payment_method, account_number, ifsc_code, transaction_id, amount, payment_status, payment_date)
                           VALUES ($booking_id, 'Bank Transfer', '$account_number', '$ifsc', '$transaction_id', $total_amount, 'pending', NOW())";
            $conn->query($payment_sql);
            
        } elseif ($payment_method == 'card') {
            $card_holder = isset($_POST['card_holder']) ? mysqli_real_escape_string($conn, $_POST['card_holder']) : '';
            $card_number = isset($_POST['card_number']) ? mysqli_real_escape_string($conn, $_POST['card_number']) : '';
            $card_last4 = substr($card_number, -4);
            
            $payment_sql = "INSERT INTO payments (booking_id, payment_method, card_holder_name, card_last4, amount, payment_status, payment_date)
                           VALUES ($booking_id, 'Credit/Debit Card', '$card_holder', '$card_last4', $total_amount, 'pending', NOW())";
            $conn->query($payment_sql);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Booking successful!',
            'booking_id' => $booking_id,
            'booking_reference' => $booking_reference,
            'redirect' => 'booking_confirmation.php?id=' . $booking_id
        ]);
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking failed: ' . $conn->error]);
    }
}

$conn->close();
?>


// ============================================
// FILE 3: booking_confirmation.php
// ============================================
<?php
session_start();

$host = 'localhost';
$dbname = 'aurora_tourism';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed");
}

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($booking_id == 0) {
    header("Location: index.html");
    exit();
}

$sql = "SELECT b.*, p.payment_method, p.amount, p.transaction_id 
        FROM bookings b 
        LEFT JOIN payments p ON b.id = p.booking_id 
        WHERE b.id = $booking_id";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: index.html");
    exit();
}

$booking = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Aurora Tourism</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0a0e27, #1a1d3a);
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 50px 0;
        }
        .confirmation-card {
            background: linear-gradient(135deg, #1a1d3a, #0a0e27);
            border: 2px solid #ffd700;
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 10px 40px rgba(255, 215, 0, 0.3);
        }
        .success-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        .success-icon i {
            font-size: 80px;
            color: #00d4ff;
            animation: checkmark 0.8s ease;
        }
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        h2 {
            color: #ffd700;
            text-align: center;
            margin-bottom: 30px;
        }
        .booking-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .info-label {
            color: #ffd700;
            font-weight: 500;
        }
        .info-value {
            color: #e0e0e0;
        }
        .btn-primary {
            background: linear-gradient(45deg, #ffd700, #00d4ff);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: #0a0e27;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.5);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #00d4ff;
            padding: 12px 30px;
            border-radius: 25px;
            color: #e0e0e0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h2>Booking Confirmed!</h2>
            
            <p class="text-center mb-4">Thank you for booking with Aurora Tourism. Your trip is confirmed!</p>
            
            <div class="booking-info">
                <div class="info-row">
                    <span class="info-label">Booking ID:</span>
                    <span class="info-value"><strong><?php echo $booking_id; ?></strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Reference Number:</span>
                    <span class="info-value"><strong><?php echo htmlspecialchars($booking['booking_reference']); ?></strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($booking['fullname']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($booking['email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value"><?php echo htmlspecialchars($booking['phone']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Package:</span>
                    <span class="info-value"><?php echo htmlspecialchars($booking['package_name']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Members:</span>
                    <span class="info-value"><?php echo $booking['members']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Travel Date:</span>
                    <span class="info-value"><?php echo date('d M Y', strtotime($booking['start_date'])); ?> to <?php echo date('d M Y', strtotime($booking['end_date'])); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value"><?php echo htmlspecialchars($booking['payment_method']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Amount:</span>
                    <span class="info-value"><strong style="color: #00d4ff;">₹<?php echo number_format($booking['total_amount'], 2); ?></strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Booking Status:</span>
                    <span class="info-value"><span class="badge bg-warning"><?php echo ucfirst($booking['booking_status']); ?></span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Booking Date:</span>
                    <span class="info-value"><?php echo date('d M Y, h:i A', strtotime($booking['booking_date'])); ?></span>
                </div>
            </div>
            
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Important:</strong> A confirmation email has been sent to <?php echo htmlspecialchars($booking['email']); ?>. 
                Please check your email for further details and instructions.
            </div>
            
            <div class="text-center mt-4">
                <a href="index.html" class="btn btn-primary me-2">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print me-2"></i>Print Confirmation
                </button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


// ============================================
// FILE 4: database.sql
// ============================================
-- Create Database
CREATE DATABASE IF NOT EXISTS aurora_tourism;
USE aurora_tourism;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Packages Table
CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_name VARCHAR(200) NOT NULL,
    country VARCHAR(100) NOT NULL,
    destination VARCHAR(200) NOT NULL,
    type ENUM('family', 'honeymoon', 'student', 'seasonal') NOT NULL,
    duration_days INT NOT NULL,
    duration_nights INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    max_members INT DEFAULT 1,
    description TEXT,
    features TEXT,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Bookings Table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_reference VARCHAR(50),
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    members INT NOT NULL,
    address TEXT NOT NULL,
    package_name VARCHAR(200) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    passport_number VARCHAR(50),
    visa_required BOOLEAN DEFAULT 0,
    payment_method VARCHAR(50) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    aadhar_path VARCHAR(500),
    license_path VARCHAR(500),
    passport_path VARCHAR(500),
    visa_path VARCHAR(500),
    booking_status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Payments Table
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    upi_id VARCHAR(100),
    transaction_id VARCHAR(100),
    account_number VARCHAR(50),
    ifsc_code VARCHAR(20),
    card_holder_name VARCHAR(100),
    card_last4 VARCHAR(4),
    amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

-- Insert Sample Packages
INSERT INTO packages (package_name, country, destination, type, duration_days, duration_nights, price, max_members, description, features, image_url, status) VALUES
('Paris Family Package', 'France', 'Paris', 'family', 7, 6, 50000.00, 4, 'Experience the magic of Paris with your family', 'Eiffel Tower, Disneyland, 4-star Hotel', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34', 'active'),
('Dubai Family Package', 'UAE', 'Dubai', 'family', 5, 4, 40000.00, 4, 'Explore the wonders of Dubai', 'Desert Safari, Burj Khalifa, 5-star Resort', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c', 'active'),
('Thailand Family Package', 'Thailand', 'Bangkok & Phuket', 'family', 6, 5, 35000.00, 4, 'Beach and city combined', 'Island Hopping, Safari Park, Beach Resort', 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a', 'active'),
('Maldives Honeymoon', 'Maldives', 'Male', 'honeymoon', 5, 4, 20000.00, 2, 'Paradise for newlyweds', 'Overwater Villa, Candlelight Dinner, Spa', 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8', 'active'),
('Switzerland Honeymoon', 'Switzerland', 'Zurich & Interlaken', 'honeymoon', 7, 6, 60000.00, 2, 'Romance in the Alps', 'Luxury Chalet, Alps Tour, Lake Cruise', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4', 'active'),
('Bali Honeymoon', 'Indonesia', 'Bali', 'honeymoon', 6, 5, 56000.00, 2, 'Tropical honeymoon paradise', 'Private Pool Villa, Temple Tours, Beach', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4', 'active'),
('Singapore Student Trip', 'Singapore', 'Singapore', 'student', 4, 3, 35999.00, 1, 'Budget-friendly Singapore trip', 'Universal Studios, Budget Hostel, City Tour', 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd', 'active'),
('Malaysia Student Package', 'Malaysia', 'Kuala Lumpur', 'student', 5, 4, 29999.00, 1, 'Affordable Malaysian adventure', 'Petronas Tower, Genting, Shared Accommodation', 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07', 'active'),
('Vietnam Student Tour', 'Vietnam', 'Hanoi & Halong', 'student', 6, 5, 32999.00, 1, 'Discover Vietnam on a budget', 'Halong Bay, City Tour, Hostel Stay', 'https://images.unsplash.com/photo-1583417319070-4a69db38a482', 'active');

-- Insert Admin User (password: admin123)
INSERT INTO users (name, email, phone, password, status) VALUES
('Admin', 'admin@aurora.com', '9876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active');