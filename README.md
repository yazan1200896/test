Here’s a **README** file template that provides documentation for the APIs in your project. It describes the available API endpoints, expected request types, and examples.

---

# **API Documentation**

## **Overview**

This API provides access to a car service management system. The API allows users to manage car services, create and manage tickets, view and update user information, and more. The API supports CRUD (Create, Read, Update, Delete) operations for various resources such as users, services, cars, tickets, and messages.

## **Base URL**
```
http://localhost/index.php
```

## **Authentication**
- This API does not require authentication for the actions listed below.
- However, for certain actions (like user registration or login), credentials are required.

## **Endpoints**

### 1. **Get Services**
**Endpoint:** `/index.php?action=get_services`  
**Method:** `GET`  
**Description:** Retrieve a list of all available services.

#### Example Request:
```
GET http://localhost/index.php?action=get_services
```

#### Example Response:
```json
[
  {
    "name": "Oil Change",
    "propriety_price": 50.00,
    "des": "Basic oil change service for cars.",
    "image": "oil_change.jpg"
  },
  {
    "name": "Tire Replacement",
    "propriety_price": 100.00,
    "des": "Replacing old tires with new ones.",
    "image": "tire_replacement.jpg"
  }
]
```

---

### 2. **Get Ticket Date**
**Endpoint:** `/index.php?action=get_ticket_date`  
**Method:** `GET`  
**Parameters:**
- `ticket_id` (required): The ID of the ticket for which you want to retrieve the date.

#### Example Request:
```
GET http://localhost/index.php?action=get_ticket_date&ticket_id=12345
```

#### Example Response:
```json
{
  "ticket_id": 12345,
  "carid": "ABC1234",
  "name": "Oil Change",
  "price": 50.00,
  "username": "user1",
  "date": "2025-01-05",
  "stat": "pending",
  "year": 2025
}
```

---

### 3. **Get Net Profit + Expenses + Selling**
**Endpoint:** `/index.php?action=get_net_profit`  
**Method:** `GET`  
**Description:** Retrieve net profit, total expenses, and total selling price.

#### Example Request:
```
GET http://localhost/index.php?action=get_net_profit
```

#### Example Response:
```json
{
  "net_profit": 2000.00,
  "expenses": 500.00,
  "total_selling": 2500.00
}
```

---

### 4. **Manage Service (Add/Edit/Delete Service)**
**Endpoint:** `/index.php?action=manage_service`  
**Method:** `POST`  
**Parameters (for adding a service):**
- `type`: Action type (`add`, `edit`, `delete`)
- `name`: Name of the service.
- `propriety_price`: Price for the service.
- `des`: Description of the service.
- `image`: Image filename associated with the service.

#### Example Request (Add Service):
```json
{
  "type": "add",
  "name": "Car Wash",
  "propriety_price": 30.00,
  "des": "Quick car wash service",
  "image": "car_wash.jpg"
}
```

#### Example Response:
```json
{
  "message": "Service added successfully"
}
```

---

### 5. **Add Message / Get Messages**
**Endpoint:** `/index.php?action=manage_msg`  
**Method:** `POST` (for adding a message), `GET` (for retrieving messages)  
**Parameters (for adding a message):**
- `from_user`: Username of the sender.
- `to_user`: Username of the receiver.
- `date`: Date and time when the message was sent.
- `title`: Title of the message.
- `detelis`: Message content.

#### Example Request (Add Message):
```json
{
  "from_user": "user1",
  "to_user": "user2",
  "date": "2025-01-05 10:00:00",
  "title": "Car Service Inquiry",
  "detelis": "How long will the tire replacement take?"
}
```

#### Example Response:
```json
{
  "message": "Message sent successfully"
}
```

---

### 6. **Add Ticket + Car Model**
**Endpoint:** `/index.php?action=add_ticket_car_model`  
**Method:** `POST`  
**Parameters:**
- `carid`: The car ID associated with the ticket.
- `name`: Service name.
- `price`: Service price.
- `username`: Username of the user.
- `date`: Date of the service.
- `stat`: Status of the service (pending, complete, etc.).
- `year`: Year of service.

#### Example Request:
```json
{
  "carid": "ABC1234",
  "name": "Oil Change",
  "price": 50.00,
  "username": "user1",
  "date": "2025-01-05",
  "stat": "pending",
  "year": 2025
}
```

#### Example Response:
```json
{
  "message": "Ticket added successfully"
}
```

---

