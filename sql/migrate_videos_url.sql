-- Ampliar columnas url y thumbnail de videos para soportar URLs largas
ALTER TABLE videos MODIFY COLUMN url TEXT NOT NULL;
ALTER TABLE videos MODIFY COLUMN thumbnail TEXT DEFAULT NULL;
