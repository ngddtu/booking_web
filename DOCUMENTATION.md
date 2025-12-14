# Booking System Documentation

## 1. Project Overview
This is a Hotel Booking System designed for two main user roles:
- **Manager (Admin)**: Has full access to the system, manages rooms, room types, services, and users.
- **Saler (Receptionist)**: Manages customers, bookings, check-ins, check-outs, and services.

## 2. System Architecture

### Roles & Permissions
Roles are defined in `App\Models\User`:
- **Manager** (`role = 0`): Access to all `manager/*` and `room/*` routes.
- **Saler** (`role = 1`): Access to `booking/*`, `customer/*`, and `reserve/*` routes.
- **Middleware**: `App\Http\Middleware\RoleMiddleware` enforces these permissions.

### Database Schema Key Points
- **Bookings**: Tracks the lifecycle of a reservation.
  - Statuses: `pending` (Created), `confirmed` (Checked In), `completed` (Checked Out), `canceled`.
- **Rooms**: Physical rooms.
  - Statuses: `available`, `occupied`, `cleaning`, `maintenance`, `disable`.
- **Invoices & Payments**: Generated automatically upon Check-out.

## 3. Operational Flows

### A. Reservation Flow (Receptionist)
1.  **Create Reservation**:
    - Navigate to `/reserve/reserves`.
    - Select Room (must be `available`), Customer, and Dates.
    - System creates a `Booking` with status `pending`.
2.  **Check-In**:
    - Guest arrives. Receptionist goes to `/booking/manage-booking`.
    - Clicks **Check In**.
    - System updates `Booking` status to `confirmed`.
    - System updates `Room` status to `occupied`.
3.  **Check-Out**:
    - Guest leaves. Receptionist clicks **Check Out**.
    - System calculates total price:
        - Room Price: `Daily Rate` * Number of Days (minimum 1 day).
        - Services Price: Sum of all linked services.
    - System updates `Booking` status to `completed`.
    - System updates `Room` status to `cleaning`.
    - System creates a `Payment` record (Cash default).
    - System creates an `Invoice` record.

### B. Room Management (Manager)
- Managers can add/edit rooms and room types.
- Room Rates (`initial_hour_rate`, `overnight_rate`, `daily_rate`) are defined in `RoomType`.
- **Note**: Current Checkout logic primarily uses `daily_rate`. Future enhancements should implement hourly/overnight logic in `BookingController::checkOut`.

### C. Staff Management (Manager)
- Navigate to **Nhân viên** in the sidebar.
- Click **Thêm nhân viên** to create a new Receptionist account (`role = 1`).
- Managers can view and delete staff accounts.
- **Note**: Managers (`role = 0`) cannot be deleted via this interface.

## 4. Code Structure

### Controllers
- **Manager**: `App\Http\Controllers\Manager` (RoomController, TypeRoomController, RoomServiceController).
- **Saler**: `App\Http\Controllers\Saler` (BookingController, CustomerController, BookingServiceController).
- **Auth**: `App\Http\Controllers\AuthController`.

### Middleware
- `role`: Registered in `bootstrap/app.php`, alias for `RoleMiddleware`.
- Usage: `Route::middleware(['auth', 'role:manager'])`.

### Models
- `User`: Contains `hasRole($role)` and `isAdmin()` helpers.
- `Room`: Contains logic for finding active bookings (`activeBooking` relation).
- `Booking`: Core transactional model.

## 5. Maintenance Guide
- **Adding Roles**: Update `User` model constants and `RoleMiddleware`.
- **Pricing Logic**: Modify `BookingController::checkOut` calculation block.
- **UI Customization**: Views are located in `resources/views/admins` and `resources/views/saler`.

## 6. Setup for New Developers
1.  Clone repository.
2.  Run `composer install` and `npm install`.
3.  Copy `.env.example` to `.env` and configure database.
4.  Run `php artisan migrate`.
5.  Seed a manager account manually or via seeder if available (set `role = 1`).
6.  Run `php artisan serve`.
