# Test Cases for Booking System

This document outlines the test cases for the Booking System project. These tests cover the core functionalities including Authentication, Room Management, Customer Management, and Booking operations.

## 1. Authentication Module

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC001** | **User Login - Success** | User account exists | 1. Navigate to `/login`.<br>2. Enter valid email and password.<br>3. Click Login. | User is redirected to the dashboard/home page. |
| **TC002** | **User Login - Failure** | N/A | 1. Navigate to `/login`.<br>2. Enter invalid email or password.<br>3. Click Login. | Error message "Invalid login" is displayed. User remains on login page. |
| **TC003** | **User Registration - Success** | N/A | 1. Navigate to `/register`.<br>2. Enter valid Name, Email, Phone, Password, and Confirm Password.<br>3. Click Register. | User is redirected to login page (or auto-logged in). |
| **TC004** | **User Registration - Validation** | User with email already exists | 1. Navigate to `/register`.<br>2. Enter an existing email address.<br>3. Click Register. | Validation error message "The email has already been taken" is displayed. |
| **TC005** | **User Logout** | User is logged in | 1. Click the Logout button/link. | User is logged out and redirected to the login page with success message. |

## 2. Room Type Management (Manager)

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC006** | **View Room Types** | User is logged in | 1. Navigate to `/room/manage-type-room`. | List of existing room types is displayed. |
| **TC007** | **Add Room Type - Success** | User is logged in | 1. Navigate to `/room/manage-type-room`.<br>2. Fill in Room Type Name, Price, Description.<br>3. Submit form. | New room type is added and displayed in the list. |
| **TC008** | **Update Room Type** | User is logged in | 1. Select a room type to edit.<br>2. Change Name or Price.<br>3. Submit update. | Room type details are updated successfully. |
| **TC009** | **Filter Room Types** | User is logged in | 1. Use the filter form on `/room/manage-type-room`.<br>2. Enter search criteria.<br>3. Submit. | List shows only room types matching the criteria. |

## 3. Room Management (Manager)

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC010** | **View Rooms** | User is logged in | 1. Navigate to `/room/manage-room`. | List of rooms is displayed with their status and type. |
| **TC011** | **Add Room - Success** | Room Types exist | 1. Navigate to `/room/manage-room`.<br>2. Click Add Room.<br>3. Enter Room Name/Number, Select Room Type.<br>4. Submit. | New room is created and appears in the list. |
| **TC012** | **Update Room** | User is logged in | 1. Select a room to edit.<br>2. Change details (e.g., Status, Type).<br>3. Submit. | Room details are updated. |
| **TC013** | **Filter Rooms** | User is logged in | 1. Use filter on `/room/manage-room`.<br>2. Filter by Room Type or Status. | List updates to show relevant rooms. |

## 4. Service Management (Manager)

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC014** | **View Services** | User is logged in | 1. Navigate to `/room/manage-services`. | List of available services is displayed. |
| **TC015** | **Add Service** | User is logged in | 1. Enter Service Name and Price.<br>2. Submit. | New service is added to the system. |
| **TC016** | **Update Service** | User is logged in | 1. Edit an existing service.<br>2. Change Price or Name.<br>3. Submit. | Service is updated. |
| **TC017** | **Delete Service** | User is logged in | 1. Click Delete on a service. | Service is removed from the list. |

## 5. Customer Management (Saler)

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC018** | **View Customers** | User is logged in | 1. Navigate to `/customer/manage-customer`. | List of customers is displayed. |
| **TC019** | **Filter Customers** | User is logged in | 1. Search for a customer by name or phone.<br>2. Submit. | Correct customer record is displayed. |

## 6. Booking & Reservation (Saler)

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC020** | **View Bookings** | User is logged in | 1. Navigate to `/booking/manage-booking`. | List of all bookings is displayed. |
| **TC021** | **Create Reservation** | Rooms available | 1. Navigate to `/reserve/reserves`.<br>2. Select Room, Customer, Dates.<br>3. Confirm Reservation. | Booking is created and room status is updated. |
| **TC022** | **Update Booking Services** | Booking exists | 1. Select a booking.<br>2. Add/Update services used.<br>3. Save. | Booking total is updated to reflect service charges. |

## 7. Security & Access Control

| ID | Test Case | Pre-conditions | Test Steps | Expected Result |
| :--- | :--- | :--- | :--- | :--- |
| **TC023** | **Unauthenticated Access** | User is NOT logged in | 1. Try to access `/room/manage-room`. | User is redirected to `/login`. |
| **TC024** | **CSRF Protection** | N/A | 1. Attempt to submit a form (e.g., Login) without CSRF token. | Request is rejected (419 Page Expired). |