### 7. **Get All Tickets with 'Complete' Status for User**
**Endpoint:** `/index.php?action=get_all_complete_tickets`  
**Method:** `GET`  
**Parameters:**
- `username` (required): The username of the user.

#### Example Request:
```
GET http://localhost/index.php?action=get_all_complete_tickets&username=user1
```

#### Example Response:
```json
[
  {
    "ticket_id": 12345,
    "carid": "ABC1234",
    "name": "Oil Change",
    "price": 50.00,
    "username": "user1",
    "date": "2025-01-05",
    "stat": "complete",
    "year": 2025
  }
]
```

---

### 8. **Add Car**
**Endpoint:** `/index.php?action=add_car`  
**Method:** `POST`  
**Parameters:**
- `carid`: Car ID (exactly 7 characters).
- `type`: Car type (Sedan, SUV, etc.).
- `model`: Car model.
- `year`: Year of manufacture (must be > 1986).
- `username`: Username of the user.
- `fuel_type`: Type of fuel (Petrol, Diesel, Electric, etc.).

#### Example Request:
```json
{
  "carid": "ABC1234",
  "type": "Sedan",
  "model": "Honda Civic",
  "year": 2018,
  "username": "user1",
  "fuel_type": "Petrol"
}
```

#### Example Response:
```json
{
  "message": "Car added successfully"
}
```

---

### 9. **Get User Information**
**Endpoint:** `/index.php?action=get_user_info`  
**Method:** `GET`  
**Parameters:**
- `username` (required): The username of the user.

#### Example Request:
```
GET http://localhost/index.php?action=get_user_info&username=user1
```

#### Example Response:
```json
{
  "username": "user1",
  "email": "user1@example.com",
  "phone": "1234567890",
  "type": "user",
  "password": "password123"
}
```

---

### 10. **Check If Username is Available**
**Endpoint:** `/index.php?action=is_username_available`  
**Method:** `GET`  
**Parameters:**
- `username` (required): The username to check.

#### Example Request:
```
GET http://localhost/index.php?action=is_username_available&username=user1
```

#### Example Response:
```json
{
  "available": false
}
```

---

### 11. **Update User Information**
**Endpoint:** `/index.php?action=update_user_info`  
**Method:** `POST`  
**Parameters:**
- `username`: The username of the user.
- `email`: New email.
- `phone`: New phone number.
- `type`: New user type.

#### Example Request:
```json
{
  "username": "user1",
  "email": "newemail@example.com",
  "phone": "9876543210",
  "type": "admin"
}
```

#### Example Response:
```json
{
  "message": "User information updated successfully"
}
```

---

### 12. **Check Login**
**Endpoint:** `/index.php?action=check_login`  
**Method:** `POST`  
**Parameters:**
- `username` (required): The username of the user.
- `password` (required): The user's password.

#### Example Request:
```json
{
  "username": "user1",
  "password": "password123"
}
```

#### Example Response:
```json
{
  "login_success": true
}
```

---

### 13. **Sign Up + Check Username Availability**
**Endpoint:** `/index.php?action=sign_up`  
**Method:** `POST`  
**Parameters:**
- `username`: The username of the new user.
- `email`: The email address.
- `phone`: The phone number.
- `type`: The type of user (`user` or `admin`).
-

 `password`: The password for the account.

#### Example Request:
```json
{
  "username": "user3",
  "email": "user3@example.com",
  "phone": "1122334455",
  "type": "user",
  "password": "newpassword123"
}
```

#### Example Response:
```json
{
  "message": "User signed up successfully"
}
```

---

### 14. **Get All Tickets with Car Info**
**Endpoint:** `/index.php?action=get_all_tickets_with_car_info`  
**Method:** `GET`  
**Parameters:**
- `username`: The username of the user.

#### Example Request:
```
GET http://localhost/index.php?action=get_all_tickets_with_car_info&username=user1
```

#### Example Response:
```json
[
  {
    "ticket_id": 12345,
    "carid": "ABC1234",
    "name": "Oil Change",
    "price": 50.00,
    "username": "user1",
    "date": "2025-01-05",
    "stat": "pending",
    "year": 2025,
    "car_model": "Honda Civic"
  }
]
```

---

## **Conclusion**
This API provides the functionality to manage users, services, cars, tickets, and messages related to a car service management system. By using the provided endpoints, users can interact with the system, including creating, reading, updating, and deleting data.

Let me know if you need additional information or clarifications!
