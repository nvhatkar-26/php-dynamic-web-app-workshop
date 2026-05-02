# 🛠️ Installation Guide

Follow these steps to set up and run the PHP Dynamic Web Application project on your system.

---

## 📌 Prerequisites

Make sure you have the following installed:

* XAMPP (Apache + MySQL): https://www.apachefriends.org/download.html
* Code Editor (VS Code recommended): https://code.visualstudio.com/download
* Web Browser (Chrome/Edge)

---

## ⬇️ Step 1: Download the Project

### Option 1: Clone using Git

```bash
git clone https://github.com/YOUR_USERNAME/php-dynamic-web-app-workshop.git
```

### Option 2: Download ZIP

* Click "Code" on GitHub
* Select "Download ZIP"
* Extract the folder

---

## 📁 Step 2: Move Project to XAMPP

1. Go to your XAMPP installation folder:

   ```
   C:\xampp\htdocs\
   ```
2. Copy the project folder:

   ```
   php-dynamic-web-app-workshop
   ```
3. Paste it inside `htdocs`

---

## ▶️ Step 3: Start Server

1. Open XAMPP Control Panel
2. Start:

   * Apache ✅
   * MySQL ✅

---

## 🗄️ Step 4: Setup Database

1. Open browser and go to:

   ```
   http://localhost/phpmyadmin/
   ```

2. Click **New** → Create database:

   ```
   php_workshop
   ```

3. Click on the database → Go to **Import**

4. Select file:

   ```
   setup/database.sql
   ```

5. Click **Go**

---

## 🌐 Step 5: Run the Project

Open browser and go to:

```
http://localhost/php-dynamic-web-app-workshop/final-project/
```

---

## ✅ Expected Output

You should see:

* Student list page
* Option to add student
* CRUD functionality working

---

## ❗ Troubleshooting

### 🔴 Apache not starting

* Check if port 80 is already in use

### 🔴 MySQL not starting

* Check port 3306 conflict

### 🔴 Database connection error

* Verify:

  * Username = root
  * Password = (empty)

### 🔴 Page not found

* Ensure project is inside:

  ```
  htdocs
  ```

---

## 🎯 You're Ready!

Now you can start building and modifying the application 🚀
