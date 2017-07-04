    
CREATE TABLE IF NOT EXISTS logs (
    id          SERIAL NOT NULL PRIMARY KEY,
    ip       	VARCHAR(20) NOT NULL,
    os          VARCHAR(20) NULL,
    browser     VARCHAR(20) NULL,
    url_from    VARCHAR(50),
    url_to      VARCHAR(50),
    date        DATE,
    time        TIME
);

