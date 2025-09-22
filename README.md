# Sweet Delights Bakery - Complete Bakery Management System

A comprehensive bakery management system built with Laravel 11, featuring customer ordering, reservations, loyalty programs, and admin management.

## Features

### Customer Features
- **Menu Browsing**: View categorized bakery menu with detailed item information
- **Online Ordering**: Place orders with real-time cart management
- **Table Reservations**: Book tables with date/time selection
- **User Dashboard**: Track orders, reservations, and loyalty points
- **Loyalty Program**: Earn points and unlock tier benefits
- **Contact System**: Send inquiries with automated responses

### Admin Features
- **Dashboard Analytics**: Sales reports, user statistics, revenue tracking
- **Order Management**: View, update, and track all orders
- **Reservation Management**: Manage table bookings and availability
- **Menu Management**: Add, edit, and manage bakery items
- **User Management**: View and manage customer accounts
- **Contact Management**: Handle customer inquiries

### Technical Features
- **Authentication System**: Secure login/registration with role-based access
- **Database Design**: Optimized schema for bakery operations
- **API Endpoints**: RESTful API for mobile app integration
- **Responsive Design**: Mobile-first Bootstrap 5 interface
- **Real-time Updates**: Dynamic content updates without page refresh

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (default) or MySQL

### Step 1: Clone and Install Dependencies
```bash
git clone <repository-url>
cd sweet-delights-bakery
composer install
npm install
```

### Step 2: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Database Setup
```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations and seeders
php artisan migrate
php artisan db:seed

# Create admin users
php artisan db:seed --class=AdminSeeder

# Link storage for file uploads
php artisan storage:link
```

### Step 4: Build Assets
```bash
npm run build
# OR for development
npm run build
```

### Step 5: Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Default Login Credentials

### Admin Account
- **Email**: admin@sweetdelights.lk  
- **Password**: admin123

### Manager Account
- **Email**: manager@sweetdelights.lk
- **Password**: manager123

### Test Customer Account
- **Email**: customer@example.com
- **Password**: password

## New Features Added

