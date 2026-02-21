// ─── Complete countries/packages list matching the HTML ───────────────────────
const countries = [
    // Family Packages
    { name: 'France',       category: 'Family',    price: 89000,  duration: '7 Days / 6 Nights',  type: 'Family of 4' },
    { name: 'New York',     category: 'Family',    price: 100000, duration: '8 Days / 7 Nights',  type: 'Family of 4' },
    { name: 'Thailand',     category: 'Family',    price: 55000,  duration: '6 Days / 5 Nights',  type: 'Family of 4' },
    { name: 'Dubai',        category: 'Family',    price: 75000,  duration: '5 Days / 4 Nights',  type: 'Family of 4' },
    { name: 'Singapore',    category: 'Family',    price: 68000,  duration: '5 Days / 4 Nights',  type: 'Family of 4' },
    { name: 'Italy',        category: 'Family',    price: 95000,  duration: '8 Days / 7 Nights',  type: 'Family of 4' },
    { name: 'Australia',    category: 'Family',    price: 125000, duration: '10 Days / 9 Nights', type: 'Family of 4' },
    { name: 'Japan',        category: 'Family',    price: 110000, duration: '7 Days / 6 Nights',  type: 'Family of 4' },
    { name: 'Spain',        category: 'Family',    price: 92000,  duration: '7 Days / 6 Nights',  type: 'Family of 4' },
    { name: 'Turkey',       category: 'Family',    price: 72000,  duration: '6 Days / 5 Nights',  type: 'Family of 4' },
    { name: 'South Africa', category: 'Family',    price: 105000, duration: '8 Days / 7 Nights',  type: 'Family of 4' },
    { name: 'Canada',       category: 'Family',    price: 115000, duration: '9 Days / 8 Nights',  type: 'Family of 4' },
    { name: 'Egypt',        category: 'Family',    price: 82000,  duration: '7 Days / 6 Nights',  type: 'Family of 4' },
    { name: 'Portugal',     category: 'Family',    price: 85000,  duration: '6 Days / 5 Nights',  type: 'Family of 4' },
    { name: 'Morocco',      category: 'Family',    price: 78000,  duration: '6 Days / 5 Nights',  type: 'Family of 4' },
    { name: 'Germany',      category: 'Family',    price: 88000,  duration: '7 Days / 6 Nights',  type: 'Family of 4' },

    // Honeymoon Packages
    { name: 'Maldives',     category: 'Honeymoon', price: 95000,  duration: '5 Days / 4 Nights',  type: 'Couple Package' },
    { name: 'Switzerland',  category: 'Honeymoon', price: 120000, duration: '7 Days / 6 Nights',  type: 'Couple Package' },
    { name: 'Bali',         category: 'Honeymoon', price: 78000,  duration: '6 Days / 5 Nights',  type: 'Couple Package' },
    { name: 'Greece',       category: 'Honeymoon', price: 115000, duration: '7 Days / 6 Nights',  type: 'Couple Package' },
    { name: 'Paris',        category: 'Honeymoon', price: 105000, duration: '6 Days / 5 Nights',  type: 'Couple Package' },
    { name: 'Seychelles',   category: 'Honeymoon', price: 110000, duration: '5 Days / 4 Nights',  type: 'Couple Package' },
    { name: 'Mauritius',    category: 'Honeymoon', price: 88000,  duration: '6 Days / 5 Nights',  type: 'Couple Package' },
    { name: 'Santorini',    category: 'Honeymoon', price: 125000, duration: '5 Days / 4 Nights',  type: 'Couple Package' },
    { name: 'Venice',       category: 'Honeymoon', price: 98000,  duration: '5 Days / 4 Nights',  type: 'Couple Package' },
    { name: 'Fiji',         category: 'Honeymoon', price: 130000, duration: '7 Days / 6 Nights',  type: 'Couple Package' },
    { name: 'Prague',       category: 'Honeymoon', price: 92000,  duration: '6 Days / 5 Nights',  type: 'Couple Package' },
    { name: 'Bora Bora',    category: 'Honeymoon', price: 150000, duration: '6 Days / 5 Nights',  type: 'Couple Package' },
    { name: 'Iceland',      category: 'Honeymoon', price: 135000, duration: '7 Days / 6 Nights',  type: 'Couple Package' },
    { name: 'New Zealand',  category: 'Honeymoon', price: 140000, duration: '8 Days / 7 Nights',  type: 'Couple Package' },
    { name: 'Amalfi Coast', category: 'Honeymoon', price: 108000, duration: '6 Days / 5 Nights',  type: 'Couple Package' },
    { name: 'Norway',       category: 'Honeymoon', price: 118000, duration: '7 Days / 6 Nights',  type: 'Couple Package' },

    // Student Packages
    { name: 'Malaysia',       category: 'Student', price: 35000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Vietnam',        category: 'Student', price: 38000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Cambodia',       category: 'Student', price: 32000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Sri Lanka',      category: 'Student', price: 30000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Indonesia',      category: 'Student', price: 36000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Nepal',          category: 'Student', price: 28000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Philippines',    category: 'Student', price: 40000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Laos',           category: 'Student', price: 34000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Myanmar',        category: 'Student', price: 33000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Bhutan',         category: 'Student', price: 42000, duration: '5 Days / 4 Nights', type: 'Per Person' },
    { name: 'Georgia',        category: 'Student', price: 45000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Armenia',        category: 'Student', price: 43000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Jordan',         category: 'Student', price: 48000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Poland',         category: 'Student', price: 46000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Czech Republic', category: 'Student', price: 47000, duration: '6 Days / 5 Nights', type: 'Per Person' },
    { name: 'Hungary',        category: 'Student', price: 44000, duration: '6 Days / 5 Nights', type: 'Per Person' },
];

// ─── Search ────────────────────────────────────────────────────────────────────
const searchInput    = document.getElementById('searchInput');
const searchDropdown = document.getElementById('searchDropdown');

searchInput.addEventListener('input', function () {
    const query = this.value.trim().toLowerCase();
    if (query.length > 0) {
        const results = countries.filter(c => c.name.toLowerCase().includes(query));
        displaySearchResults(results);
    } else {
        searchDropdown.classList.remove('show');
    }
});

function displaySearchResults(results) {
    if (results.length > 0) {
        searchDropdown.innerHTML = results
            .map(c => `<div class="search-dropdown-item" onclick="scrollToPackage('${c.name}', '${c.category}')">
                            <i class="fas fa-map-marker-alt"></i> ${c.name} — ${c.category} Package
                        </div>`)
            .join('');
    } else {
        searchDropdown.innerHTML = '<div class="search-dropdown-item">No results found</div>';
    }
    searchDropdown.classList.add('show');
}

function performSearch() {
    const query = searchInput.value.trim().toLowerCase();
    const result = countries.find(c => c.name.toLowerCase() === query);
    if (result) scrollToPackage(result.name, result.category);
}

function scrollToPackage(countryName, category) {
    searchDropdown.classList.remove('show');
    searchInput.value = '';
    // Scroll to the packages section and try to highlight the card if possible
    const packagesSection = document.getElementById('packages');
    if (packagesSection) {
        packagesSection.scrollIntoView({ behavior: 'smooth' });
    }
    // Optional: highlight the matching card
    setTimeout(() => {
        const allCards = document.querySelectorAll('.package-card, .card');
        allCards.forEach(card => {
            if (card.textContent.includes(countryName)) {
                card.style.outline = '3px solid #f59e0b';
                card.style.transition = 'outline 0.3s';
                setTimeout(() => { card.style.outline = ''; }, 2500);
            }
        });
    }, 600);
}

// Close dropdown when clicking outside
document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-container')) {
        searchDropdown.classList.remove('show');
    }
});

