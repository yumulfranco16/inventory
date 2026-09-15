-- Run this ONCE against an existing inventory_db.
ALTER TABLE users ADD COLUMN role ENUM('admin','user') NOT NULL DEFAULT 'user' AFTER password;
ALTER TABLE users ADD COLUMN status ENUM('active','inactive') NOT NULL DEFAULT 'active' AFTER role;
UPDATE users SET role='admin', status='active' WHERE username='admin';
