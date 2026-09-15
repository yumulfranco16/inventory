INVENTORY SYSTEM - ADMIN/USER UPGRADE

Features:
- Administrator and regular User roles
- Admin-only user management
- Add/edit/delete users
- Activate/deactivate users
- Admin can reset any user's password
- Users can change their own password
- At least one active administrator is protected
- Inactive accounts cannot log in
- Passwords use PHP password_hash/password_verify

DATABASE:
If upgrading an existing database, import user_roles_migration.sql once.
If creating a fresh database, import inventory_db.sql, then user_roles_migration.sql.

DEFAULT LOGIN:
Username: admin
Password: use the password already configured in your existing database.

IMPORTANT:
Do not expose config/database.php publicly. Use a proper PHP web server with the public/ folder as the document root when possible.
