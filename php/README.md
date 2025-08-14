# 🛡️ Secure Blog Management System

A simple and secure web-based blog management system built using **PHP**, **MySQL**, **HTML/CSS**, and **Bootstrap**. This system allows users to create, edit, delete, and view blog posts with a secure authentication system.

---

## 🔧 Features

- 🔐 User Authentication (Login/Logout)
- 📝 Create, Edit, Delete Blog Posts
- 📃 View All Posts (Public)
- 🧑 Admin Dashboard
- 🗃️ MySQL Database Integration
- 🎨 Responsive UI with Bootstrap
- ✅ Input Validation and Output Sanitization
- 📂 Clean File Structure with Includes (Header/Footer)

---

## 🧱 Technologies Used

- **Frontend**: HTML, CSS, Bootstrap
- **Backend**: PHP (Procedural or OOP)
- **Database**: MySQL
- **Security**: Session-based Authentication, `htmlspecialchars`, `mysqli_real_escape_string`

---

## 📁 Project Structure

secure-blog/
│
├── db.php # Database connection
├── login.php # Login form
├── logout.php # Logout handler
├── dashboard.php # Admin dashboard
│
├── add_post.php # Add new post
├── edit_post.php # Edit existing post
├── delete_post.php # Delete post
├── view_post.php # View single post
├── index.php # Public homepage showing all posts
│
├── includes/
│ ├── header.php # Reusable header
│ └── footer.php # Reusable footer
│
├── css/
│ └── style.css # Custom styles
└── README.md # Project documentation


How to run:

1)git clone https://github.com/parameshwar21/Secure-Blog-Management-System.git.

2)C:\xampp\htdocs\Secure-Blog-Management-System.

3)Start Apache and MySQL using XAMPP/WAMP.

4)Create a MySQL Database.

5)Configure Database Connection.

6)Access the App.
