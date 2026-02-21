None selected 

Skip to content
Using Gmail with screen readers
in:sent 
Conversations
11% of 15 GB used
Terms · Privacy · Programme Policies
Last account activity: 2 hours ago
Details
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Aurora Tourism</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #0a0e27;
            --secondary-dark: #1a1d3a;
            --accent-gold: #ffd700;
            --accent-blue: #00d4ff;
            --text-light: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--primary-dark);
            color: var(--text-light);
            min-height: 100vh;
        }

        header {
            background: linear-gradient(135deg, var(--secondary-dark), var(--primary-dark));
            box-shadow: 0 4px 20px rgba(0, 212, 255, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(45deg, var(--accent-gold), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: var(--text-light) !important;
            margin: 0 1rem;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: var(--accent-gold) !important;
            transform: translateY(-2px);
        }

        .main-container {
            padding: 3rem 0;
            min-height: calc(100vh - 80px);
        }

        .page-title {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--accent-gold), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-subtitle {
            text-align: center;
            color: var(--text-light);
            margin-bottom: 3rem;
        }

        .search-section {
            background: linear-gradient(135deg, var(--secondary-dark), rgba(0, 212, 255, 0.1));
            border: 1px solid var(--accent-blue);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--accent-blue);
            color: var(--text-light);
            padding: 0.8rem;
            border-radius: 10px;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-gold);
            color: var(--text-light);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
            outline: none;
        }

        .btn-search {
            background: linear-gradient(45deg, var(--accent-gold), var(--accent-blue));
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 10px;
            color: var(--primary-dark);
            font-weight: bold;
        }

        .btn-search:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(255, 215, 0, 0.4);
        }

        .filter-section {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .filter-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--accent-blue);
            color: var(--text-light);
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--accent-gold);
            color: var(--primary-dark);
            border-color: var(--accent-gold);
        }

        .booking-card {
            background: linear-gradient(135deg, var(--secondary-dark), var(--primary-dark));
            border: 1px solid var(--accent-gold);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .booking-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--accent-gold);
        }

        .booking-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .booking-reference {
            font-size: 1.5rem;
            color: var(--accent-gold);
            font-weight: bold;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid #ffc107;
        }

        .status-confirmed {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #28a745;
        }

        .status-cancelled {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .status-completed {
            background: rgba(0, 212, 255, 0.2);
            color: var(--accent-blue);
            border: 1px solid var(--accent-blue);
        }

        .booking-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item i {
            color: var(--accent-blue);
            font-size: 1.2rem;
        }

        .info-label {
            color: #999;
            font-size: 0.9rem;
        }

        .info-value {
            color: var(--text-light);
            font-weight: 500;
        }

        .booking-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-view {
            background: var(--accent-blue);
            color: var(--primary-dark);
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
        }

        .btn-view:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.4);
        }

        .loading {
            text-align: center;
            padding: 3rem;
            color: var(--accent-gold);
            font-size: 1.5rem;
        }

        .no-bookings {
            text-align: center;
            padding: 3rem;
            background: linear-gradient(135deg, var(--secondary-dark), rgba(0, 212, 255, 0.1));
            border: 1px solid var(--accent-blue);
            border-radius: 15px;
        }

        .no-bookings i {
            font-size: 4rem;
            color: var(--accent-gold);
            margin-bottom: 1rem;
        }

        .alert {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #28a745;
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 2000;
            overflow-y: auto;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background: linear-gradient(135deg, var(--secondary-dark), var(--primary-dark));
            border: 2px solid var(--accent-gold);
            border-radius: 20px;
            padding: 2rem;
            max-width: 800px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2rem;
            color: var(--accent-gold);
            cursor: pointer;
            background: none;
            border: none;
        }

        .modal-title {
            color: var(--accent-gold);
            margin-bottom: 2rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section h4 {
            color: var(--accent-blue);
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--accent-blue);
            padding-bottom: 0.5rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .detail-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 8px;
        }

        .detail-label {
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .detail-value {
            color: var(--text-light);
            font-size: 1.1rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.html"><i class="fas fa-plane-departure"></i> AURORA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" href="mybookings.php">My Bookings</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="main-container">
        <div class="container">
            <h1 class="page-title">My Bookings</h1>
            <p class="page-subtitle">Track and manage all your travel bookings</p>

            <!-- Search Section -->
            <div class="search-section">
                <div class="row">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <input type="text" class="form-control search-input" id="searchInput" 
                               placeholder="Search by booking reference, email, or name...">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-search w-100" onclick="searchBookings()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>

                <div class="filter-section">
                    <button class="filter-btn active" data-status="all" onclick="filterBookings('all')">
                        <i class="fas fa-list"></i> All Bookings
                    </button>
                    <button class="filter-btn" data-status="pending" onclick="filterBookings('pending')">
                        <i class="fas fa-clock"></i> Pending
                    </button>
                    <button class="filter-btn" data-status="confirmed" onclick="filterBookings('confirmed')">
                        <i class="fas fa-check-circle"></i> Confirmed
                    </button>
                    <button class="filter-btn" data-status="completed" onclick="filterBookings('completed')">
                        <i class="fas fa-flag-checkered"></i> Completed
                    </button>
                    <button class="filter-btn" data-status="cancelled" onclick="filterBookings('cancelled')">
                        <i class="fas fa-times-circle"></i> Cancelled
                    </button>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Loading Indicator -->
            <div class="loading" id="loadingIndicator">
                <i class="fas fa-spinner fa-spin"></i> Loading bookings...
            </div>

            <!-- Bookings Container -->
            <div id="bookingsContainer"></div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal()">&times;</button>
            <h2 class="modal-title">Booking Details</h2>
            <div id="modalContent"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allBookings = [];
        let currentFilter = 'all';

        // Load bookings on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadBookings();
        });

        // Load all bookings
        async function loadBookings() {
            const loadingIndicator = document.getElementById('loadingIndicator');
            const bookingsContainer = document.getElementById('bookingsContainer');
            
            loadingIndicator.style.display = 'block';
            bookingsContainer.innerHTML = '';

            try {
                const response = await fetch('api.php?action=get_bookings&limit=100');
                const data = await response.json();

                loadingIndicator.style.display = 'none';

                if (data.success && data.bookings.length > 0) {
                    allBookings = data.bookings;
                    displayBookings(allBookings);
                } else {
                    bookingsContainer.innerHTML = `
                        <div class="no-bookings">
                            <i class="fas fa-inbox"></i>
                            <h3>No Bookings Found</h3>
                            <p>You don't have any bookings yet. Start exploring our packages!</p>
                            <a href="index.html" class="btn btn-search mt-3">
                                <i class="fas fa-plane"></i> Browse Packages
                            </a>
                        </div>
                    `;
                }
            } catch (error) {
                loadingIndicator.style.display = 'none';
                showAlert('error', 'Failed to load bookings. Please try again.');
                console.error('Error:', error);
            }
        }

        // Display bookings
        function displayBookings(bookings) {
            const container = document.getElementById('bookingsContainer');
            
            if (bookings.length === 0) {
                container.innerHTML = `
                    <div class="no-bookings">
                        <i class="fas fa-search"></i>
                        <h3>No Bookings Found</h3>
                        <p>No bookings match your search criteria.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = bookings.map(booking => `
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-reference">
                            <i class="fas fa-ticket-alt"></i> ${booking.booking_reference}
                        </div>
                        <span class="status-badge status-${booking.status}">
                            ${booking.status}
                        </span>
                    </div>

                    <div class="booking-info">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <div class="info-label">Name</div>
                                <div class="info-value">${booking.full_name}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <div class="info-label">Destination</div>
                                <div class="info-value">${booking.destination}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <div>
                                <div class="info-label">Travel Date</div>
                                <div class="info-value">${formatDate(booking.travel_date)}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <div class="info-label">Travelers</div>
                                <div class="info-value">${booking.travelers} Person(s)</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-rupee-sign"></i>
                            <div>
                                <div class="info-label">Total Price</div>
                                <div class="info-value">₹${parseFloat(booking.total_price).toLocaleString('en-IN')}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-box"></i>
                            <div>
                                <div class="info-label">Package</div>
                                <div class="info-value">${booking.package_name}</div>
                            </div>
                        </div>
                    </div>

                    <div class="booking-actions">
                        <button class="btn-action btn-view" onclick="viewDetails(${booking.id})">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                        ${booking.status === 'pending' ? `
                            <button class="btn-action btn-cancel" onclick="cancelBooking(${booking.id}, '${booking.booking_reference}')">
                                <i class="fas fa-times"></i> Cancel Booking
                            </button>
                        ` : ''}
                    </div>
                </div>
            `).join('');
        }

        // Filter bookings by status
        function filterBookings(status) {
            currentFilter = status;

            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.status === status) {
                    btn.classList.add('active');
                }
            });

            // Filter bookings
            let filtered = allBookings;
            if (status !== 'all') {
                filtered = allBookings.filter(b => b.status === status);
            }

            displayBookings(filtered);
        }

        // Search bookings
        function searchBookings() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            
            let filtered = allBookings;
            if (currentFilter !== 'all') {
                filtered = filtered.filter(b => b.status === currentFilter);
            }

            if (query) {
                filtered = filtered.filter(b => 
                    b.booking_reference.toLowerCase().includes(query) ||
                    b.full_name.toLowerCase().includes(query) ||
                    b.email.toLowerCase().includes(query) ||
                    b.destination.toLowerCase().includes(query)
                );
            }

            displayBookings(filtered);
        }

        // Allow search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchBookings();
            }
        });

        // View booking details
        async function viewDetails(bookingId) {
            try {
                const response = await fetch(`api.php?action=get_booking&id=${bookingId}`);
                const data = await response.json();

                if (data.success) {
                    const booking = data.booking;
                    document.getElementById('modalContent').innerHTML = `
                        <div class="detail-section">
                            <h4><i class="fas fa-info-circle"></i> Booking Information</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Booking Reference</div>
                                    <div class="detail-value">${booking.booking_reference}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value">
                                        <span class="status-badge status-${booking.status}">${booking.status}</span>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Booking Date</div>
                                    <div class="detail-value">${formatDateTime(booking.created_at)}</div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4><i class="fas fa-user"></i> Customer Information</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Full Name</div>
                                    <div class="detail-value">${booking.full_name}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Email</div>
                                    <div class="detail-value">${booking.email}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Phone</div>
                                    <div class="detail-value">${booking.phone}</div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4><i class="fas fa-plane"></i> Travel Information</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Destination</div>
                                    <div class="detail-value">${booking.destination}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Package Name</div>
                                    <div class="detail-value">${booking.package_name}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Package Type</div>
                                    <div class="detail-value">${booking.package_type}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Travel Date</div>
                                    <div class="detail-value">${formatDate(booking.travel_date)}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Number of Travelers</div>
                                    <div class="detail-value">${booking.travelers}</div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4><i class="fas fa-rupee-sign"></i> Payment Information</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Package Price (per person)</div>
                                    <div class="detail-value">₹${parseFloat(booking.package_price).toLocaleString('en-IN')}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Total Price</div>
                                    <div class="detail-value" style="font-size: 1.5rem; color: var(--accent-gold);">
                                        ₹${parseFloat(booking.total_price).toLocaleString('en-IN')}
                                    </div>
                                </div>
                            </div>
                        </div>

                        ${booking.special_requirements ? `
                            <div class="detail-section">
                                <h4><i class="fas fa-comment"></i> Special Requirements</h4>
                                <div class="detail-item">
                                    <div class="detail-value">${booking.special_requirements}</div>
                                </div>
                            </div>
                        ` : ''}
                    `;
                    document.getElementById('detailsModal').classList.add('show');
                } else {
                    showAlert('error', 'Failed to load booking details.');
                }
            } catch (error) {
                showAlert('error', 'Error loading booking details.');
                console.error('Error:', error);
            }
        }

        // Cancel booking
        async function cancelBooking(bookingId, bookingReference) {
            if (!confirm(`Are you sure you want to cancel booking ${bookingReference}?`)) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('action', 'update_booking');
                formData.append('id', bookingId);
                formData.append('status', 'cancelled');

                const response = await fetch('api.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert('success', `Booking ${bookingReference} has been cancelled successfully.`);
                    loadBookings(); // Reload bookings
                } else {
                    showAlert('error', 'Failed to cancel booking: ' + data.message);
                }
            } catch (error) {
                showAlert('error', 'Error cancelling booking. Please try again.');
                console.error('Error:', error);
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('detailsModal').classList.remove('show');
        }

        // Show alert message
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            
            alertContainer.innerHTML = `
                <div class="alert ${alertClass}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    ${message}
                </div>
            `;

            // Auto-hide after 5 seconds
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-IN', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }

        // Format date and time
        function formatDateTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-IN', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    </script>
</body>
</html>
mybookings.php
Displaying mybookings.php.