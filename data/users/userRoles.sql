CREATE TABLE IF NOT EXISTS user_roles (
    user_id INT NOT NULL,
    role_code VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_code) REFERENCES roles(code) ON DELETE CASCADE,
    PRIMARY KEY (user_id, role_code)
);