// ─── Booking Modal ─────────────────────────────────────────────────────────────
let basePackagePrice = 0;

function selectPackage(packageName, price, destination) {
    basePackagePrice = price;

    document.getElementById('packageNameDisplay').textContent = packageName;
    document.getElementById('totalPrice').textContent         = price.toLocaleString('en-IN');
    document.getElementById('packageNameInput').value         = packageName;
    document.getElementById('packagePriceInput').value        = price;
    document.getElementById('destinationInput').value         = destination;

    // Reset travelers to 1
    const travelersInput = document.querySelector('input[name="travelers"]');
    if (travelersInput) travelersInput.value = 1;

    // Auto-fill package type from data
    const pkg = countries.find(c => c.name === destination || c.name === packageName);
    if (pkg) {
        const typeSelect = document.querySelector('select[name="package_type"]');
        if (typeSelect) typeSelect.value = pkg.category;
    }

    document.getElementById('bookingModal').classList.add('show');
    hideMessages();
}

function updateTotalPrice() {
    const travelers  = parseInt(document.querySelector('input[name="travelers"]').value) || 1;
    const totalPrice = basePackagePrice * travelers;
    document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('en-IN');
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.remove('show');
    hideMessages();
}

// ─── Messages ─────────────────────────────────────────────────────────────────
function showMessage(type, message) {
    hideMessages();
    const el = document.getElementById(type === 'success' ? 'successMessage' : 'errorMessage');
    if (!el) return;
    el.textContent    = message;
    el.style.display  = 'block';
    if (type === 'success') {
        setTimeout(() => { el.style.display = 'none'; }, 5000);
    }
}

