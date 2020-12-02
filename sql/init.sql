CREATE TABLE IF NOT EXISTS informations (
       id SERIAL PRIMARY KEY,
       n TEXT UNIQUE,
       formName TEXT,
       notice TEXT
);

CREATE TABLE IF NOT EXISTS answers (
       id SERIAL PRIMARY KEY,
       n TEXT NOT NULL,
       name TEXT,
       mon1 INTEGER DEFAULT 0,
       mon2 INTEGER DEFAULT 0,
       mon3 INTEGER DEFAULT 0,
       mon4 INTEGER DEFAULT 0,
       mon5 INTEGER DEFAULT 0,
       tue1 INTEGER DEFAULT 0,
       tue2 INTEGER DEFAULT 0,
       tue3 INTEGER DEFAULT 0,
       tue4 INTEGER DEFAULT 0,
       tue5 INTEGER DEFAULT 0,
       wed1 INTEGER DEFAULT 0,
       wed2 INTEGER DEFAULT 0,
       wed3 INTEGER DEFAULT 0,
       wed4 INTEGER DEFAULT 0,
       wed5 INTEGER DEFAULT 0,
       thu1 INTEGER DEFAULT 0,
       thu2 INTEGER DEFAULT 0,
       thu3 INTEGER DEFAULT 0,
       thu4 INTEGER DEFAULT 0,
       thu5 INTEGER DEFAULT 0,
       fri1 INTEGER DEFAULT 0,
       fri2 INTEGER DEFAULT 0,
       fri3 INTEGER DEFAULT 0,
       fri4 INTEGER DEFAULT 0,
       fri5 INTEGER DEFAULT 0
       -- FOREIGN KEY (n) REFERENCES informations(n) ON DELETE SET NULL ON UPDATE CASCADE
);