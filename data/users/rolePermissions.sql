CREATE TABLE IF NOT EXISTS role_permissions (
    role_code VARCHAR(50) NOT NULL,
    permission_code VARCHAR(50) NOT NULL,
    FOREIGN KEY (role_code) REFERENCES roles(code) ON DELETE CASCADE,
    FOREIGN KEY (permission_code) REFERENCES permissions(code) ON DELETE CASCADE,
    PRIMARY KEY (role_code, permission_code)
);
