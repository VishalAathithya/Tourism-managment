None selected 

Skip to content
Using Gmail with screen readers
in:sent 
Conversations
11% of 15 GB used
Terms · Privacy · Programme Policies
Last account activity: 2 hours ago
Details
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'aurora_tourism';
$username = 'root';
$password = '';

try {
    // Create database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate required fields
        $required_fields = ['full_name', 'email', 'phone', 'travelers', 'travel_date', 'package_type', 'package_name', 'package_price', 'destination'];
        
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                echo json_encode([
                    'success' => false,
                    'message' => "Missing required field: $field"
                ]);
                exit;
            }
        }
        
        // Sanitize and validate input
        $full_name = trim($_POST['full_name']);
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone']);
        $travelers = intval($_POST['travelers']);
        $travel_date = $_POST['travel_date'];
        $package_type = $_POST['package_type'];
        $package_name = trim($_POST['package_name']);
        $package_price = floatval($_POST['package_price']);
        $destination = trim($_POST['destination']);
        $special_requirements = isset($_POST['special_requirements']) ? trim($_POST['special_requirements']) : '';
        
        // Validate email
        if (!$email) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid email address'
            ]);
            exit;
        }
        
        // Validate travelers
        if ($travelers < 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Number of travelers must be at least 1'
            ]);
            exit;
        }
        
        // Validate package type
        $valid_types = ['Family', 'Honeymoon', 'Student'];
        if (!in_array($package_type, $valid_types)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid package type'
            ]);
            exit;
        }
        
        // Calculate total price
        $total_price = $package_price * $travelers;
        
        // Generate booking reference
        $booking_reference = 'AUR' . date('Ymd') . rand(1000, 9999);
        
        // Check if booking reference already exists (very unlikely but safety check)
        $check_sql = "SELECT COUNT(*) FROM bookings WHERE booking_reference = :booking_reference";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([':booking_reference' => $booking_reference]);
        
        if ($check_stmt->fetchColumn() > 0) {
            // Generate a new one if exists
            $booking_reference = 'AUR' . date('Ymd') . rand(10000, 99999);
        }
        
        // Insert booking into database
        $sql = "INSERT INTO bookings (
            booking_reference, 
            full_name, 
            email, 
            phone, 
            travelers, 
            travel_date, 
            package_type, 
            package_name, 
            package_price, 
            total_price, 
            destination, 
            special_requirements,
            status
        ) VALUES (
            :booking_reference,
            :full_name,
            :email,
            :phone,
            :travelers,
            :travel_date,
            :package_type,
            :package_name,
            :package_price,
            :total_price,
            :destination,
            :special_requirements,
            'pending'
        )";
        
        $stmt = $conn->prepare($sql);
        
        $result = $stmt->execute([
            ':booking_reference' => $booking_reference,
            ':full_name' => $full_name,
            ':email' => $email,
            ':phone' => $phone,
            ':travelers' => $travelers,
            ':travel_date' => $travel_date,
            ':package_type' => $package_type,
            ':package_name' => $package_name,
            ':package_price' => $package_price,
            ':total_price' => $total_price,
            ':destination' => $destination,
            ':special_requirements' => $special_requirements
        ]);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Booking created successfully',
                'booking_reference' => $booking_reference,
                'total_price' => $total_price,
                'booking_id' => $conn->lastInsertId()
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create booking'
            ]);
        }
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
api.php
Displaying api.php.