function hideMessages() {
    const s = document.getElementById('successMessage');
    const e = document.getElementById('errorMessage');
    if (s) s.style.display = 'none';
    if (e) e.style.display = 'none';
}

// ─── Form Submission ───────────────────────────────────────────────────────────
document.getElementById('bookingForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const submitBtn       = document.getElementById('submitBtn');
    const loadingIndicator = document.getElementById('loadingIndicator');

    submitBtn.disabled            = true;
    loadingIndicator.style.display = 'block';
    hideMessages();

    const formData   = new FormData(this);
    const travelers  = parseInt(formData.get('travelers')) || 1;
    const pkgPrice   = parseFloat(document.getElementById('packagePriceInput').value);
    const totalPrice = pkgPrice * travelers;
    formData.append('total_price', totalPrice);

    try {
        const response    = await fetch('api.php', { method: 'POST', body: formData });
        const contentType = response.headers.get('content-type');

        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server did not return JSON. Make sure api.php exists and Apache is running.');
        }

        const result = await response.json();

        if (result.success) {
            showMessage('success',
                `Booking successful! Your booking reference is: ${result.booking_reference}. ` +
                `Total amount: ₹${result.total_price.toLocaleString('en-IN')}`
            );
            this.reset();
            setTimeout(() => closeBookingModal(), 3000);
        } else {
            showMessage('error', 'Booking failed: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Booking error:', error);
        let msg = 'Error submitting booking. ';
        if (error.message.includes('JSON')) {
            msg += 'Please ensure: 1) Apache is running in XAMPP, 2) api.php is in the same folder as index.html, 3) MySQL is running, 4) Database "aurora_tourism" exists.';
        } else if (error.message.includes('Failed to fetch')) {
            msg += 'Cannot connect to server. Make sure Apache is running in XAMPP and you\'re accessing via http://localhost/';
        } else {
            msg += error.message;
        }
        showMessage('error', msg);
    } finally {
        submitBtn.disabled            = false;
        loadingIndicator.style.display = 'none';
    }
});

// ─── Init ──────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // Set minimum travel date to today
    const dateInput = document.querySelector('input[name="travel_date"]');
    if (dateInput) {
        dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
    }

    // Attach traveler input listener
    const travelersInput = document.querySelector('input[name="travelers"]');
    if (travelersInput) {
        travelersInput.addEventListener('input', updateTotalPrice);
    }
});