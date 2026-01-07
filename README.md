# 🛒 NexTo
**Pass it to the next owner** — A clean, fast, and secure buy/sell marketplace 

**A full-featured buy/sell platform with secure authentication and real-time private messaging**
A dynamic and interactive web application enabling users to buy, sell, and communicate with each other. This project features secure user authentication, listing management, and a private messaging system.

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4.svg?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E.svg?style=for-the-badge&logo=javascript&logoColor=black)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

---

## 📖 Project Overview
A dynamic, responsive **online marketplace** built from scratch using the classic LAMP stack (Linux, Apache, MySQL, PHP). Users can register, post items for sale, browse listings, and securely message sellers—all within a clean and intuitive interface.

This project demonstrates end-to-end web development skills including:
- Secure user authentication & session management
- CRUD operations with image uploads
- One-to-one private messaging system
- Role-based inbox (seller receives messages, buyer sends)
- Responsive front-end design

---

## ✨ Key Features

| Feature                        | Description                                                                 |
|-------------------------------|-----------------------------------------------------------------------------|
| **User Authentication**       | Registration, login, logout with password hashing (`password_hash()`)      |
| **Listing Management**        | Create, read, update, delete listings with multiple image uploads          |
| **Private Messaging**         | Real-time chat between buyer and seller (no page refresh needed via AJAX)  |
| **Dynamic Inbox**             | Sellers see all conversations grouped by listing & buyer                   |
| **Image Uploads**             | Secure upload with file type/size validation, stored in `/images/`         |
| **Responsive Design**         | Mobile-friendly layout using custom CSS + Flexbox/Grid                    |
| **Session Security**          | Protection against session hijacking and fixation                          |

---

## 🛠 Technologies Used

| Layer         | Technology                                    |
|---------------|-----------------------------------------------|
| Backend       | PHP 7.4+ (procedural + OOP concepts)          |
| Frontend      | HTML5, CSS3, Vanilla JavaScript, AJAX         |
| Database      | MySQL 8.0 (with phpMyAdmin for management)    |
| Server        | Apache (via XAMPP)                            |
| Development   | Visual Studio Code, XAMPP Control Panel       |
| Image Handling| PHP GD library + `move_uploaded_file()`       |

---

## 📂 Project Structure

marketplace/
├── home.php → Main landing page with all listings
├── login.php → Login form & authentication
├── register.php → User registration with validation
├── listing.php → View single listing + message form
├── chat.php → AJAX-powered messaging interface
├── admin_inbox.php → Seller's unified inbox (all conversations)
├── add_listing.php → Form to create new listing
├── edit_listing.php → Edit existing listing
├── delete_listing.php → Soft/Hard delete listing
├── logout.php → Destroy session
├── css/
│ └── homeStyle.css → All custom styling
├── images/ → Uploaded listing images
├── db/
│ └── marketplace.sql → Complete database schema + sample data
├── includes/
│ ├── db_connect.php → Database connection
│ └── functions.php → Reusable functions (optional)
└── README.md


---

## 🎯 Future Enhancements (In-progress roadmap)
 User profiles & ratings system
 Search & category filters
 Location-based listings
 Email notifications
 Admin dashboard
 Switch to PDO + OOP structure
 Deploy using Docker

## 🚀 Setup & Installation (Local Development)

### Prerequisites
- XAMPP / WAMP / LAMP stack
- Browser (Chrome/Firefox recommended)

### Steps
1. **Clone or download** this repository
   ```bash
   git clone https://github.com/priyankpriyank/marketplace-web-app.git

 
## 📄 License
This project is licensed under the MIT License – see the LICENSE file for details.
**Author**: &copy;Priyank Vora |