### Modern Bakery Theme
- **Color Palette**: Warm, bakery-inspired colors (#F7EFE7, #E6C9A8, #D88A6A, #FFD9E3, #7A543E)
- **Typography**: Playfair Display for headings, Inter for body text
- **Components**: Responsive cards, modern buttons, smooth animations
- **Accessibility**: Proper contrast ratios, focus states, semantic HTML

### Enhanced Menu Page
- **Search Functionality**: Real-time search through menu items
- **Category Filtering**: Filter by bakery categories (Fresh Bread, Pastries, etc.)
- **Improved Layout**: Consistent 3-column grid with hover effects
- **Better UX**: Loading states, smooth transitions, mobile-optimized

### Admin Product Management
- **Products Table**: Full CRUD operations for bakery products
- **Image Upload**: Secure file handling with validation
- **Category Management**: Link products to menu categories
- **Status Management**: Active/inactive product states

### Security Enhancements
- **Admin Middleware**: `is_admin` flag for enhanced security
- **Input Sanitization**: XSS protection on contact forms
- **Honeypot Protection**: Spam prevention on contact forms
- **File Upload Security**: Restricted file types and size limits

## Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Suites
```bash
# Test admin functionality
php artisan test --filter AdminTest

# Test contact form
php artisan test --filter ContactFormTest

# Test authentication
php artisan test tests/Feature/Auth/
```

## API Endpoints

### Product Management (Admin Only)
```
GET /admin/products - List all products
POST /admin/products - Create new product
GET /admin/products/{id} - Get product details
PUT /admin/products/{id} - Update product
DELETE /admin/products/{id} - Delete product
PATCH /admin/products/{id}/toggle-status - Toggle active status
```

### Manual Testing Checklist

#### 1. Database Setup
- [ ] Run `php artisan migrate` - should complete without errors
- [ ] Run `php artisan db:seed --class=AdminSeeder` - should create admin users
- [ ] Check users table has `is_admin` column: `SELECT is_admin FROM users LIMIT 1;`

#### 2. Admin Access
- [ ] Login with admin@sweetdelights.lk / admin123
- [ ] Access /admin/dashboard - should load successfully
- [ ] Try accessing admin routes as regular user - should get 403 error

#### 3. Product Management
- [ ] Navigate to /admin/products
- [ ] Create new product with image upload
- [ ] Edit existing product
- [ ] Toggle product status
- [ ] Delete product
- [ ] Verify images are stored in storage/app/public/products

#### 4. Contact Form
- [ ] Submit contact form with valid data - should succeed
- [ ] Submit with missing required fields - should show validation errors
- [ ] Submit with honeypot field filled - should be rejected
- [ ] Check contact_messages table for stored data

#### 5. Frontend Theme
- [ ] Check all pages use new bakery color scheme
- [ ] Test menu search functionality
- [ ] Test category filtering on menu page
- [ ] Verify responsive design on mobile devices
- [ ] Check accessibility with screen reader or keyboard navigation

### cURL Examples

#### Create Product (Admin)
```bash
curl -X POST http://localhost:8000/admin/products \
  -H "Content-Type: multipart/form-data" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -F "name=Test Croissant" \
  -F "description=Delicious test croissant" \
  -F "price=250.00" \
  -F "is_active=1" \
  -F "image=@/path/to/image.jpg"
```

#### Update Product
```bash
curl -X PUT http://localhost:8000/admin/products/1 \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{"name":"Updated Croissant","price":300.00,"is_active":true}'
```

#### Delete Product
```bash
curl -X DELETE http://localhost:8000/admin/products/1 \
  -H "X-CSRF-TOKEN: your-csrf-token"
```

## Deployment Notes

### Production Setup
1. Set proper environment variables in `.env`
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Run `php artisan view:cache`
5. Ensure `storage/app/public` is writable
6. Run `php artisan storage:link` on production server

### File Permissions
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

## Database Schema

### Core Tables
- **users**: Customer and admin accounts with role-based access
- **menu_items**: Bakery menu with categories, pricing, and nutritional info
- **orders**: Customer orders with items, pricing, and status tracking
- **reservations**: Table bookings with customer details and preferences
- **loyalty_points**: Point earning/redemption system
- **contact_messages**: Customer inquiries and support tickets
- **newsletter_subscribers**: Email subscription management

## API Documentation

### Public Endpoints
```
GET /api/v1/menu - Get all menu items
GET /api/v1/menu/{id} - Get specific menu item
GET /api/v1/menu/category/{category} - Get items by category
GET /api/v1/menu/featured - Get featured items
POST /api/v1/orders - Place new order
GET /api/v1/orders/{orderId} - Get order details
```

### Protected Endpoints (Requires Authentication)
```
GET /api/v1/user/orders - Get user's orders
GET /api/v1/user/reservations - Get user's reservations
GET /api/v1/user/loyalty - Get loyalty point details
```

## Business Logic

### Loyalty Program
- **Bronze Tier**: 0-499 points (5% discount)
- **Gold Tier**: 500-1,499 points (15% discount)
- **Platinum Tier**: 1,500+ points (25% discount)
- **Point Earning**: 1 point per Rs. 10 spent
- **Reservation Bonus**: 50 points per confirmed reservation

### Order Management
- **Order Statuses**: pending → confirmed → preparing → ready → completed
- **Order Types**: dine_in, takeaway, delivery
- **Tax Calculation**: 10% tax on subtotal
- **Automatic Point Award**: Points credited on order completion

### Reservation System
- **Advance Booking**: Up to 30 days in advance
- **Time Slots**: 30-minute intervals during business hours
- **Guest Limits**: 1-20 people per reservation
- **Status Tracking**: pending → confirmed → completed/cancelled

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Database Reset
```bash
php artisan migrate:fresh --seed
```

## Production Deployment

### Environment Variables
Update `.env` for production:
```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
MAIL_MAILER=smtp
```

### Optimization Commands
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## Support

For technical support or business inquiries:
- **Email**: info@sweetdelights.lk
- **Phone**: +94 77 186 9132
- **Address**: No.1, Mahamegawaththa Road, Maharagama

## License

This project is proprietary software developed for Sweet Delights Bakery.