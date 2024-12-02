-- Connect to the database: testdb

CREATE TABLE authors (
                         id SERIAL PRIMARY KEY,
                         name TEXT NOT NULL,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE books (
                       id SERIAL PRIMARY KEY,
                       author_id INT NOT NULL,
                       title TEXT NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       CONSTRAINT fk_author FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE
);
GRANT CONNECT ON DATABASE testdb TO testuser;
GRANT USAGE ON SCHEMA public TO testuser;
GRANT SELECT, INSERT, UPDATE, DELETE ON authors TO testuser;
GRANT SELECT, INSERT, UPDATE, DELETE ON books TO testuser;
GRANT USAGE, SELECT ON SEQUENCE authors_id_seq TO testuser;
GRANT USAGE, SELECT ON SEQUENCE books_id_seq TO testuser;
