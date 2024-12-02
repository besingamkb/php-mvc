create DATABASE testdb;

CREATE USER testuser WITH PASSWORD 'password';

GRANT USAGE ON SCHEMA public TO testuser;

ALTER DEFAULT PRIVILEGES  IN SCHEMA public GRANT ALL PRIVILEGES ON TABLES TO testuser;



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

CREATE OR REPLACE FUNCTION insert_books_with_authors(book_data JSONB)
    RETURNS VOID AS $$
DECLARE
    book_record JSONB;
    book_title VARCHAR;
    author_name VARCHAR;
    author_id INT;
BEGIN
    IF NOT (jsonb_typeof(book_data) = 'array') THEN
        RAISE EXCEPTION 'Input must be a JSONB array';
    END IF;

    FOR book_record IN SELECT * FROM jsonb_array_elements(book_data)
        LOOP
            book_title := book_record->>'title';
            author_name := book_record->>'author';

            IF book_title IS NULL OR author_name IS NULL THEN
                CONTINUE;
            END IF;

            SELECT id INTO author_id FROM authors WHERE name = author_name;
            IF NOT FOUND THEN
                INSERT INTO authors (name) VALUES (author_name) RETURNING id INTO author_id;
            END IF;

            IF NOT EXISTS (
                SELECT 1 FROM books WHERE title = book_title
            ) THEN
                INSERT INTO books (title, author_id) VALUES (book_title, author_id);
            END IF;
        END LOOP;
END;
$$ LANGUAGE plpgsql;


GRANT CONNECT ON DATABASE testdb TO testuser;
GRANT USAGE ON SCHEMA public TO testuser;
GRANT SELECT, INSERT, UPDATE, DELETE ON authors TO testuser;
GRANT SELECT, INSERT, UPDATE, DELETE ON books TO testuser;
GRANT USAGE, SELECT ON SEQUENCE authors_id_seq TO testuser;
GRANT USAGE, SELECT ON SEQUENCE books_id_seq TO testuser;
